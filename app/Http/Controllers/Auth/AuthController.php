<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
	/**
	 * Create a new AuthController instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth:api', ['except' => ['login', 'register']]);
	}

	public function login(Request $request)
	{
		$user = User::where('email', $request['email'])->where('email_verified_at', '<>', null)->firstOrFail();

		$credentials = $request->only('email', 'password');

		if ($request->remember_token === true)
		{
			JWTAuth::factory()->setTTL(999999);
		}

		if (!$token = JWTAuth::attempt($credentials))
		{
			return response()->json(['success' => false, 'message' => 'Email or Password is inccorect'], 401);
		}

		return $this->respondWithToken($token);
	}

	public function logout(): JsonResponse
	{
		auth()->logout();

		return response()->json(['message' => 'Successfully logged out']);
	}

	public function checkToken(): JsonResponse
	{
		return response()->json(['success' => true], 200);
	}

	public function register(RegisterRequest $request): JsonResponse
	{
		$user = User::create([
			'name'     => $request->name,
			'email'    => $request->email,
			'password' => bcrypt($request->password),
		]);

		$user->sendEmailVerificationNotification();

		return response()->json([
			'message' => 'User created successfully!',
			'success' => true, ]);
	}

	public function authenticatedUser(): JsonResponse
	{
		return response()->json(auth()->user());
	}

	public function refresh(): JsonResponse
	{
		return $this->respondWithToken(auth()->refresh());
	}

	protected function respondWithToken($token): JsonResponse
	{
		return response()->json([
			'access_token' => $token,
			'token_type'   => 'bearer',
			'expires_in'   => auth()->factory()->getTTL() * 60,
			'user'         => auth()->user()->id,
		]);
	}
}
