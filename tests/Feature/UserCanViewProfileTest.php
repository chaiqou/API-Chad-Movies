<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCanViewProfileTest extends TestCase
{
	use RefreshDatabase;

	public function test_a_user_can_see_user_profile()
	{
		$this->withoutExceptionHandling();
		$this->actingAs($user = User::factory()->make(), 'api');

		$response = $this->get('/api/users/' . $user->id);
		$response->assertStatus(200);
	}
}
