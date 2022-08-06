<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class SearchTest extends TestCase
{
	public function test_user_can_search_quotes()
	{
		$user = User::factory()->create();
		$this->actingAs($user);
		$response = $this->get('/api/search?search=Laravel&type=quote');
		$response->assertStatus(200);
	}

	public function test_user_can_search_quotes_by_quote()
	{
		$user = User::factory()->create();
		$this->actingAs($user);
		$response = $this->get('/api/search?search=quotename&type=quote');
		$response->assertStatus(200);
	}

	public function test_user_can_search_quotes_by_movie()
	{
		$user = User::factory()->create();
		$this->actingAs($user);
		$response = $this->get('/api/search?search=movie&type=movie');
		$response->assertStatus(200);
	}

	public function test_user_can_search_quotes_by_none()
	{
		$user = User::factory()->create();
		$this->actingAs($user);
		$response = $this->get('/api/search?search=quotename&type=none');
		$response->assertStatus(200);
	}
}
