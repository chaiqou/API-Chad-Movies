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
	public function definition()
	{
		return [
			'quote' => [
				'en' => $this->faker->sentence,
				'ka' => $this->faker->sentence,
			],
			'thumbnail' => $this->faker->imageUrl(),
			'movie_id'  => Movie::factory()->create()->id,
			'user_id'   => User::factory()->create()->id,
		];
	}
}
