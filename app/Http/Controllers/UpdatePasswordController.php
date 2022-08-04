<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\JsonResponse;

class UpdatePasswordController extends Controller
{
	public function updatePassword(UpdatePasswordRequest $request): JsonResponse
	{
		if ($this->updatePasswordRow($request)->count() > 0)
		{
			$userData = User::whereEmail($request->email)->firstOrFail();

			$userData->update([
				'password'=> bcrypt($request->password),
			]);

			$this->updatePasswordRow($request)->delete();

			return response()->json([
				'data'=> 'Your password has been updated <3.',
			], 200);
		}
		else
		{
			return $this->tokenNotFoundError();
		}
	}

	private function updatePasswordRow($request)
	{
		return DB::table('password_resets')->where([
			'email' => $request->email,
			'token' => $request->resetToken,
		]);
	}

	private function tokenNotFoundError(): JsonResponse
	{
		return response()->json([
			'error' => 'you have entered wrong token or email',
		], 404);
	}
}
