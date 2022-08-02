<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'title' => [
				'en' => $this->faker->sentence,
				'ka' => $this->faker->sentence,
			],
			'description' => [
				'en' => $this->faker->paragraph,
				'ka' => $this->faker->paragraph,
			],
			'director' => [
				'en' => $this->faker->name,
				'ka' => $this->faker->name,
			],
			'genre'          => $this->faker->sentence,
			'year'           => $this->faker->year,
			'slug'           => $this->faker->slug,
			'budget'         => $this->faker->numberBetween(1, 1000000),
			'thumbnail'      => $this->faker->imageUrl(),
			'user_id'        => function () {
				return User::all()->random();
			},
		];
	}
}
