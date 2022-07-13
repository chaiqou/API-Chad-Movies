<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Movie;
use App\Http\Requests\MovieRequest;
use Illuminate\Support\Facades\File;
use App\Http\Resources\MovieResource;

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
		if ($request->thumbnail)
		{
			$image_path = $this->saveImage($request->thumbnail);

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
					'thumbnail'   => $image_path,
				]
			);

			return new MovieResource($movie);
		}
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

	private function saveImage($image)
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
			throw new Exception('Invalid image type.');
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
