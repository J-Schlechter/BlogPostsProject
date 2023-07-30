<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function verifyToken(Request $request)
    {
        // Your token verification logic here
        // For example, you can use the built-in Auth facade to verify the token
        if (Auth::check()) {
            return response()->json(['message' => 'Token is valid'], 200);
        } else {
            return response()->json(['message' => 'Token is invalid'], 401);
        }
    }
}
