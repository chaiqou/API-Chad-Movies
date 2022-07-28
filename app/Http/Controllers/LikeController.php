<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Events\LikeEvent;

class LikeController extends Controller
{
	public function like(Quote $quote)
	{
		$quotes = $quote->like()->create([
			'user_id' => auth()->id(),
		]);

		LikeEvent::dispatch($quote->id, 1);

		return response()->json([
			'message' => 'Quote liked successfully',
			'quote'   => $quote,
		]);
	}

	public function unlike(Quote $quote)
	{
		$quotes = $quote->like()->where('user_id', auth()->id())->first()->delete();

		broadcast(new LikeEvent($quote->id, 0))->toOthers();

		return response()->json([
			'message' => 'Quote unliked successfully',
			'quote'   => $quotes,
		]);
	}
}
