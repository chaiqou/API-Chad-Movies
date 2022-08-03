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
		if (!$this->validateEmail($request->email))
		{
			return response()->json([
				'error' => 'Email does not exist.',
			], 404);
		}
		$this->send($request->email);
		return response()->json([
			'data' => 'Reset Email is send successfully, please check your inbox.',
		], 201);
	}

	public function send($email): void
	{
		$token = $this->createToken($email);
		Mail::to($email)->send(new SendMailreset($token, $email));
	}

	public function createToken($email): string
	{
		$oldToken = DB::table('password_resets')->where('email', $email)->first();

		if ($oldToken)
		{
			return $oldToken->token;
		}

		$token = Str::random(40);
		$this->saveToken($token, $email);
		return $token;
	}

	public function saveToken($token, $email): void
	{
		DB::table('password_resets')->insert([
			'email'      => $email,
			'token'      => $token,
			'created_at' => Carbon::now(),
		]);
	}

	public function validateEmail($email): bool
	{
		return (bool)User::where('email', $email)->first();
	}
}
