<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$genres = [
			'Action',
			'Adventure',
			'Anime',
			'Biography',
			'Comedy',
			'Crime',
			'Documentary',
			'Drama',
			'Family',
			'Fantasy',
			'Film-Noir',
			'History',
			'Horror',
			'Music',
			'Musical',
			'Mystery',
			'Romance',
			'Sci-Fi',
			'Sport',
			'Thriller',
			'War',
			'Western',
		];

		foreach ($genres as $genre)
		{
			Genre::create([
				'name' => $genre,
			]);
		}
	}
}
