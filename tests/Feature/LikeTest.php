<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Like;
use App\Models\User;
use App\Models\Quote;
use App\Events\LikeEvent;
use App\Http\Resources\LikeResource;
use Illuminate\Support\Facades\Event;
use App\Http\Resources\NotificationResource;
use App\Notifications\NewLikeNotification;
use Illuminate\Support\Facades\Notification;

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

		$response = $this->actingAs($user)
			->post('/api/like/' . $quote->id);

		Notification::fake();
		$user->notify(new NewLikeNotification($like));

		$this->assertDatabaseHas('likes', [
			'user_id'  => $user->id,
			'quote_id' => $quote->id,
		]);

		$response->assertStatus(200);
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

	public function test_like_resource_returns_collection()
	{
		$like = Like::factory()->create();
		$collect = LikeResource::collection(Like::all())->resolve();
		$this->assertCount(1, $collect);
	}

	public function test_notification_resource()
	{
		$like = Like::factory()->create();
		$collect = NotificationResource::collection(Like::all())->resolve();
		$this->assertCount(1, $collect);
	}
}
