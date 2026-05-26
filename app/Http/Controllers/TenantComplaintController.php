<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantComplaintController extends Controller
{
    /**
     * Menampilkan daftar complaint milik tenant
     */
   public function index()
{
    $tenant = Tenant::where('user_id', Auth::id())->first();

    // Jika belum jadi tenant, tampilkan halaman kosong
    if (!$tenant) {
        return view('complaintsTenant.index', ['complaints' => collect()]);
    }

    $complaints = Complaint::where('tenant_id', $tenant->id)
        ->latest()
        ->get();

    return view('complaintsTenant.index', compact('complaints'));
}

    /**
     * Menampilkan form tambah complaint
     */
    public function create()
    {
        return view('complaintsTenant.create');
    }

    /**
     * Menyimpan complaint baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title'       => 'required',
            'category'    => 'required',
            'description' => 'required',
            'photo'       => 'nullable|image|max:2048',
        ]);

        // Ambil data tenant yang sedang login
        $tenant = Tenant::where('user_id', Auth::id())->first();

if (!$tenant) {
    return redirect()->back()->with('error', 'Anda belum terdaftar sebagai tenant aktif.');
}

$photo = null;

        // Upload photo jika ada
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')
                ->store('complaints', 'public');
        }

        // Simpan complaint ke database
        Complaint::create([
            'tenant_id'  => $tenant->id,
            'title'      => $request->title,
            'category'   => $request->category,
            'description'=> $request->description,
            'photo'      => $photo,
        ]);

        // Redirect kembali ke halaman complaint
        return redirect()
            ->route('tenant.complaints.index')
            ->with('success', 'Complaint berhasil dikirim');
    }
}