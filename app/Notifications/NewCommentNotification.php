<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
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
		return ['database'];
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
			'commentBy'    => $this->comment->user->name,
			'comment'      => $this->comment->body,
			'created_at'   => $this->comment->created_at->diffForHumans(),
			'id'           => $this->comment->id,
		];
	}
}
