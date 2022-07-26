<?php

namespace App\Notifications;

use App\Models\Like;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewLikeNotification extends Notification implements ShouldBroadcast
{
	use Queueable;

	public $like;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(Like $like)
	{
		$this->like = $like;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 *
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['database', 'broadcast'];
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 *
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			'likedBy'     => $this->like->user->name,
			'id'          => $this->like->id,
			'created_at'  => $this->like->created_at->diffForHumans(),
		];
	}

	/**
	 * Get the broadcastable representation of the notification.
	 *
	 * @param mixed $notifiable
	 *
	 * @return BroadcastMessage
	 */
	public function toBroadcast($notifiable)
	{
		return new BroadcastMessage([
			'likedBy'     => $this->like->user->name,
			'id'          => $this->like->id,
			'created_at'  => $this->like->created_at->diffForHumans(),
		]);
	}
}
