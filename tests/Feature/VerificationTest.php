<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class VerificationTest extends TestCase
{
	public function test_user_email_verification()
	{
		$user = User::factory()->create([
			'email_verified_at' => null,
		]);

		Mail::fake();

		$this->get(route('verification.verify', [
			'id'   => $user->id,
			'hash' => sha1($user->getEmailForVerification()),
		]))
			->assertStatus(200)
			->assertJson([
				'success' => true,
				'message' => 'Email verified successfully!',
			]);

		if (!$user->hasVerifiedEmail())
		{
			$this->assertFalse($user->hasVerifiedEmail());
		}
	}

	public function test_user_email_already_verified()
	{
		$user = User::factory()->create([
			'email_verified_at' => now(),
		]);

		$this->get(route('verification.verify', [
			'id'   => $user->id,
			'hash' => sha1($user->getEmailForVerification()),
		]))
			->assertStatus(200)
			->assertJson([
				'success' => false,
				'message' => 'User already verified!',
			]);
	}

	public function test_user_cant_verify_email_with_wrong_hash()
	{
		$user = User::factory()->create([
			'email_verified_at' => null,
		]);

		$this->get(route('verification.verify', [
			'id'   => $user->id,
			'hash' => sha1($user->getEmailForVerification() . 'wrong'),
		]))
			->assertStatus(200)
			->assertJson([
				'success' => false,
				'message' => 'Unauthorized user, please verify your accont',
			]);
	}
}
