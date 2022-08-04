<?php

namespace Tests\Feature;

use Tests\TestCase;

class SearchTest extends TestCase
{
	public function test_user_can_search_quotes()
	{
		$response = $this->get('/api/search?q=Laravel');
		$response->assertStatus(200);
		$response->assertSee([]);
	}

	public function test_user_can_search_quotes_by_quote()
	{
		$response = $this->get('/api/search?search=quotename&type=quote');
		$response->assertStatus(200);
	}

	public function test_user_can_search_quotes_by_movie()
	{
		$response = $this->get('/api/search?search=movie&type=movie');
		$response->assertStatus(200);
	}

	public function test_user_can_search_quotes_by_none()
	{
		$response = $this->get('/api/search?search=quotename&type=none');
		$response->assertStatus(200);
	}
}
