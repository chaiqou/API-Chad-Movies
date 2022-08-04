<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Mail\SendMailreset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordTest extends TestCase
{
	public function test_user_can_send_forgot_password_email()
	{
		$this->withoutExceptionHandling();
		$user = User::factory()->create();
		$token = Password::broker()->createToken($user);
		$password = Str::random(8);

		$response = $this->postJson(route('user.forgot-password'), [
			'email' => $user->email,
		])->assertStatus(201);
	}

	public function test_user_can_save_new_token_in_database()
	{
		$this->withoutExceptionHandling();
		Mail::fake();

		$user = User::factory()->create(
			['email' => 'lomtadzenikusha@gmail.com']
		);

		$response = $this->post('/api/forgot-password', [
			'email' => $user->email,
		]);

		Mail::to('lomtadzenikusha@gmail.com')->send(new SendMailreset('lomtadzenikusha@gmail.com', 'token'));
		Mail::assertSent(SendMailreset::class);
	}
}
