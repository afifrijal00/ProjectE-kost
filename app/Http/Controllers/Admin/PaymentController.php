<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // INDEX
    public function index(Request $request)
    {
        $query = Payment::with(['tenant', 'tenant.room']);

        Payment::where('status', 'pending')
            ->where('due_date', '<', now())
            ->update(['status' => 'overdue']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('invoice_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('tenant', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $payments      = $query->latest()->paginate(10)->withQueryString();
        $pendingCount  = Payment::where('status', 'verify')->count();
        $verifiedTotal = Payment::where('status', 'paid')->whereMonth('verified_at', now()->month)->sum('amount');
        $overdueCount  = Payment::where('status', 'overdue')->count();

        return view('payments.index', compact('payments', 'pendingCount', 'verifiedTotal', 'overdueCount'));
    }

    // SHOW
    public function show($id)
    {
        $payment = Payment::with(['tenant', 'tenant.room', 'verifiedBy'])->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    // APPROVE
    public function approve($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'status'      => 'paid',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        return redirect()->route('payments.show', $id)
            ->with('success', 'Pembayaran berhasil diverifikasi!');
    }

    // REJECT
    public function reject(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:255',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update([
            'status' => 'pending',
            'notes'  => $request->notes,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Pembayaran ditolak, tenant perlu upload ulang.');
    }
}