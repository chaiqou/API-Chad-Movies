<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Genre;

class GenreTest extends TestCase
{
	public function test_user_can_see_genres()
	{
		$user = User::factory()->create();
		$genre = Genre::factory()->create();
		$response = $this->actingAs($user)->get('/api/genres');
		$response->assertStatus(200);
	}
}
