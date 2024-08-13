<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\Upper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function index()
    {
        return view ('register.index');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required','min:4',new Upper],
            'email' => ['email','required'],
            'password' => ['required','confirmed',Password::defaults()]
        ]);
        
        $user = User::create($attributes);
        Auth::login($user);

        return redirect('/');
    }

}
