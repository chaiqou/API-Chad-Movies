<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(User $user, Request $request)
	{
		$id = auth()->user()->id;
		$users = User::where('id', 'LIKE', '%' . $id . '%')->first();
		return new UserResource($users);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user)
	{
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\User         $user
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user)
	{
	}

	public function updateProfile(Request $request)
	{
		if ($request->profile_image != auth()->user()->profile_image)
		{
			$image_path = $this->saveImage($request->profile_image);
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

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Models\User $user
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
	}

	private function saveImage($image)
	{
		if (preg_match('/^data:image\/(\w+);base64,/', $image, $type))
		{
			$image = substr($image, strpos($image, ',') + 1);
			$type = strtolower($type[1]);

			if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png']))
			{
				throw new Exception('invalid image type');
			}

			$image = str_replace(' ', '+', $image);
			$image = base64_decode($image);
		}
		else
		{
			throw new Exception('Invalid image type.');
		}

		$dir = 'images/';
		$file_name = uniqid() . '.' . $type;
		$absolutePath = public_path($dir);
		$relativePath = $dir . $file_name;
		if (!file_exists($absolutePath))
		{
			File::makeDirectory($absolutePath, 0775, true);
		}
		file_put_contents($relativePath, $image);

		return $relativePath;
	}
}
