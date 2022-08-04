<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\SendMailreset;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
	public function sendEmail(Request $request): JsonResponse
	{
		User::where('email', $request->email)->firstOrFail();

		$token = $this->createToken($request->email);
		Mail::to($request->email)->send(new SendMailreset($token, $request->email));

		return response()->json([
			'data' => 'Reset Email is send successfully, please check your inbox.',
		], 201);
	}

	public function createToken($email): string
	{
		$oldToken = DB::table('password_resets')->where('email', $email)->first();

		if ($oldToken)
		{
			return $oldToken->token;
		}

		$token = Str::random(40);

		DB::table('password_resets')->insert([
			'email'      => $email,
			'token'      => $token,
			'created_at' => Carbon::now(),
		]);

		return $token;
	}
}
