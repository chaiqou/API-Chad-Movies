<?php

namespace App\Listeners;

use App\Events\LikeEvent;

class LikeEventListener
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Handle the event.
	 *
	 * @param \App\Events\LikeEvent $event
	 *
	 * @return void
	 */
	public function handle(LikeEvent $event)
	{
	}
}
