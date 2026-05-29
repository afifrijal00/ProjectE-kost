<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index()
    {
        // tandai complaint belum dibaca jadi sudah dibaca
        Complaint::where('is_read', false)
            ->update(['is_read' => true]);

        // data complaint berdasarkan status
        $open = Complaint::with(['tenant', 'tenant.room'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $process = Complaint::with(['tenant', 'tenant.room'])
            ->where('status', 'process')
            ->latest()
            ->get();

        $resolved = Complaint::with(['tenant', 'tenant.room'])
            ->whereIn('status', ['resolved', 'rejected'])
            ->latest()
            ->get();

        return view('complaints.index', compact('open', 'process', 'resolved'));
    }

    public function show($id)
    {
        $complaint = Complaint::with([
            'tenant',
            'tenant.room',
            'respondedBy'
        ])->findOrFail($id);

        return view('complaints.show', compact('complaint'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:process,resolved,rejected',
        ]);

        $complaint = Complaint::findOrFail($id);

        $complaint->update([
            'status'       => $request->status,
            'responded_by' => Auth::id(),
            'responded_at' => now(),
        ]);

        return redirect()
            ->route('complaints.show', $id)
            ->with('success', 'Status complaint berhasil diupdate!');
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_response' => 'required|string|max:1000',
        ]);

        $complaint = Complaint::findOrFail($id);

        $complaint->update([
            'admin_response' => $request->admin_response,
            'responded_by'   => Auth::id(),
            'responded_at'   => now(),
        ]);

        return redirect()
            ->route('complaints.show', $id)
            ->with('success', 'Balasan berhasil dikirim!');
    }
}