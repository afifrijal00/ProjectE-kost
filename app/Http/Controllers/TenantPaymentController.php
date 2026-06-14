<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WhatsappService;

class TenantPaymentController extends Controller
{
    // INDEX - tenant lihat tagihan sendiri
    public function index()
    {
        return redirect()->route('payments.my');
    }

    // MY PAYMENTS - halaman khusus tenant
    public function myPayments()
    {
        $tenant = Tenant::where('user_id', Auth::id())->firstOrFail();

        $payments = Payment::where('tenant_id', $tenant->id)
            ->latest()
            ->paginate(10);

        $currentPayment = Payment::where('tenant_id', $tenant->id)
    ->whereIn('status', ['pending', 'overdue', 'verify'])
    ->latest()
    ->first();

        return view('payments.my-payments', compact('payments', 'tenant', 'currentPayment'));
    }

    // SHOW
    public function show($id)
    {
        $payment = Payment::with(['tenant', 'tenant.room'])->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    // QRIS PAGE - tampilkan QRIS & rekening bank
    public function qris($id)
    {
        $payment = Payment::with(['tenant', 'tenant.room'])->findOrFail($id);
        return view('payments.qris', compact('payment'));
    }

    // UPLOAD PROOF FORM
    public function uploadProof($id)
    {
        $payment = Payment::with(['tenant', 'tenant.room'])->findOrFail($id);
        return view('payments.upload-proof', compact('payment'));
    }

    // STORE PROOF
    public function storeProof(Request $request, $id)
{
    $payment = Payment::with('tenant')->findOrFail($id);

    $request->validate([
        'sender_name'   => 'required|string|max:255',
        'transfer_date' => 'required|date',
        'proof_photo'   => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $path = $request->file('proof_photo')->store('payment-proofs', 'public');

    $payment->update([
        'sender_name'   => $request->sender_name,
        'transfer_date' => $request->transfer_date,
        'proof_photo'   => $path,
        'status'        => 'verify',
    ]);

    // Kirim notifikasi WA ke admin
    WhatsappService::sendToAdmin(
        "🔔 *Bukti Pembayaran Baru*\n\n" .
        "Tenant: {$payment->tenant->name}\n" .
        "Invoice: #{$payment->invoice_number}\n" .
        "Jumlah: Rp " . number_format($payment->amount, 0, ',', '.') . "\n" .
        "Pengirim: {$request->sender_name}\n" .
        "Tanggal Transfer: {$request->transfer_date}\n\n" .
        "Cek di dashboard admin untuk verifikasi: " . route('admin.payments.show', $payment->id)
    );

    return redirect()->route('payments.my')
        ->with('success', 'Bukti pembayaran berhasil dikirim! Menunggu verifikasi admin.');
}
}