<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	protected function prepareForValidation()
	{
		$this->merge(['user_id' => $this->user()->id]);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'title_en'                    => ['required'],
			'title_ka'                    => ['required'],
			'director_en'                 => ['required'],
			'director_ka'                 => ['required'],
			'genre'                       => ['required'],
			'description_en'              => ['required'],
			'description_ka'              => ['required'],
			'year'                        => ['required'],
			'budget'                      => ['required'],
			'thumbnail'                   => ['required'],
			'user_id'                     => ['exists:users,id'],
		];
	}
}
