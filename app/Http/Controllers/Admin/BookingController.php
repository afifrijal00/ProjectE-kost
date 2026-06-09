<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tenant;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // INDEX - list semua booking
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'room']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();
        return view('dashboard.bookings', compact('bookings'));
    }

    // SHOW - detail booking
    public function show($id)
    {
        $booking = Booking::with(['user', 'room'])->findOrFail($id);
        return view('dashboard.booking-detail', compact('booking'));
    }

    // APPROVE - jadikan tenant aktif
    public function approve(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
        ]);

        $booking = Booking::with(['user', 'room'])->findOrFail($id);

        // Hitung end date
        $startDate = Carbon::parse($request->start_date);
        $endDate   = $startDate->copy()->addMonths($booking->duration);

        // Update tenant yang sudah ada atau buat baru
$tenant = Tenant::where('user_id', $booking->user_id)->first();

if ($tenant) {
    $tenant->update([
        'room_id'    => $booking->room_id,
        'duration'   => $booking->duration,
        'start_date' => $startDate,
        'end_date'   => $endDate,
        'status'     => 'active',
    ]);
} else {
    $tenant = Tenant::create([
        'user_id'    => $booking->user_id,
        'room_id'    => $booking->room_id,
        'name'       => $booking->user->name,
        'email'      => $booking->user->email,
        'phone'      => $booking->user->phone ?? '-',
        'nik'        => '-',
        'duration'   => $booking->duration,
        'start_date' => $startDate,
        'end_date'   => $endDate,
        'status'     => 'active',
    ]);
}

        // Update status room jadi occupied
        $booking->room->update(['status' => 'occupied']);

        // Generate invoice pertama
        Payment::create([
            'tenant_id'      => $tenant->id,
            'invoice_number' => Payment::generateInvoiceNumber(),
            'amount'         => $booking->room->price,
            'due_date'       => $startDate,
            'status'         => 'pending',
        ]);

        // Update status booking
        $booking->update([
            'status'     => 'approved',
            'start_date' => $startDate,
            'notes'      => $request->notes,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking diapprove! Tenant berhasil diaktifkan.');
    }

    // REJECT
    public function reject(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:255',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'rejected',
            'notes'  => $request->notes,
        ]);

        // Kembalikan status room
        $booking->room->update(['status' => 'available']);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking ditolak.');
    }
}