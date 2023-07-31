<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ], 200);
        } else {
            $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
            Log::error('Login attempt failed', ['credentials' => $credentials]);
            return response()->json(['errors' => $errors], 401);
        }
    }

    public function register(Request $request){
    $incommingFields = $request->validate([
        'name'  => ['required', 'min:3', Rule::unique('users', 'name')],
        'email' =>['required', 'email', Rule::unique('users', 'email')],
        'password' =>['required', 'min:4', 'max:200'],
        ]);
    $incommingFields['password'] = bcrypt($incommingFields['password']);
    $user = User::create($incommingFields);
    auth()->login($user);
    return response()->json(['message' => 'Registration successful'], 200);
    }
  
    public function logout(){
        auth()->logout();
        return response()->json(['message' => 'Log Out successful'], 200);

    }

    public function getUserData()
    {
        // Retrieve the authenticated user's data
        $user = Auth::user();

        // You can customize the data you want to return, such as only specific fields
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            // Add other fields as needed
        ]);
    }
}
