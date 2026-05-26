<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantDashboardController extends Controller
{
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
