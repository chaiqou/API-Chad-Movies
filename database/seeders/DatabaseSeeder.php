<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call([GenreSeeder::class, userSeeder::class, MovieSeeder::class, QuoteSeeder::class, LikeSeeder::class, CommentSeeder::class]);
	}
}
