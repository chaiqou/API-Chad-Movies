<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Resources\GenreResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GenreController extends Controller
{
	public function index(): AnonymousResourceCollection
	{
		return GenreResource::collection(Genre::all());
	}
}
