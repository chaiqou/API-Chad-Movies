<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
	public function index(User $user, Request $request): UserResource
	{
		$id = auth()->user()->id;
		$users = User::where('id', 'LIKE', '%' . $id . '%')->first();
		return new UserResource($users);
	}

	public function update(Request $request): JsonResponse
	{
		if ($request->profile_image != auth()->user()->profile_image)
		{
			$image_path = Helper::saveImage($request->profile_image);
			User::where('id', auth()->user()->id)->update(['profile_image' => $image_path]);
		}

		if ($request->email != auth()->user()->email && $request->email != null)
		{
			User::where('id', auth()->user()->id)->update(['email' => $request->email]);
		}

		if ($request->password != null)
		{
			User::where('id', auth()->user()->id)->update(['password' => bcrypt($request->password)]);
		}

		if ($request->name != auth()->user()->name && $request->name != null)
		{
			User::where('id', auth()->user()->id)->update(['name' => $request->name]);
		}

		return response()->json(['success' => 'Profile updated successfully'], 200);
	}
}
