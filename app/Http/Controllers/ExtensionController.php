<?php

namespace App\Http\Controllers;

use App\Models\Extension;
use App\Models\Tenant;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtensionController extends Controller
{
    // FORM PILIH DURASI PERPANJANGAN
    public function create()
    {
        $tenant = Tenant::with('room')->where('user_id', Auth::id())->firstOrFail();
        return view('extensions.create', compact('tenant'));
    }

    // STORE - simpan request, lanjut ke QRIS
    public function store(Request $request)
    {
        $request->validate([
            'duration' => 'required|in:1,3,6,12',
        ]);

        $tenant = Tenant::with('room')->where('user_id', Auth::id())->firstOrFail();
        $amount = $tenant->room->price * (int) $request->duration;

        $extension = Extension::create([
            'tenant_id' => $tenant->id,
            'duration'  => $request->duration,
            'amount'    => $amount,
            'status'    => 'pending',
        ]);

        return redirect()->route('extensions.qris', $extension->id);
    }

    // QRIS PAGE
    public function qris($id)
    {
        $extension = Extension::with('tenant.room')
            ->whereHas('tenant', fn($q) => $q->where('user_id', Auth::id()))
            ->findOrFail($id);

        return view('extensions.qris', compact('extension'));
    }

    // UPLOAD PROOF FORM
    public function uploadProof($id)
    {
        $extension = Extension::with('tenant.room')
            ->whereHas('tenant', fn($q) => $q->where('user_id', Auth::id()))
            ->findOrFail($id);

        return view('extensions.upload-proof', compact('extension'));
    }

    // STORE PROOF
    public function storeProof(Request $request, $id)
    {
        $extension = Extension::with('tenant')
            ->whereHas('tenant', fn($q) => $q->where('user_id', Auth::id()))
            ->findOrFail($id);

        $request->validate([
            'sender_name'   => 'required|string|max:255',
            'transfer_date' => 'required|date',
            'proof_photo'   => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('proof_photo')->store('extension-proofs', 'public');

        $extension->update([
            'sender_name'   => $request->sender_name,
            'transfer_date' => $request->transfer_date,
            'proof_photo'   => $path,
            'status'        => 'verify',
        ]);

        WhatsappService::sendToAdmin(
            "🔔 *Request Perpanjangan Kontrak*\n\n" .
            "Tenant: {$extension->tenant->name}\n" .
            "Durasi Tambahan: {$extension->duration} bulan\n" .
            "Total: Rp " . number_format($extension->amount, 0, ',', '.') . "\n" .
            "Pengirim: {$request->sender_name}\n\n" .
            "Cek di dashboard admin: " . route('admin.extensions.show', $extension->id)
        );

        return redirect()->route('tenant.dashboard')
            ->with('success', 'Bukti pembayaran perpanjangan dikirim! Menunggu verifikasi admin.');
    }

    // CHECKOUT REQUEST
    public function requestCheckout(Request $request)
    {
        $request->validate([
            'checkout_reason' => 'required|string|max:500',
        ]);

        $tenant = Tenant::where('user_id', Auth::id())->firstOrFail();
        $tenant->update([
            'status' => 'checkout_requested',
        ]);

        WhatsappService::sendToAdmin(
            "🔔 *Request Akhiri Sewa*\n\n" .
            "Tenant: {$tenant->name}\n" .
            "Kamar: " . ($tenant->room->room_number ?? '-') . "\n" .
            "Alasan: {$request->checkout_reason}\n\n" .
            "Cek di dashboard admin untuk approve."
        );

        return redirect()->route('tenant.dashboard')
            ->with('success', 'Permintaan akhiri sewa terkirim. Menunggu konfirmasi admin.');
    }
}