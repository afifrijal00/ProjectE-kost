<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 'available')
                     ->latest()
                     ->take(3)
                     ->get();

        return view('home.index', compact('rooms'));
    }

    public function rooms(Request $request)
{
    $query = Room::where('status', 'available');

    // Filter by type
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Sort
    if ($request->sort == 'highest') {
        $query->orderBy('price', 'desc');
    } else {
        $query->orderBy('price', 'asc');
    }

    $rooms = $query->paginate(8)->withQueryString();

    return view('home.rooms', compact('rooms'));
}

public function roomDetail($id)
{
    $room = Room::findOrFail($id);
    return view('home.room-detail', compact('room'));
}

public function contact()
{
    return view('home.contact');
}

public function sendContact(Request $request)
{
    $request->validate([
        'name' => 'required|max:100',
        'email' => 'required|email',
        'message' => 'required|max:1000',
    ]);

    // sementara belum kirim email/database
    // nanti bisa dikembangkan

    return back()->with('success', 'Pesan berhasil dikirim!');
}

}