<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserImageRequest;
use App\Http\Resources\UserImageResource;

class UserImageController extends Controller
{
	public function store(UserImageRequest $request)
	{
		$image = $request->file('image')->store('user-images', 'public');
		$userImage = $request->user()->image()->create([
			'image'    => $image,
			'width'    => $request->input('width'),
			'height'   => $request->input('height'),
			'location' => $request->input('location'),
		]);

		return new UserImageResource($userImage);
	}
}
