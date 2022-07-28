<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NotificationEvent implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $comment;

	public $quote;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($comment, $quote)
	{
		$this->comment = $comment;
		$this->quote = $quote;
	}

	public function broadcastWith()
	{
		return  ['message' => $this->comment->user];
	}

	// public function toBroadcast($notifiable)
	// {
	// 	return new BroadcastMessage([
	// 		'message' => $this->comment,
	// 	]);
	// }

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		return new PrivateChannel('notification.' . $this->quote->user_id);
	}
}
