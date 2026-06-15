<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extension;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtensionController extends Controller
{
    public function index(Request $request)
    {
        $query = Extension::with(['tenant', 'tenant.room']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $extensions = $query->latest()->paginate(10)->withQueryString();
        return view('admin.extensions.index', compact('extensions'));
    }

    public function show($id)
    {
        $extension = Extension::with(['tenant', 'tenant.room'])->findOrFail($id);
        return view('admin.extensions.show', compact('extension'));
    }

    // APPROVE - perpanjang end_date tenant + buat invoice
    public function approve($id)
    {
        $extension = Extension::with('tenant')->findOrFail($id);
        $tenant    = $extension->tenant;

        $newEndDate = Carbon::parse($tenant->end_date)->addMonths($extension->duration);

        $tenant->update([
            'end_date' => $newEndDate,
            'status'   => 'active',
        ]);

        // Generate invoice paid otomatis (karena sudah bayar full)
        Payment::create([
            'tenant_id'      => $tenant->id,
            'invoice_number' => Payment::generateInvoiceNumber(),
            'amount'         => $extension->amount,
            'due_date'       => now(),
            'transfer_date'  => $extension->transfer_date,
            'sender_name'    => $extension->sender_name,
            'proof_photo'    => $extension->proof_photo,
            'status'         => 'paid',
            'verified_at'    => now(),
            'verified_by'    => Auth::id(),
            'notes'          => 'Perpanjangan kontrak ' . $extension->duration . ' bulan',
        ]);

        $extension->update(['status' => 'approved']);

        return redirect()->route('admin.extensions.index')
            ->with('success', 'Perpanjangan kontrak disetujui. Masa sewa diperpanjang.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['notes' => 'required|string|max:255']);

        $extension = Extension::findOrFail($id);
        $extension->update([
            'status' => 'rejected',
            'notes'  => $request->notes,
        ]);

        return redirect()->route('admin.extensions.index')
            ->with('success', 'Request perpanjangan ditolak.');
    }

    // APPROVE CHECKOUT
    public function approveCheckout($tenantId)
    {
        $tenant = \App\Models\Tenant::with('room')->findOrFail($tenantId);

        $tenant->update(['status' => 'inactive']);

        if ($tenant->room) {
            $tenant->room->update(['status' => 'available']);
        }

        return redirect()->route('tenants.show', $tenant->id)
            ->with('success', 'Tenant berhasil di-checkout. Kamar tersedia kembali.');
    }
}