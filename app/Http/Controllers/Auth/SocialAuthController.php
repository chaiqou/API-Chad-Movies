<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
		dd($user);
	}
}
