<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
	public function index(Request $request): JsonResponse
	{
		$user = User::findOrFail($request->id);

		if ($user->hasVerifiedEmail())
		{
			return response()->json([
				'message' => 'User already verified!',
				'success' => false,
			]);
		}

		if ($user->markEmailAsVerified())
		{
			event(new Verified($user));
		}

		return response()->json([
			'message' => 'Email verified successfully!',
			'success' => true,
		]);
	}
}
