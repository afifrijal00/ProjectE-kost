<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    public function index()
    {
        // tandai semua complaint jadi sudah dibaca
        Complaint::where('is_read', false)
            ->update(['is_read' => true]);

        // ambil semua data complaint
        $complaints = Complaint::latest()->get();

        return view('complaints.index', compact('complaints'));
    }
    public function show($id)
    {
    $complaint = Complaint::findOrFail($id);

    return view('complaints.show', compact('complaint'));
    }
}