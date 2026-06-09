<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    // INDEX - list semua tenant
    public function index(Request $request)
    {
        $query = Tenant::with('room');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name atau phone
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $tenants = $query->latest()->paginate(10)->withQueryString();

        return view('tenants.index', compact('tenants'));
    }

    // CREATE - tampilkan form
    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        return view('tenants.create', compact('rooms'));
    }

    // STORE - simpan tenant baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:tenants,email',
            'phone'             => 'required|string|max:20',
            'nik'               => 'nullable|string',
            'ktp_photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'emergency_contact' => 'nullable|string|max:255',
            'room_id'           => 'required|exists:rooms,id',
            'duration'          => 'required|in:1,3,6,12',
            'start_date'        => 'required|date',
            'status'            => 'required|in:active,pending,past',
        ]);

        // Upload KTP
        if ($request->hasFile('ktp_photo')) {
            $validated['ktp_photo'] = $request->file('ktp_photo')->store('ktp', 'public');
        }

        // Hitung end_date otomatis
        $validated['end_date'] = Tenant::calculateEndDate($validated['start_date'], $validated['duration']);

        // Buat tenant
        $tenant = Tenant::create($validated);

        // Update status room jadi occupied
        Room::where('id', $validated['room_id'])->update(['status' => 'occupied']);

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant berhasil ditambahkan!');
    }

    // SHOW - detail tenant
    public function show($id)
    {
        $tenant = Tenant::with(['room', 'user'])->findOrFail($id);
        return view('tenants.show', compact('tenant'));
    }

    // EDIT - tampilkan form edit
    public function edit($id)
    {
        $tenant = Tenant::findOrFail($id);
        $rooms  = Room::where('status', 'available')
                      ->orWhere('id', $tenant->room_id)
                      ->get();
        return view('tenants.edit', compact('tenant', 'rooms'));
    }

    // UPDATE - simpan perubahan
    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:tenants,email,' . $tenant->id,
            'phone'             => 'required|string|max:20',
            'nik'               => 'nullable|string' ,
            'ktp_photo'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'emergency_contact' => 'nullable|string|max:255',
            'room_id'           => 'required|exists:rooms,id',
            'duration'          => 'required|in:1,3,6,12',
            'start_date'        => 'required|date',
            'status'            => 'required|in:active,pending,past',
        ]);

        // Upload KTP baru jika ada
        if ($request->hasFile('ktp_photo')) {
            // Hapus foto lama
            if ($tenant->ktp_photo) {
                Storage::disk('public')->delete($tenant->ktp_photo);
            }
            $validated['ktp_photo'] = $request->file('ktp_photo')->store('ktp', 'public');
        }

        // Hitung ulang end_date
        $validated['end_date'] = Tenant::calculateEndDate($validated['start_date'], $validated['duration']);

        // Jika room berubah, kembalikan status room lama
        if ($tenant->room_id !== (int) $validated['room_id']) {
            Room::where('id', $tenant->room_id)->update(['status' => 'available']);
            Room::where('id', $validated['room_id'])->update(['status' => 'occupied']);
        }

        $tenant->update($validated);

        return redirect()->route('tenants.index')
            ->with('success', 'Data tenant berhasil diperbarui!');
    }

    // DESTROY - hapus tenant
    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);

        // Kembalikan status room
        if ($tenant->room_id) {
            Room::where('id', $tenant->room_id)->update(['status' => 'available']);
        }

        // Hapus foto KTP
        if ($tenant->ktp_photo) {
            Storage::disk('public')->delete($tenant->ktp_photo);
        }

        $tenant->delete();

        return redirect()->route('tenants.index')
            ->with('success', 'Tenant berhasil dihapus!');
    }

    // CONTRACT - tampilkan kontrak PDF
    public function contract($id)
    {
        $tenant = Tenant::with('room')->findOrFail($id);
        return view('tenants.contract', compact('tenant'));
    }
}