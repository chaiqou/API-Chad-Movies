<?php

namespace App\Http\Controllers;

class MovieController extends Controller
{
	public function store()
	{
		return response()->json([
			'message' => 'Movie created successfully.',
		], 201);
	}
}
