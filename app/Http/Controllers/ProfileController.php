<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
{
    $user   = Auth::user();
    $tenant = \App\Models\Tenant::where('user_id', $user->id)->first();

    if ($user->role === 'admin') {
        return view('profile.admin-index', compact('user', 'tenant'));
    }

    return view('profile.tenant-index', compact('user', 'tenant'));
}

public function edit()
{
    $user   = Auth::user();
    $tenant = \App\Models\Tenant::where('user_id', $user->id)->first();

    if ($user->role === 'admin') {
        return view('profile.admin-edit', compact('user', 'tenant'));
    }

    return view('profile.tenant-edit', compact('user', 'tenant'));
}

    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'  => 'required|string|max:255',
        'phone' => $user->role === 'admin' ? 'nullable' : 'required|string|max:20',
    ]);

    $user->update(['name' => $request->name]);

    if ($user->role !== 'admin') {
        $tenant = \App\Models\Tenant::where('user_id', $user->id)->first();
        if ($tenant) {
            $tenant->update([
                'name'  => $request->name,
                'phone' => $request->phone,
            ]);
        }
    }

    

    return redirect()->route('profile.index')->with('success', 'Profil berhasil diupdate!');
}

public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'password'         => 'required|min:8|confirmed',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
    }

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('profile.index')
        ->with('success', 'Password berhasil diubah!');
}

}