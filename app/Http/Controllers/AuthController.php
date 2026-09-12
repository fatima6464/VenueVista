<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // GET /login
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login', [
            'title' => 'Login | VenueVista',
            'hideNavbar' => true,
            'hideFooter' => true,
        ]);
    }

    // POST /login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return redirect('/login')->with('error', 'Invalid email or password');
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/user/dashboard');
    }

    // GET /register
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.register', [
            'title' => 'Register | VenueVista',
            'hideNavbar' => true,
            'hideFooter' => true,
        ]);
    }

    // POST /register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
            'confirmPassword' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect('/register')->with('error', $validator->errors()->first());
        }

        $data = $validator->validated();

        if ($data['password'] !== $data['confirmPassword']) {
            return redirect('/register')->with('error', 'Passwords do not match');
        }

        if (User::where('email', $data['email'])->exists()) {
            return redirect('/register')->with('error', 'Email already registered');
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }

    // GET /logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
