<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Receiver;
use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $users = User::factory()->count(1)->create();
        $user = $users[0];
        $this->actingAs($user);
        $this->seed(CurrencySeeder::class);
    }

    public function test_list_allDataGood_pass()
    {
        $receivers = Receiver::factory()->count(1)->hasAccounts(4)->create()[0];
        $response = $this->json('GET', "api/receivers/{$receivers->id}/accounts");
        $this->assertTrue($response->getOriginalContent()->count() == $receivers->accounts->count());
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'currency',
                'initial_balance',
                'income',
                'outcome',
                'left',
                'type_id',
                'receiver_id',
            ]
        ]);
    }

    public function test_create_AllDataGood_pass()
    {
        $receiver = Receiver::factory()->count(1)->create()[0];
        $account = Account::factory()->make(["receiver_id" => $receiver->id]);
        $account = $account->toArray();
        $response = $this->json('POST', "api/receivers/{$receiver->id}/accounts", $account);
        $response->assertStatus(200);
        $this->assertDatabaseHas('r_accounts', $account);
        $this->assertDatabaseCount('r_accounts', 1);
    }

    public function test_create_InvalidInitial_balance_failed()
    {
        $receiver = Receiver::factory()->count(1)->create()[0];
        $account = Account::factory()->make([
            "receiver_id" => $receiver->id,
            "initial_balance" => -10,
        ]);
        $account = $account->toArray();
        $response = $this->json('POST', "api/receivers/{$receiver->id}/accounts", $account);
        $response->assertStatus(422);
        $this->assertDatabaseCount('r_accounts', 0);
    }

    public function test_create_EmptyName_failed()
    {
        $receiver = Receiver::factory()->count(1)->create()[0];
        $account = Account::factory()->make([
            "receiver_id" => $receiver->id,
            "name" => ""
        ]);

        $account = $account->toArray();
        $response = $this->json('POST', "api/receivers/{$receiver->id}/accounts", $account);
        $response->assertStatus(422);
        $this->assertDatabaseCount('r_accounts', 0);
    }

    public function test_update_AllDataGood_pass()
    {
        $receiver = Receiver::factory()->count(1)->hasAccounts(4)->create()[0];
        $account = Account::factory()->make([
            "id" => $receiver->accounts[0]->id,
            "receiver_id" => $receiver->id,
        ]);
        unset($account["currency"]);
        $account = $account->toArray();
        $response = $this->json('PUT', "api/receivers/{$receiver->id}/accounts", $account);
        $response->assertStatus(200);
        $this->assertDatabaseHas('r_accounts', $account);
        $this->assertDatabaseCount('r_accounts', 4);
    }

    public function test_update_tryToUpdateCurrency_passWithoutCurrencyUpdate()
    {
        $receiver = Receiver::factory()->count(1)->hasAccounts(1, ["currency" => "USD"])->create()[0];
        $account = Account::factory()->make([
            "id" => $receiver->accounts[0]->id,
            "receiver_id" => $receiver->id,
            "currency" => "TRY"
        ]);
        $account = $account->toArray();
        $response = $this->json('PUT', "api/receivers/{$receiver->id}/accounts", $account);
        $response->assertStatus(200);
        $account["currency"] = "USD"; //reverted back and check in database that it's the same
        $this->assertDatabaseHas('r_accounts', $account);
        $this->assertDatabaseCount('r_accounts', 1);
    }

    public function test_update_ConfirmLeftColumnIsUpdatedAfterUpdatingInitialBalance_pass()
    {
        $balance = [
            "income" => 1010,
            "outcome" => 10,
            "initial_balance" => 1000,
            "left" => 2000,
        ];
        $receiver = Receiver::factory()->count(1)->hasAccounts(1, $balance)->create()[0];
        $account = Account::factory()->make([
            "id" => $receiver->accounts[0]->id,
            "receiver_id" => $receiver->id,
            "initial_balance" => 0
        ]);
        $account = $account->toArray();
        $response = $this->json('PUT', "api/receivers/{$receiver->id}/accounts", $account);
        $response->assertStatus(200);
        $account["currency"] = "USD"; //reverted back and check in database that it's the same
        $updatedAccount = Account::find($receiver->accounts[0]->id);
        $this->assertEquals(0, $updatedAccount->initial_balance);
        $this->assertEquals(1000, $updatedAccount->left);
    }

    public function test_search_NoFilter_pass()
    {
        $receiver = Receiver::factory()->count(2)->hasAccounts(3)->create();
        $response = $this->json('GET', "api/accounts/search");
        $response->assertStatus(200);
        $this->assertTrue($response->getOriginalContent()->count() == 6);
    }

    public function test_search_filterByCurrency_pass()
    {
        Receiver::factory()->count(4)->hasAccounts(3, ["currency" => "USD"])->create();
        Receiver::factory()->count(2)->hasAccounts(1, ["currency" => "TRY"])->create();
        $response = $this->json('GET', "api/accounts/search?currency=TRY");
        $response->assertStatus(200);
        $this->assertTrue($response->getOriginalContent()->count() == 2);
    }

    public function test_search_withFilterCheckOnlyActive_pass()
    {
        Receiver::factory()->count(4)->hasAccounts(3, ["status" => "inactive"])->create();
        Receiver::factory()->count(2)->hasAccounts(1, ["currency" => "TRY"])->create();
        $response = $this->json('GET', "api/accounts/search");
        $response->assertStatus(200);
        $this->assertTrue($response->getOriginalContent()->count() == 2);
    }

    public function test_search_ExceptReceiver_pass()
    {
        $receiver = Receiver::factory()->count(1)->hasAccounts(3, ["currency" => "USD"])->create()[0];
        Receiver::factory()->count(2)->hasAccounts(1, ["currency" => "TRY"])->create();
        $response = $this->json('GET', "api/accounts/search?q={$receiver->name}");
        $response->assertStatus(200);
        $this->assertTrue($response->getOriginalContent()->count() == 3);
    }
}
