<?php

namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_allDataGood_pass()
    {
        $users = User::factory()->count(5)->create();
        $user = $users[0];
        $this->actingAs($user);
        $response = $this->json('GET', 'api/users');
        $this->assertTrue($response->getOriginalContent()->count() == $users->count());
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email'
                ]
            ]
        ]);
    }

    public function test_create_allDataGood_pass()
    {
        $users = User::factory()->count(1)->create();
        $user = $users[0];
        $this->actingAs($user);

        $input = [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => "12345678",
        ];

        $response = $this->json('POST', 'api/users',$input);
        unset($input["password"]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $input);
        $this->assertArrayNotHasKey("password",$response->getOriginalContent()->toarray());
    }

    public function test_update_allDataGood_pass()
    {
        $users = User::factory()->count(1)->create();
        $user = $users[0];
        $this->actingAs($user);

        $input = [
            'id' => $user->id,
            'name' => 'Test User',
            'email' => "email@test.test",
        ];

        $response = $this->json('PUT', 'api/users',$input);
        $response->assertJson($input);
        $response->assertStatus(200);
        $response->assertJson($input);
        $this->assertArrayNotHasKey("password",$response->getOriginalContent()->toArray());
    }

    public function test_update_invalidEmail_fail()
    {
        $users = User::factory()->count(1)->create();
        $user = $users[0];
        $this->actingAs($user);

        $input = [
            'id' => $user->id,
            'name' => 'Test User',
            'email' => "emailtest.test",
        ];

        $response = $this->json('PUT', 'api/users',$input);
        $response->assertStatus(422);
    }

    public function test_update_MissingName_fail()
    {
        $users = User::factory()->count(1)->create();
        $user = $users[0];
        $this->actingAs($user);

        $input = [
            'id' => $user->id,
            'email' => "emailt@est.test",
        ];

        $response = $this->json('PUT', 'api/users',$input);
        $response->assertStatus(422);
    }

    public function test_notAuthenticated_fail()
    {
        User::factory()->count(1)->create();
        $response = $this->json('GET', 'api/users');
        $response->assertStatus(401);
    }

}
