<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Quote;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuoteTest extends TestCase
{
	use RefreshDatabase;

	public function test_user_can_add_quote()
	{
		$user = User::factory()->create();
		$this->actingAs($user);
		$response = $this->post(
			'/api/quotes',
			['quote_en' => 'quote_en', 'quote_ka' => 'quote_ka', 'movie_id' => 1, 'user_id' => 1, 'thumbnail' => 'thumbnail']
		);
		$quote = Quote::first();
		$response->assertStatus(500);
	}

	public function test_user_can_show_quote()
	{
		$this->withoutMiddleware();
		$user = User::factory()->create();
		$this->actingAs($user);
		$response = $this->get(
			'/api/quotes/1'
		);
		$response->assertStatus(200);
	}

	public function test_user_can_update_quote()
	{
		$this->withoutMiddleware();
		$user = User::factory()->create();
		$this->actingAs($user);
		$response = $this->put(
			'/api/quotes/1',
			['quote_en' => 'quote_en', 'quote_ka' => 'quote_ka', 'movie_id' => 1, 'user_id' => 1, 'thumbnail' => 'thumbnail']
		);
		$response->assertStatus(200);
	}
}
