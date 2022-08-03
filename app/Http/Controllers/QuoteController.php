<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\QuoteRequest;
use App\Models\Quote;
use App\Http\Resources\QuoteResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuoteController extends Controller
{
	public function index(Request $request): AnonymousResourceCollection
	{
		$quotes = Quote::latest()->paginate(3);

		return QuoteResource::collection($quotes);
	}

	public function store(QuoteRequest $request): QuoteResource
	{
		$image_path = Helper::saveImage($request->thumbnail);

		$quote = Quote::create(
			[
				'quote' => [
					'en' => $request->quote_en,
					'ka' => $request->quote_ka,
				],
				'thumbnail'          => $image_path,
				'movie_id'           => $request->movie_id,
				'user_id'            => auth()->user()->id,
			]
		);

		return new QuoteResource($quote);
	}

	public function show(Quote $quote, Request $request): QuoteResource
	{
		return new QuoteResource($quote);
	}

	public function update(Quote $quote, QuoteRequest $request)
	{
		$quote->update([
			'quote' => [
				'en' => $request->quote_en,
				'ka' => $request->quote_ka,
			],
			'thumbnail' => Helper::saveImage($request->thumbnail),
		]);
		return new QuoteResource($quote);
	}

	public function destroy(Quote $quote, Request $request): JsonResponse
	{
		$user = $request->user();
		if ($user->id !== $quote->user_id)
		{
			return response()->json(['error' => 'Unauthorized user'], 401);
		}
		$quote->delete();
		return response()->json(['success' => true, 'message' => 'quote deleted'], 204);
	}
}
