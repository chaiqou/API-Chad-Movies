<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
	public function __invoke()
	{
		return [
			'read'   => auth()->user()->notifications->where('read_at', !null),
			'unread' => auth()->user()->notifications->where('read_at', null),
		];
	}
}
