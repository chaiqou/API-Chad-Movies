<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
	public function test_user_can_be_fetched()
	{
		$user = User::factory()->create();
		$response = $this->actingAs($user)->get('/api/users');
		$response->assertStatus(200);
		$response->assertJsonStructure(['data' => ['id', 'name', 'email', 'profile_image']]);
	}
}
