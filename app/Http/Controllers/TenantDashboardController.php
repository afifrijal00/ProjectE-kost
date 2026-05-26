<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;
=======
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Tenant;
>>>>>>> 4ab8dc1b82b01b767d1d60ea3afe6d0957f457b1
use Illuminate\Support\Facades\Auth;

class TenantDashboardController extends Controller
{
<<<<<<< HEAD
    /**
     * Show the tenant dashboard.
     */
    public function index()
    {
        // Use authenticated user or dummy data if not logged in (for frontend testing)
        $tenant = Auth::user() ?? (object) [
            'name' => 'Budi Santoso',
            'email' => 'tenant@kos.com'
        ];

        // Dummy room data
        $room = (object) [
            'number' => 'A-102',
            'price' => 1500000,
            'contract_end' => now()->addMonths(6)->format('Y-m-d')
        ];

        // Dummy last payment data
        $lastPayment = (object) [
            'amount' => 1500000,
            'date' => now()->subDays(10)->format('Y-m-d'),
            'status' => 'Paid'
        ];

        // Dummy next due date
        $nextDueDate = now()->addDays(20)->format('Y-m-d');

        // Dummy recent complaints (limit 3)
        $complaints = [
            (object) [
                'id' => 1, 
                'title' => 'AC Kurang Dingin', 
                'status' => 'Pending', 
                'date' => now()->subDays(2)->format('Y-m-d')
            ],
            (object) [
                'id' => 2, 
                'title' => 'Lampu Kamar Mandi Mati', 
                'status' => 'Resolved', 
                'date' => now()->subDays(15)->format('Y-m-d')
            ],
            (object) [
                'id' => 3, 
                'title' => 'Kran Air Bocor', 
                'status' => 'Resolved', 
                'date' => now()->subMonths(1)->format('Y-m-d')
            ],
        ];

        return view('tenant.dashboard', compact('tenant', 'room', 'lastPayment', 'nextDueDate', 'complaints'));
    }
}
=======
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
>>>>>>> 4ab8dc1b82b01b767d1d60ea3afe6d0957f457b1
