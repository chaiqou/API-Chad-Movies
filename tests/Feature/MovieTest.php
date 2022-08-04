<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use App\Models\Quote;

class MovieTest extends TestCase
{
	public function test_user_can_add_movie()
	{
		$user = User::factory()->create();
		$this->actingAs($user);

		$response = $this->post('/api/movies', [
			'title_en'       => 'title',
			'title_ka'       => 'title',
			'director_en'    => 'director',
			'director_ka'    => 'director',
			'description_en' => 'description',
			'description_ka' => 'description',
			'genre'          => 'genre',
			'slug'           => 'slug',
			'thumbnail'      => 'thumbnail',
			'year'           => 3232,
			'user_id'        => 1,
			'budget'         => 32,
		]);

		$movie = Movie::first();
		$response->assertStatus(201);
	}

	public function test_user_can_update_movie()
	{
		$this->withoutMiddleware();
		$user = User::factory()->create();
		$this->actingAs($user);
		$response = $this->put(
			'/api/movies/1',
			[
				'title_en'       => 'title',
				'title_ka'       => 'title',
				'director_en'    => 'director',
				'director_ka'    => 'director',
				'description_en' => 'description',
				'description_ka' => 'description',
				'genre'          => 'genre',
				'slug'           => 'slug',
				'thumbnail'      => 'thumbnail',
				'year'           => 3232,
				'user_id'        => 1,
				'budget'         => 32,
			]
		);
		$response->assertStatus(200);
	}

	public function test_user_can_delete_movie()
	{
		$user = User::factory()->create();
		$movie = Movie::factory()->create(['user_id' => $user->id]);
		$this->actingAs($user);
		$response = $this->delete('/api/movies/' . $movie->id);
		$response->assertStatus(204);
	}

	public function test_user_cant_delete_movie()
	{
		$user = User::factory()->create();
		$movie = Movie::factory()->create();
		$this->actingAs($user);
		$response = $this->delete('/api/movies/' . $movie->id);
		$response->assertStatus(401);
	}

	public function test_user_can_see_movie()
	{
		$user = User::factory()->create();
		$this->actingAs($user);
		$response = $this->get(
			'/api/movies'
		);
		$response->assertStatus(200);
	}

	public function test_user_can_show_movie()
	{
		$user = User::factory()->create();
		$this->actingAs($user);
		$response = $this->get(
			'/api/movie-slug/1'
		);
		$response->assertStatus(200);
	}

	public function test_movie_has_many_quotes()
	{
		$user = User::factory()->create();
		$movie = Movie::factory()->create(['user_id' => $user->id]);
		$quote = Quote::factory()->create(['movie_id' => $movie->id]);
		$this->assertTrue($movie->quotes->contains($quote));
	}

	public function test_movie_belongs_to_user()
	{
		$user = User::factory()->create();
		$movie = Movie::factory()->create(['user_id' => $user->id]);
		$this->assertTrue($movie->user->is($user));
	}
}
