<?php

namespace Tests\Feature\Feature;
use App\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
	 
	
   public function testValidateLoginData()
    {
        
		$user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')
                         ->get('api/v1/me');
        $response->assertSuccessful()
                 ->assertJson($user->toArray());
                        
    }

   
    public function testUserLoginsSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'asif12345@test.com',
            'password' => bcrypt('asif12345'),

        ]);

        $data = ['email' => 'asif12345@test.com', 'password' => 'asif12345'];

        $this->json('POST', 'api/v1/login', $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ]);

    }

   

}