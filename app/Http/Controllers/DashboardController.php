<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

	public function index()
	{
		return response()->json(['success' => true, "You're in the Dashboard"]);
	}
}
