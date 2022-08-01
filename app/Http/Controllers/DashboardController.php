<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

	public function index(): JsonResponse
	{
		return response()->json(['success' => true, "You're in the Dashboard"]);
	}
}
