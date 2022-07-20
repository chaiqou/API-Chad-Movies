<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Notifications\NewLikeNotification;

class LikeController extends Controller
{
	public function like(Quote $quote)
	{
		$quotes = $quote->like()->create([
			'user_id' => auth()->id(),
		]);

		$user = $quote->user;

		if ($quotes->user_id !== $quote->user_id)
		{
			$user->notify(new NewLikeNotification($quotes));
		}

		return response()->json([
			'message' => 'Quote liked successfully',
			'quote'   => $quote,
		]);
	}

	public function unlike(Quote $quote)
	{
		$quote = $quote->like()->where('user_id', auth()->id())->first()->delete();

		return response()->json([
			'message' => 'Quote unliked successfully',
			'quote'   => $quote,
		]);
	}
}
