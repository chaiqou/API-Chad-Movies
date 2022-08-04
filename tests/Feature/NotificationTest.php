<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class NotificationTest extends TestCase
{
	public function test_user_can_mark_as_read_notification()
	{
		$this->withoutExceptionHandling();
		$user = User::factory()->create();
		$this->actingAs($user)->post('/api/markAsRead')->assertStatus(200);
	}

	public function test_user_can_mark_all_as_read_notification()
	{
		$this->withoutExceptionHandling();
		$user = User::factory()->create();
		$this->actingAs($user)->post('/api/markAllAsRead')->assertStatus(200);
	}

	public function test_user_can_see_notifications_index()
	{
		$this->withoutExceptionHandling();
		$user = User::factory()->create();
		$this->actingAs($user)->post('/api/notifications')->assertStatus(200);
	}
}
