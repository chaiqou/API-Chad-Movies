<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Mail\SendMailreset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UpdatePasswordTest extends TestCase
{
	public function test_user_can_reset_his_password()
	{
		$oldPassword = 'password';
		$newPassword = 'newpassword';

		$user = User::factory()->create(['password' => Hash::make($oldPassword)]);
		$token = Password::broker()->createToken($user);

		$this->actingAs($user);

		$response = $this->post(route('user.reset-password'), [
			'email'                         => $user->email,
			'token'                         => $token,
			'current_password'              => $oldPassword,
			'new_password'                  => $newPassword,
			'repeat_new_password'           => $newPassword,
		]);

		$response->assertStatus(302);
	}

	public function test_user_can_save_new_password_in_database()
	{
		$this->withoutExceptionHandling();

		Mail::fake();

		$user = User::factory()->create(
			[
				'email'    => 'user@domain.com',
				'password' => Hash::make('oldpassword'),
			]
		);

		$token = Password::createToken(User::first());

		$response = $this->post(route('user.reset-password'), [
			'password'                        => 'newpassword',
			'password_confirmation'           => 'newpassword',
			'email'                           => $user->email,
			'token'                           => $token,
		]);

		Mail::to('lomtadzenikusha@gmail.com')->send(new SendMailreset('lomtadzenikusha@gmail.com', 'token'));
		Mail::assertSent(SendMailreset::class);
	}
}
