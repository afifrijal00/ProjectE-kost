<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WhatsappService;

class BookingController extends Controller
{
    // CREATE - tampilkan form booking
    public function create(Request $request)
    {
        $room = Room::findOrFail($request->room_id);
        return view('booking.create', compact('room'));
    }

    // STORE - simpan booking, lanjut ke halaman QRIS
    public function store(Request $request)
    {
        $request->validate([
            'room_id'    => 'required|exists:rooms,id',
            'duration'   => 'required|in:1,3,6,12',
            'start_date' => 'required|date|after_or_equal:today',
        ]);

        $room     = Room::findOrFail($request->room_id);
        $dpAmount = $room->price * 0.5; // DP 50%

        $booking = Booking::create([
            'user_id'      => Auth::id(),
            'room_id'      => $room->id,
            'booking_code' => Booking::generateBookingCode(),
            'duration'     => $request->duration,
            'start_date'   => $request->start_date,
            'dp_amount'    => $dpAmount,
            'status'       => 'pending',
            'dp_status'    => 'pending',
        ]);

        return redirect()->route('booking.upload-dp', ['booking' => $booking->id]);
    }

    // UPLOAD DP - tampilkan halaman QRIS & rekening
    public function uploadDp($bookingId)
    {
        $booking = Booking::with('room')
            ->where('user_id', Auth::id())
            ->findOrFail($bookingId);

        return view('booking.upload-dp', compact('booking'));
    }

    // UPLOAD DP PROOF FORM
    public function uploadDpProof($bookingId)
    {
        $booking = Booking::with('room')
            ->where('user_id', Auth::id())
            ->findOrFail($bookingId);

        return view('booking.upload-dp-proof', compact('booking'));
    }

    // STORE DP PROOF
    public function storeDpProof(Request $request, $bookingId)
{
    $booking = Booking::with('room')->where('user_id', Auth::id())->findOrFail($bookingId);

    $request->validate([
        'sender_name'   => 'required|string|max:255',
        'transfer_date' => 'required|date',
        'proof_photo'   => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $path = $request->file('proof_photo')->store('booking-proofs', 'public');

    $booking->update([
        'sender_name'   => $request->sender_name,
        'transfer_date' => $request->transfer_date,
        'proof_photo'   => $path,
        'dp_status'     => 'verify',
        'status'        => 'dp_paid',
    ]);

    // Kirim notifikasi WA ke admin
    WhatsappService::sendToAdmin(
        "🔔 *Bukti DP Booking Baru*\n\n" .
        "Booking Code: #{$booking->booking_code}\n" .
        "Penyewa: " . Auth::user()->name . "\n" .
        "Kamar: {$booking->room->room_number}\n" .
        "DP: Rp " . number_format($booking->dp_amount, 0, ',', '.') . "\n" .
        "Pengirim: {$request->sender_name}\n" .
        "Tanggal Transfer: {$request->transfer_date}\n\n" .
        "Cek di dashboard admin: " . route('admin.bookings.show', $booking->id)
    );

    return redirect()->route('booking.confirmation', $booking->id)
        ->with('success', 'Bukti DP berhasil dikirim! Menunggu verifikasi admin.');
}

    // CONFIRMATION - halaman sukses
    public function confirmation($bookingId)
    {
        $booking = Booking::with('room')
            ->where('user_id', Auth::id())
            ->findOrFail($bookingId);

        return view('booking.confirmation', compact('booking'));
    }

    // STATUS - tracking status booking
    public function status()
    {
        $booking = Booking::with('room')
            ->where('user_id', Auth::id())
            ->latest()
            ->firstOrFail();

        return view('booking.status', compact('booking'));
    }
}