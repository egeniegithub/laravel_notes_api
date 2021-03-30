<?php

namespace Tests\Feature;


use App\Models\notes;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class CreateNoteTest extends TestCase
{
    /**
     * A basic feature test createnote.
     *
     * @return void
     */
    public function test_createnote()
    {
		$user = factory(User::class)->create();
		$data=[
                'name' => 'test note name',
                'description' => 'test note description',
                'user_id' => $user->id,
            ];
        $response = $this->actingAs($user)
            ->post('/api/v1/createnote', $data);
        $response->assertStatus(200);
    }
	
	
	
	
	
}
