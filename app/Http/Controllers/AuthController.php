<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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


        $usernameKey = 'login:username:' . Str::lower($request->username);
        $emailKey    = 'login:email:' . Str::lower($request->email);

        if (RateLimiter::tooManyAttempts($usernameKey, 5)) {
            $seconds = RateLimiter::availableIn($usernameKey);
            return back()->with('error', 'Terlalu banyak percobaan login untuk username ini. Coba lagi dalam ' . gmdate("i:s", $seconds) . ' menit.');
        }

        if (RateLimiter::tooManyAttempts($emailKey, 5)) {
            $seconds = RateLimiter::availableIn($emailKey);
            return back()->with('error', 'Terlalu banyak percobaan login untuk email ini. Coba lagi dalam ' . gmdate("i:s", $seconds) . ' menit.');
        }

        $user = User::where('username', $request->username)
            ->where('email', $request->email)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            RateLimiter::clear($usernameKey);
            RateLimiter::clear($emailKey);

            return redirect()->route('dashboard')
                ->with('success', 'Login berhasil, selamat datang ' . $user->name . '!');
        }

        RateLimiter::hit($usernameKey, 60);
        RateLimiter::hit($emailKey, 60);

        return back()->with('error', 'Username, Email, atau Password salah.');
    }

    public function register()
    {
        return view('register');
    }

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

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
