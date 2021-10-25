<?php

namespace Tests\Feature;
use App\Models\Receiver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceiverControllerTest extends TestCase
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
        $receivers = Receiver::factory()->count(5)->create();
        $response = $this->json('GET', 'api/receivers');
        $this->assertTrue($response->getOriginalContent()->count() == $receivers->count());
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'status',
                ]
            ]
        ]);
    }

    public function test_create_AllDataGood_pass()
    {
        $receiver = Receiver::factory()->count(1)->make()[0]; // it will not insert to database
        $receiver = $receiver->toArray();
        $response = $this->json('POST', 'api/receivers',$receiver);
        $response->assertStatus(200);
        $this->assertDatabaseHas('r_receivers', $receiver);
    }

    public function test_update_AllDataGood_pass()
    {
        $oldReceiver = Receiver::factory()->count(1)->create()[0];
        $newReceiverData = Receiver::factory()->count(1)->make()[0]; // it will not insert to database
        $newReceiverData = $newReceiverData->toArray();
        $newReceiverData["id"] = $oldReceiver->id;
        $response = $this->json('PUT', 'api/receivers',$newReceiverData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('r_receivers', $newReceiverData);
    }
}
