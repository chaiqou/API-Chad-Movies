<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'quote' => [
				'en' => $this->faker->sentence,
				'ka' => $this->faker->sentence,
			],
			'thumbnail' => $this->faker->imageUrl(),
			'movie_id'  => function () {
				return Movie::all()->random();
			},
			'user_id'   => function () {
				return User::all()->random();
			},
		];
	}
}
