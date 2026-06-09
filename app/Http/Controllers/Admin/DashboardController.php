<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\Complaint;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalTenants    = Tenant::where('status', 'active')->count();
        $totalRooms      = Room::count();
        $availableRooms  = Room::where('status', 'available')->count();
        $openComplaints  = Complaint::whereIn('status', ['pending', 'process'])->count();

        // Monthly income
        $monthlyIncome = Payment::where('status', 'paid')
            ->whereMonth('verified_at', now()->month)
            ->whereYear('verified_at', now()->year)
            ->sum('amount');

        // Income per bulan (6 bulan terakhir)
        $incomeChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $incomeChart[] = [
                'month'  => $month->format('M'),
                'amount' => Payment::where('status', 'paid')
                    ->whereMonth('verified_at', $month->month)
                    ->whereYear('verified_at', $month->year)
                    ->sum('amount'),
            ];
        }

        // Max income untuk chart percentage
        $maxIncome = max(array_column($incomeChart, 'amount')) ?: 1;

        // Recent activity
        $recentPayments   = Payment::with(['tenant'])
            ->where('status', 'paid')
            ->latest('verified_at')
            ->take(3)
            ->get();

        $recentComplaints = Complaint::with(['tenant'])
            ->latest()
            ->take(3)
            ->get();

        $recentBookings   = Booking::with(['user'])
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard.index', compact(
            'totalTenants',
            'totalRooms',
            'availableRooms',
            'openComplaints',
            'monthlyIncome',
            'incomeChart',
            'maxIncome',
            'recentPayments',
            'recentComplaints',
            'recentBookings'
        ));
    }
}