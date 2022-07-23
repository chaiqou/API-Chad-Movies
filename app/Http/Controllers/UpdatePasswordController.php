<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdatePasswordRequest;

class UpdatePasswordController extends Controller
{
	public function updatePassword(UpdatePasswordRequest $request)
	{
		return $this->updatePasswordRow($request)->count() > 0 ? $this->resetPassword($request) : $this->tokenNotFoundError();
	}

	private function updatePasswordRow($request)
	{
		return DB::table('password_resets')->where([
			'email' => $request->email,
			'token' => $request->resetToken,
		]);
	}

	private function tokenNotFoundError()
	{
		return response()->json([
			'error' => 'you have entered wrong token or email',
		], 404);
	}

	private function resetPassword($request)
	{
		$userData = User::whereEmail($request->email)->first();

		$userData->update([
			'password'=> bcrypt($request->password),
		]);
		// remove verification data from db
		$this->updatePasswordRow($request)->delete();

		return response()->json([
			'data'=> 'Your password has been updated <3.',
		], 200);
	}
}
