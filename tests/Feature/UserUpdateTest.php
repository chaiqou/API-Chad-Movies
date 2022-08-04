<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
	public function test_user_can_update_profile_image()
	{
		$this->withoutExceptionHandling();
		User::factory()->create();
		$user = User::first();
		$this->actingAs($user)->put('/api/users/1', [
			'profile_image' => 'https://via.placeholder.com/150',
		])->assertStatus(200);
	}

	public function test_user_can_update_profile_email()
	{
		$this->withoutExceptionHandling();
		User::factory()->create();
		$user = User::first();
		$this->actingAs($user)->put('/api/users/1', [
			'email' => 'lomtadzenikusha@gmail.com',
		])->assertStatus(200);
	}

	public function test_user_can_update_profile_password()
	{
		$this->withoutExceptionHandling();
		User::factory()->create();
		$user = User::first();
		$this->actingAs($user)->put('/api/users/1', [
			'password' => '123456',
		])->assertStatus(200);
	}

	public function test_user_can_update_profile_name()
	{
		$this->withoutExceptionHandling();
		User::factory()->create();
		$user = User::first();
		$this->actingAs($user)->put('/api/users/1', [
			'name' => 'nikoloz',
		])->assertStatus(200);
	}
}
