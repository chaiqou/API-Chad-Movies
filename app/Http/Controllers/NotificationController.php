<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
	public function index()
	{
		return [
			'read'   => NotificationResource::collection(auth()->user()->readNotifications),
			'unread' => NotificationResource::collection(auth()->user()->unReadNotifications),
		];
	}

	public function read(Request $request)
	{
		auth()->user()->notifications->where('id', $request->id)->markAsRead();
	}

	public function readAll()
	{
		auth()->user()->unReadNotifications->markAsRead();
	}
}
