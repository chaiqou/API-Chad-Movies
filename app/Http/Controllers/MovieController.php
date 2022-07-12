<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;

class MovieController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return MovieResource::collection(Movie::all());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(MovieRequest $request)
	{
		if ($request->hasFile('thumbnail'))
		{
			$filename = $request->thumbnail->getClientOriginalName();
			info($filename);
		}

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
				'year'        => $request->year,
				'budget'      => $request->budget,
				'genre'       => $request->genre,
			]
		);

		return new MovieResource($movie);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Models\Movie $movie
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Movie $movie)
	{
		return new MovieResource($movie);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Movie        $movie
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(MovieRequest $request, Movie $movie)
	{
		$movie->update($request->validated());
		return new MovieResource($movie);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Models\Movie $movie
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Movie $movie)
	{
		$movie->delete();
		return response()->noContent();
	}
}
