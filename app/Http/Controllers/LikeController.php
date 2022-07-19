<?php

namespace App\Http\Controllers;

use App\Models\Quote;

class LikeController extends Controller
{
	public function like(Quote $quote)
	{
		$quote->like()->create([
			'user_id' => auth()->id(),
		]);

		// $quote->like()->toggle(auth()->user());
		// return new LikeResource($quote->like);
	}

	public function unlike(Quote $quote)
	{
		$quote->like()->where('user_id', auth()->id())->first()->delete();
	}
}
