<?php

namespace Tests\Feature;
use App\Models\Donor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonorControllerTest extends TestCase
{
    use RefreshDatabase;


    public function setUp() :void {
        parent::setUp();

        $users = User::factory()->count(1)->create();
        $user = $users[0];
        $this->actingAs($user);
    }

    public function test_list_allDataGood_pass()
    {
        $users = Donor::factory()->count(5)->create();

        $response = $this->json('GET', 'api/donors');
        $this->assertTrue($response->getOriginalContent()->count() == $users->count());
        $this->assertArrayNotHasKey("password",$response->getOriginalContent()->toarray());
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'swish_number',
                    'subscribed_to_newsletter',
                    'verified',
                    'blocked',
                    'closed',
                ]
            ]
        ]);
    }

    public function test_create_AllDataGood_pass()
    {
        $donor = Donor::factory()->count(1)->make()[0]; // it will not insert to database
        $donor = $donor->toArray();
        $donor["password"] = "12345678";
        $response = $this->json('POST', 'api/donors',$donor);
        unset($donor["password"]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('donors', $donor);
        $this->assertArrayNotHasKey("password",$response->getOriginalContent()->toarray());
    }

    public function test_update_AllDataGood_pass()
    {
        $oldDonor = Donor::factory()->count(1)->create()[0];
        $newDonorData = Donor::factory()->count(1)->make()[0]; // it will not insert to database
        $newDonorData = $newDonorData->toArray();
        $newDonorData["id"] = $oldDonor->id;
        $response = $this->json('PUT', 'api/donors',$newDonorData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('donors', $newDonorData);
        $this->assertArrayNotHasKey("password",$response->getOriginalContent()->toarray());
    }

}
