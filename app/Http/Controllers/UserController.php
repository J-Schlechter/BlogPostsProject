<?php

namespace App\Http\Controllers;

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
    public function login(Request $request){
        $errors = new MessageBag; // initiate MessageBag
        $incommingFields = $request->validate([

            'name' => 'required',
            'password' => 'required'
                      
        ]);
        if (Auth::attempt($incommingFields)){
            $request->session()->regenerate();
            return redirect('/');
        }else{
            $errors = new MessageBag(['password' => ['Email and/or password invalid.']]); // if Auth::attempt fails (wrong credentials) create a new message bag instance.

            return Redirect::back()->withErrors($errors);
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
    return redirect('/');
    }
  
    public function logout(){
        auth()->logout();
        return redirect('/');

    }
}
