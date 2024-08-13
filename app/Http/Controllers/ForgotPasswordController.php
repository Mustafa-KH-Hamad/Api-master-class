<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    
    public function index()
    {
        return view('forgotPassword.index');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email'],
        ]);
        $email = $attributes['email'];
        $isAvailable = DB::table('users')->where('email', $email)->exists();
        if (!$isAvailable) {
            return back()->with('session', 'email already not exist ');
        }
        $token = Str::random(32);
        $hashedToken = Hash::make($token);

        $insert = DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $hashedToken,
            'created_at' => Carbon::now(),
        ]);
        if (!$insert) {
            return back()->with('session', 'Error accured, Please try again !');
        }
        Mail::to($email)->send(new ForgotPasswordMail($email, $hashedToken));

        return back()->with('session', 'Email Sent');
    }

    public function show(Request $request)
    {
        $attributes = $request->all();
        $isSame = DB::table('password_reset_tokens')
            ->where('email', $attributes['email'])
            ->first();
        if ($isSame) {
            $createdAt = Carbon::parse($isSame->created_at);
            $currentTime = Carbon::now();

            if ($isSame->token === $attributes['hashedToken'] && !($createdAt->diffInHours($currentTime) > 1)) {
                return view('forgotPassword.show', ['email' => $attributes['email'], 'hashedToken' => $attributes['hashedToken']]);
            }
        }
        DB::table('password_reset_tokens')->where('email', $attributes['email'])->delete();
        return redirect('/forgotPassword')->with('session', 'Error accured, Please try again !');
    }

    public function save(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email'],
            'hashedToken' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $isSame = DB::table('password_reset_tokens')
            ->where('email', $attributes['email'])
            ->first();
        
        if ($isSame) {
            $createdAt = Carbon::parse($isSame->created_at);
            $currentTime = Carbon::now();
            if ($isSame->token === $attributes['hashedToken'] && !($createdAt->diffInHours($currentTime) > 1)) {
                $update = DB::table('users')
                    ->where('email', $attributes['email'])
                    ->update(['password' => Hash::make($attributes['password'])]);
                    DB::table('password_reset_tokens')->where('email', $attributes['email'])->delete();
                    return redirect('/forgotPassword')->with('session', 'Password changed ');
            }
        }
        DB::table('password_reset_tokens')->where('email', $attributes['email'])->delete();
        return redirect('/forgotPassword')->with('session', 'Error accured, Please try again !');
    }
}
