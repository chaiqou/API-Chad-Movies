<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
	public function redirectToProvider()
	{
		return Socialite::driver('google')->stateless()->redirect();
	}

	public function handleProviderCallback()
	{
		$user = Socialite::driver('google')->stateless()->user();

		if (!$user)
		{
			// aq unda davabruno json romelic gamoitans daifelebis shemtxvevashi erors
			dd('failed');
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
		else
		{
			dd('this user exists');
		}

		// login user and get token
		$token = $databaseUser->createToken('authToken')->plainTextToken;

		return response()->json([
			'access_token' => $token,
		]);
	}
}
