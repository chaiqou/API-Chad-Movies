<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:api');
    }

    public function index() {
        return response()->json(['success' => true , "You're in the Dashboard"]);
    }
}
