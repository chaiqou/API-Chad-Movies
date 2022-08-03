<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
	use RefreshDatabase;

	public function test_user_can_login()
	{
		$user = User::factory()->create();

		$response = $this->post('/api/login', [
			'email'    => $user->email,
			'password' => 'password',
		]);

		$response->assertStatus(200);
	}

	public function test_user_can_logout()
	{
		User::factory()->create();
		$user = User::first();
		$token = JWTAuth::fromUser($user);

		$this->post('api/logout?token=' . $token)
			->assertStatus(200);

		$this->assertGuest('api');
	}

	public function test_user_can_register()
	{
		$response = $this->postJson(route('user.register'), ['name' => 'nikoloz', 'email' => 'nikoloz@gmail.com', 'password' => '12345678', 'password_confirmation' => '12345678']);
		$this->assertDatabaseHas('users', ['name' => 'nikoloz']);
		$this->assertJson($response->getContent());
		$response->assertStatus(200);
	}
}
