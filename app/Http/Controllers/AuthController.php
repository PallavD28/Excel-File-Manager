<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showLogin(){
        return view('auth.login');
    }

    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed', // confirmed rule ensures password_confirmation matches password
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect('/login')->with('success', 'Registration successful. Please login.');
}

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('authToken')->plainTextToken;
            
            // Store token in browser's sessionStorage
            session()->put('jwt_token', $token);
            
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
{
    Auth::logout();
    session()->forget('jwt_token');
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login'); // or any other route you want to redirect after logout
}
}
