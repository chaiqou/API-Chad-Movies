<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostToDashboardTest extends TestCase
{
	use RefreshDatabase;

	public function test_user_can_post_movie()
	{
		$this->withoutExceptionHandling();
		$this->actingAs($user = User::factory()->make(), 'api');

		$response = $this->post('/api/movies', [
			'title'   => 'The movie title',
			'body'    => 'The movie body',
			'user_id' => $user->id,
		]);

		$movie = Movie::first();

		$response->assertStatus(201);
	}
}
