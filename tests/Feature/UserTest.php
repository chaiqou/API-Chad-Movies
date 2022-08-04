<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use App\Models\Quote;

class UserTest extends TestCase
{
	public function test_user_can_be_fetched()
	{
		$user = User::factory()->create();
		$response = $this->actingAs($user)->get('/api/users');
		$response->assertStatus(200);
		$response->assertJsonStructure(['data' => ['id', 'name', 'email', 'profile_image']]);
	}

	public function test_user_has_many_movies()
	{
		$user = User::factory()->create();
		$movie = Movie::factory()->create(['user_id' => $user->id]);
		$this->assertCount(1, $user->movie);
	}

	public function test_user_has_many_quotes()
	{
		$user = User::factory()->create();
		$quote = Quote::factory()->create(['user_id' => $user->id]);
		$this->assertCount(1, $user->quote);
	}

	public function test_user_has_many_comments()
	{
		$user = User::factory()->create();
		$this->assertCount(0, $user->comment);
	}

	public function test_user_belongs_to_many_likes()
	{
		$user = User::factory()->create();
		$quote = Quote::factory()->create(['user_id' => $user->id]);
		$this->assertCount(0, $user->like);
	}
}
