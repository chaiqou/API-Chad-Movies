<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class SearchController extends Controller
{
	public function search(Request $request)
	{
		$quote_query = Quote::with(['user', 'movie', 'comment', 'like']);
		if ($request->type === 'quote' && $request->search)
		{
			$quote_query->where('quote', 'like', "%{$request->search}%");
		}

		if ($request->type === 'movie' && $request->search)
		{
			$quote_query->whererelation('movie', 'title', 'like', "%{$request->search}%");
		}

		$quotes = $quote_query->get();

		return response()->json($quotes);
	}
}
