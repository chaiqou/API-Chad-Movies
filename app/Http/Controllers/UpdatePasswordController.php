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
		return  $this->resetPassword($request);
	}

	private function updatePasswordRow($request)
	{
		return DB::table('password_resets')->where([
			'email' => $request->email,
			'token' => $request->resetToken,
		]);
	}

	private function resetPassword($request): JsonResponse
	{
		$userData = User::whereEmail($request->email)->first();

		$userData->update([
			'password'=> bcrypt($request->password),
		]);

		$this->updatePasswordRow($request)->delete();

		return response()->json([
			'data'=> 'Your password has been updated <3.',
		], 200);
	}
}
