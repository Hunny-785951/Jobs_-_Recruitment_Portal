<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- REGISTRATION ---
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validate the incoming data (Now including the role!)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin', // Security check: Only allow these two roles
        ]);

        // 2. Create the user with their chosen role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, 
        ]);

        // 3. Log them in automatically
        Auth::login($user);

        // Redirect with extra "Welcome" data
        return redirect()->route('dashboard')
            ->with('signup_success', true)
            ->with('user_name', $user->name)
            ->with('user_role', $user->role);

        // 4. Send them to the smart dashboard we built earlier
        return redirect()->route('dashboard')->with('success', 'Welcome to CrestCareers!');
    }

    // --- LOGIN ---
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
}