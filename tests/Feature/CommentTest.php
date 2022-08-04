<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Quote;
use App\Models\Comment;
use App\Notifications\NewCommentNotification;
use Illuminate\Support\Facades\Notification;

class CommentTest extends TestCase
{
	public function test_user_can_see_all_comment()
	{
		$user = User::factory()->create();
		$quote = Quote::factory()->create();
		$this->actingAs($user);

		$quote->comment()->create([
			'user_id'  => $user->id,
			'quote_id' => $quote->id,
			'body'     => 'comment',
		]);
		$response = $this->get(
			'/api/quotes/' . $quote->id . '/comment'
		);

		$response->assertStatus(200);
	}

	public function test_user_can_create_comment_and_send_notification()
	{
		Quote::factory()->create();
		User::factory()->create();
		$quote = Quote::first();
		$user = User::first();
		$this->actingAs($user);
		$comment = Comment::factory()->create(['user_id' => $user->id, 'quote_id' => $quote->id, 'body'     => 'comment']);

		$this->actingAs($user);

		$response = $this->post(
			'/api/quotes/' . $quote->id . '/comment',
			[
				'body' => 'comment',
			]
		);

		Notification::fake();
		$user->notify(new NewCommentNotification($comment));

		$response->assertStatus(201);
	}

	public function test_user_can_show_comment()
	{
		$user = User::factory()->create();
		$quote = Quote::factory()->create();
		$this->actingAs($user);

		$comment = $quote->comment()->create([
			'user_id'  => $user->id,
			'quote_id' => $quote->id,
			'body'     => 'comment',
		]);
		$response = $this->get(
			'/api/quotes/' . $quote->id . '/comment/' . $comment->id
		);

		$response->assertStatus(200);
	}

	public function test_user_can_destroy_comment()
	{
		$user = User::factory()->create();
		$quote = Quote::factory()->create();
		$this->actingAs($user);

		$comment = $quote->comment()->create([
			'user_id'  => $user->id,
			'quote_id' => $quote->id,
			'body'     => 'comment',
		]);
		$response = $this->delete(
			'/api/quotes/' . $quote->id . '/comment/' . $comment->id
		);

		$response->assertStatus(200);
	}

	public function test_comment_belnogs_to_quote()
	{
		Quote::factory()->create();
		User::factory()->create();
		$quote = Quote::first();
		$user = User::first();
		$this->actingAs($user);
		$comment = Comment::factory()->create(['user_id' => $user->id, 'quote_id' => $quote->id, 'body'     => 'comment']);
		$this->assertTrue($comment->quote->is($quote));
	}
}
