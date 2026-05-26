<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            // Check if user has a role property (if we add one in the future)
            // For dummy testing, we'll assign role based on email if the column doesn't exist.
            $role = $user->role ?? (str_contains($user->email, 'admin') ? 'admin' : 'tenant');

            if ($role === 'admin') {
                return redirect()->route('dashboard.index');
            }

            return redirect()->route('tenant.dashboard');
        }

        // Dummy fallback logic: if authentication fails, but they use the dummy emails,
        // we can simulate login without a DB just for frontend demo purposes if needed.
        // However, standard Auth is preferred here.

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
