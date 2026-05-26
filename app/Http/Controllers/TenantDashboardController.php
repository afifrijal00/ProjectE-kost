<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class TenantDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cari tenant berdasarkan user login
        $tenant = Tenant::where('user_id', $user->id)->first();

        // Booking user
        $booking = Booking::where('user_id', $user->id)
            ->latest()
            ->first();

        // Payments tenant
        $payments = collect();

        if ($tenant) {
            $payments = Payment::where('tenant_id', $tenant->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard.tenant', compact(
            'user',
            'tenant',
            'booking',
            'payments'
        ));
    }
}