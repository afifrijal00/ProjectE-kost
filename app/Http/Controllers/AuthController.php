<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validated();

        // Cek apakah email sudah terverifikasi
        $user = User::where('email', $credentials['email'])->first();
        if ($user && !$user->hasVerifiedEmail()) {
            return back()->withErrors([
                'email' => 'Silakan verifikasi email Anda terlebih dahulu. Cek inbox atau spam folder.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            return $user->isAdmin()
                ? redirect()->intended(route('dashboard.index'))
                : redirect()->intended(route('tenant.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email')->with('error', 'Login gagal');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    public function register(RegisterRequest $request)
{
    $validated = $request->validated();

    $user = User::create([
        'name'     => trim($validated['first_name'] . ' ' . $validated['last_name']),
        'email'    => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role'     => 'tenant',
    ]);

    // Buat data tenant kosong otomatis
    \App\Models\Tenant::create([
        'user_id'    => $user->id,
        'name'       => trim($validated['first_name'] . ' ' . $validated['last_name']),
        'email'      => $validated['email'],
        'phone'      => '-',
        'nik'        => null,
        'duration'   => 0,
        'start_date' => now(),
        'end_date'   => now(),
        'status'     => 'pending',
    ]);

    // Trigger email verification
    event(new Registered($user));
    Auth::login($user);

    return redirect()->route('verification.notice')
    ->with('success', 'Registrasi berhasil! Silakan verifikasi email Anda.');
}

// KIRIM LINK RESET PASSWORD
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Link reset password telah dikirim ke email Anda.')
            : back()->withErrors(['email' => __($status)]);
    }

    // FORM RESET PASSWORD
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    // PROSES RESET PASSWORD
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login.')
            : back()->withErrors(['email' => __($status)]);
    }
    
}