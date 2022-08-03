<?php

namespace Database\Factories;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
	public function definition()
	{
		return [
			'body'    => $this->faker->text,
			'user_id' => function () {
				return User::all()->random();
			},
			'quote_id' => function () {
				return Quote::all()->random();
			},
		];
	}
}
