<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TenantComplaintController extends Controller
{
    public function index()
    {
        $tenant = Tenant::where('user_id', Auth::id())->first();

        if (!$tenant) {
            return view('complaintsTenant.index', ['complaints' => collect()]);
        }

        $complaints = Complaint::where('tenant_id', $tenant->id)->latest()->get();
        return view('complaintsTenant.index', compact('complaints'));
    }

    public function create()
    {
        return view('complaintsTenant.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string',
            'description' => 'required|string',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

   

        $tenant = Tenant::where('user_id', Auth::id())->first();

        if (!$tenant) {
            return redirect()->back()->with('error', 'Anda belum terdaftar sebagai tenant aktif.');
        }

        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('complaints', 'public');
        }

        Complaint::create([
            'tenant_id'   => $tenant->id,
            'title'       => $request->title,
            'category'    => $request->category,
            'description' => $request->description,
            'photo'       => $photo,
        ]);

        return redirect()->route('tenant.complaints.index')
            ->with('success', 'Complaint berhasil dikirim!');
    }

    public function myComplaints()
    {
        $tenant = Tenant::where('user_id', Auth::id())->first();

        if (!$tenant) {
            return view('complaints.my-complaints', ['complaints' => collect()]);
        }

        $complaints = Complaint::where('tenant_id', $tenant->id)->latest()->get();
        return view('complaints.my-complaints', compact('complaints'));
    }

    public function show($id)
    {
        $complaint = Complaint::with('tenant')->findOrFail($id);
        return view('complaints.show-tenant', compact('complaint'));
    }
}