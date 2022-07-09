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
			'title'   => '',
			'body'    => '',
		]);

		$movie = Movie::first();

		$this->assertCount(0, Movie::all());

		$response->assertStatus(201);
	}
}
