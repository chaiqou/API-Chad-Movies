<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

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

	public function broadcastWith()
	{
		return  ['message' => $this->like, 'user' => $this->like->user->id, 'likedBy' => $this->like->user->name];
	}

	public function toBroadcast($notifiable)
	{
		return new BroadcastMessage([
			'message' => $this->like,
		]);
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		return new PrivateChannel('likeNotification.' . $this->quote->user_id);
	}
}
