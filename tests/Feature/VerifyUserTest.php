<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;

class VerifyUserTest extends TestCase
{
	public function test_user_can_verify_account()
	{
		$user = User::factory()->create(['email_verified_at' => null]);
		$this->actingAs($user);
		$hash = $user->getEmailForVerification();
		$user->sendEmailVerificationNotification();
		$this->assertNull($user->email_verified_at);
	}

	public function test_if_user_verified()
	{
		$this->withoutMiddleware();
		$user = User::factory()->create(['email_verified_at' => Carbon::now()]);
		$this->actingAs($user);
		$response = $this->get('/api/email-verification');
		$response->assertStatus(404);
	}
}
