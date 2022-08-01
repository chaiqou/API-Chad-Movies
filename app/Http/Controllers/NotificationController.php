<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
	public function index(): array
	{
		return [
			'read'   => NotificationResource::collection(auth()->user()->readNotifications),
			'unread' => NotificationResource::collection(auth()->user()->unReadNotifications),
		];
	}

	public function read(Request $request): JsonResponse
	{
		auth()->user()->notifications->where('id', $request->id)->markAsRead();
		return response()->json(['success' => 'Notification read']);
	}

	public function readAll(): JsonResponse
	{
		auth()->user()->unReadNotifications->markAsRead();
		return response()->json(['success' => 'All notifications read']);
	}
}
