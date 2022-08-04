<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewCommentNotification extends Notification implements ShouldBroadcast
{
	use Queueable;

	public $comment;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
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

	// /**
	//  * Get the array representation of the notification.
	//  *
	//  * @param mixed $notifiable
	//  *
	//  * @return array
	//  */
	// public function toArray($notifiable)
	// {
	// 	return [
	// 		'commentBy'    => $this->comment->user->name,
	// 		'comment'      => $this->comment->body,
	// 		'created_at'   => $this->comment->created_at->diffForHumans(),
	// 		'id'           => $this->comment->id,
	// 	];
	// }

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
			'commentBy'       => $this->comment->user->name,
			'body'            => $this->comment->body,
			'created_at'      => $this->comment->created_at->diffForHumans(),
			'id'              => $this->comment->id,
			'comment'         => new CommentResource($this->comment),
		]);
	}
}
