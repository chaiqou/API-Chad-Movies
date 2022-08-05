<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LikeNotificationEvent implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $like;

	public $quote;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($like, $quote)
	{
		$this->like = $like;
		$this->quote = $quote;
		$this->dontBroadcastToCurrentUser();
	}

	/**
	 * @codeCoverageIgnore
	 */
	public function broadcastWith()
	{
		return  ['message' => $this->like, 'user' => $this->like->user->id, 'likedBy' => $this->like->user->name];
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @codeCoverageIgnore
	 */
	public function broadcastOn(): Channel
	{
		return new PrivateChannel('likeNotification.' . $this->quote->user_id);
	}
}
