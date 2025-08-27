<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    /**
     * Handle login process
     */
    public function loginPost(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)
            ->where('email', $request->email)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            return redirect()->route('dashboard')
                ->with('success', 'Login berhasil, selamat datang ' . $user->name . '!');
        }

        return back()->with('error', 'Username, Email, atau Password salah.');
    }

    /**
     * Show register form
     */
    public function register()
    {
        return view('register');
    }

    /**
     * Handle register process
     */
    public function registerPost(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
