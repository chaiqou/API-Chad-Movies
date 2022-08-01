<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\File;
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

	public function updateProfile(Request $request): JsonResponse
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

	private function saveImage($image): string
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
			return  $image;
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
