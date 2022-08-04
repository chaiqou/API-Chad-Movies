<?php

namespace Tests\Feature;

use App\Events\LikeEvent;
use Tests\TestCase;
use App\Models\Like;
use App\Models\User;
use App\Models\Quote;
use Illuminate\Support\Facades\Event;

class LikeTest extends TestCase
{
	public function test_user_can_like_quote()
	{
		$user = User::factory()->create();
		$quote = Quote::factory()->create();
		Like::factory()->create([
			'user_id'  => $user->id,
			'quote_id' => $quote->id,
		]);
		$like = $quote->like()->where('user_id', $user->id)->first();

		Event::fake();
		$this->actingAs($user)
			->post('/api/like/' . $quote->id)
			->assertStatus(200);

		Event::assertDispatched(LikeEvent::class);
	}

	public function test_user_can_unlike_quote()
	{
		$user = User::factory()->create();
		$quote = Quote::factory()->create();
		Like::factory()->create([
			'user_id'  => $user->id,
			'quote_id' => $quote->id,
		]);
		$like = $quote->like()->where('user_id', $user->id)->first();

		Event::fake();
		$this->actingAs($user)
			->delete('/api/like/' . $quote->id)
			->assertStatus(200);

		Event::assertDispatched(LikeEvent::class);
	}

	public function test_like_belongs_to_user()
	{
		$user = User::factory()->create();
		$like = Like::factory()->create(['user_id' => $user->id]);
		$this->assertTrue($like->user->is($user));
	}

	public function test_like_belongs_to_quote()
	{
		$quote = Quote::factory()->create();
		$like = Like::factory()->create(['quote_id' => $quote->id]);
		$this->assertTrue($like->quote->is($quote));
	}
}
