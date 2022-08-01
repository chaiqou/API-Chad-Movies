<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteRequest;
use Exception;
use App\Models\Quote;
use Illuminate\Support\Facades\File;
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
		$image_path = $this->saveImage($request->thumbnail);

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
			'thumbnail' => $this->saveImage($request->thumbnail),
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
		return response()->json(['success' => 'quote deleted'], 204);
	}

	private function saveImage($image): string
	{
		if (preg_match('/^data:image\/(\w+);base64,/', $image, $type))
		{
			$image = substr($image, strpos($image, ',') + 1);
			$type = strtolower($type[1]);

			if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png']))
			{
				throw new Exception('invalid image type');
			}

			$image = str_replace(' ', '+', $image);
			$image = base64_decode($image);
		}
		else
		{
			return  $image;
		}

		$dir = 'images/';
		$file_name = uniqid() . '.' . $type;
		$absolutePath = public_path($dir);
		$relativePath = $dir . $file_name;
		if (!file_exists($absolutePath))
		{
			File::makeDirectory($absolutePath, 0775, true);
		}
		file_put_contents($relativePath, $image);

		return $relativePath;
	}
}
