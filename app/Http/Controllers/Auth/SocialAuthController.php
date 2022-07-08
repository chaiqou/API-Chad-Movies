<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\SocialAccount;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
	public function redirectToProvider()
	{
		$url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();

		return response()->json(['url' => $url]);
	}

	public function handleProviderCallback()
	{
		$user = Socialite::driver('google')->stateless()->user();

		if (!$user)
		{
			return response()->json(['success' => false, 'message' => 'Failed to login'], 401);
		}

		$databaseUser = User::whereEmail($user->email)->first();

		if (!$databaseUser)
		{
			$databaseUser = User::create([
				'name'     => $user->name,
				'email'    => $user->email,
				'password' => bcrypt($user->id),
			]);

			$socialAccount = SocialAccount::create([
				'user_id'          => $databaseUser->id,
				'provider_user_id' => $user->id,
				'provider'         => 'google',
			]);
		}

		$credentials = [
			'email'          => $user->email,
			'password'       => $user->id,
		];

		$token = JWTAuth::attempt($credentials);

		if (!$token = JWTAuth::attempt($credentials))
		{
			return response()->json(['success' => false, 'message' => 'Email or Password is inccorect'], 401);
		}

		return response()->json([
			'access_token' => $token,
		]);
	}
}
