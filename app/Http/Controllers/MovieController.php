<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;
use App\Http\Resources\MovieResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovieController extends Controller
{
	public function index(Request $request): AnonymousResourceCollection
	{
		$user = auth()->user();
		$movies = Movie::where('user_id', $user->id)->where('title', 'LIKE', '%' . $request->search . '%')->with('quotes')->get();

		return MovieResource::collection($movies);
	}

	public function store(MovieRequest $request): MovieResource
	{
		$image_path = Helper::saveImage($request->thumbnail);

		$movie = Movie::create(
			[
				'title' => [
					'en' => $request->title_en,
					'ka' => $request->title_ka,
				],
				'director' => [
					'en' => $request->director_en,
					'ka' => $request->director_ka,
				],
				'description' => [
					'en' => $request->description_en,
					'ka' => $request->description_ka,
				],
				'year'          => $request->year,
				'budget'        => $request->budget,
				'genre'         => $request->genre,
				'thumbnail'     => $image_path,
				'user_id'       => auth()->user()->id,
			]
		);

		return new MovieResource($movie);
	}

	public function show(Movie $movie, Request $request): JsonResponse
	{
		$user = $request->user();
		if ($user->id !== $movie->user_id)
		{
			return response()->json(['error' => 'Unauthorized user'], 401);
		}

		return new MovieResource($movie);
	}

	public function showBySlug(Movie $movie, Request $request): MovieResource
	{
		$movies = Movie::where('id', $request->id)->with('quotes')->get();
		return new MovieResource($movies);
	}

	public function update(MovieRequest $request, Movie $movie): MovieResource
	{
		$movie->update([
			'title' => [
				'en' => $request->title_en,
				'ka' => $request->title_ka,
			],
			'director' => [
				'en' => $request->director_en,
				'ka' => $request->director_ka,
			],
			'description' => [
				'en' => $request->description_en,
				'ka' => $request->description_ka,
			],
			'year'          => $request->year,
			'budget'        => $request->budget,
			'genre'         => $request->genre,
			'thumbnail'     => Helper::saveImage($request->thumbnail),
		]);
		return new MovieResource($movie);
	}

	public function destroy(Movie $movie, Request $request): JsonResponse
	{
		$user = $request->user();
		if ($user->id !== $movie->user_id)
		{
			return response()->json(['error' => 'Unauthorized user'], 401);
		}
		$movie->delete();
		return response()->json(['success' => 'Movie deleted'], 204);
	}
}
