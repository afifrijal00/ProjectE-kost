<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // INDEX
    public function index()
    {
        return view('reports.index');
    }

    // INCOME REPORT
    public function income(Request $request)
    {
        $startMonth = $request->input('start_month', now()->startOfYear()->format('Y-m'));
        $endMonth   = $request->input('end_month', now()->format('Y-m'));

        $startDate = Carbon::parse($startMonth . '-01')->startOfMonth();
        $endDate   = Carbon::parse($endMonth . '-01')->endOfMonth();

        // Total income
        $totalIncome = Payment::where('status', 'paid')
            ->whereBetween('verified_at', [$startDate, $endDate])
            ->sum('amount');

        // Total transactions
        $totalTransactions = Payment::where('status', 'paid')
            ->whereBetween('verified_at', [$startDate, $endDate])
            ->count();

        // Average monthly income
        $monthDiff = $startDate->diffInMonths($endDate) + 1;
        $avgMonthly = $monthDiff > 0 ? $totalIncome / $monthDiff : 0;

        // Income per bulan untuk chart
        $incomeChart = [];
        $current = $startDate->copy();
        while ($current <= $endDate) {
            $incomeChart[] = [
                'month'  => $current->format('M Y'),
                'amount' => Payment::where('status', 'paid')
                    ->whereMonth('verified_at', $current->month)
                    ->whereYear('verified_at', $current->year)
                    ->sum('amount'),
            ];
            $current->addMonth();
        }

        $maxIncome = max(array_column($incomeChart, 'amount')) ?: 1;

        return view('reports.income', compact(
            'totalIncome',
            'totalTransactions',
            'avgMonthly',
            'incomeChart',
            'maxIncome',
            'startMonth',
            'endMonth'
        ));
    }

    // OCCUPANCY REPORT
    public function occupancy()
    {
        $totalRooms       = Room::count();
        $occupiedRooms    = Room::where('status', 'occupied')->count();
        $availableRooms   = Room::where('status', 'available')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        $occupancyRate    = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;
        $availableRate    = $totalRooms > 0 ? round(($availableRooms / $totalRooms) * 100) : 0;
        $maintenanceRate  = $totalRooms > 0 ? round(($maintenanceRooms / $totalRooms) * 100) : 0;

        $rooms = Room::with(['activeTenant'])->orderBy('room_number')->get();

        return view('reports.occupancy', compact(
            'totalRooms',
            'occupiedRooms',
            'availableRooms',
            'maintenanceRooms',
            'occupancyRate',
            'availableRate',
            'maintenanceRate',
            'rooms'
        ));
    }

    public function exportOccupancyPdf()
{
    $totalRooms       = Room::count();
    $occupiedRooms    = Room::where('status', 'occupied')->count();
    $availableRooms   = Room::where('status', 'available')->count();
    $maintenanceRooms = Room::where('status', 'maintenance')->count();

    $occupancyRate   = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;
    $availableRate   = $totalRooms > 0 ? round(($availableRooms / $totalRooms) * 100) : 0;
    $maintenanceRate = $totalRooms > 0 ? round(($maintenanceRooms / $totalRooms) * 100) : 0;

    $rooms = Room::with(['activeTenant'])->orderBy('room_number')->get();

    $pdf = Pdf::loadView('reports.occupancy-pdf', compact(
        'totalRooms',
        'occupiedRooms',
        'availableRooms',
        'maintenanceRooms',
        'occupancyRate',
        'availableRate',
        'maintenanceRate',
        'rooms'
    ))->setPaper('a4', 'portrait');

    return $pdf->download('occupancy-report-' . now()->format('Y-m-d') . '.pdf');
}

    public function exportIncomePdf(Request $request)
{
    $startMonth = $request->input('start_month', now()->startOfYear()->format('Y-m'));
    $endMonth   = $request->input('end_month', now()->format('Y-m'));

    $startDate = Carbon::parse($startMonth . '-01')->startOfMonth();
    $endDate   = Carbon::parse($endMonth . '-01')->endOfMonth();

    $totalIncome = Payment::where('status', 'paid')
        ->whereBetween('verified_at', [$startDate, $endDate])
        ->sum('amount');

    $totalTransactions = Payment::where('status', 'paid')
        ->whereBetween('verified_at', [$startDate, $endDate])
        ->count();

    $monthDiff  = $startDate->diffInMonths($endDate) + 1;
    $avgMonthly = $monthDiff > 0 ? $totalIncome / $monthDiff : 0;

    $payments = Payment::with(['tenant', 'tenant.room'])
        ->where('status', 'paid')
        ->whereBetween('verified_at', [$startDate, $endDate])
        ->latest('verified_at')
        ->get();

    $pdf = Pdf::loadView('reports.income-pdf', compact(
        'totalIncome',
        'totalTransactions',
        'avgMonthly',
        'payments',
        'startMonth',
        'endMonth'
    ))->setPaper('a4', 'portrait');

    return $pdf->download('income-report-' . $startMonth . '-to-' . $endMonth . '.pdf');
}
}