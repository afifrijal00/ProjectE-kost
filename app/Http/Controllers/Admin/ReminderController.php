<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ReminderMail;
use App\Models\Payment;
use App\Models\Reminder;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReminderController extends Controller
{
    // INDEX - list reminder logs
    public function index(Request $request)
    {
        $query = Reminder::with(['tenant', 'tenant.room', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reminders = $query->latest()->paginate(20)->withQueryString();
        return view('reminders.index', compact('reminders'));
    }

    // SETTINGS PAGE
    public function settings()
    {
        return view('reminders.settings');
    }

    // SEND MANUAL REMINDER
    public function send(Request $request)
    {
        $request->validate([
            'type'     => 'required|in:H-3,H-1,overdue',
            'template' => 'required|string',
        ]);

        $type     = $request->type;
        $template = $request->template;
        $count    = 0;
        $failed   = 0;

        // Tentukan filter payment berdasarkan type
        if ($type == 'H-3') {
            $targetDate = Carbon::now()->addDays(3)->toDateString();
            $payments   = Payment::with(['tenant', 'tenant.room'])
                ->whereIn('status', ['pending'])
                ->whereDate('due_date', $targetDate)
                ->get();
        } elseif ($type == 'H-1') {
            $targetDate = Carbon::now()->addDays(1)->toDateString();
            $payments   = Payment::with(['tenant', 'tenant.room'])
                ->whereIn('status', ['pending'])
                ->whereDate('due_date', $targetDate)
                ->get();
        } else {
            // Overdue
            $payments = Payment::with(['tenant', 'tenant.room'])
                ->where('status', 'overdue')
                ->get();
        }

        foreach ($payments as $payment) {
            $tenant = $payment->tenant;

            if (!$tenant || !$tenant->email) continue;

            // Replace template variables
            $message = str_replace(
                ['{tenant_name}', '{room}', '{amount}', '{due_date}'],
                [
                    $tenant->name,
                    'Room ' . ($tenant->room->room_number ?? '-'),
                    number_format($payment->amount, 0, ',', '.'),
                    $payment->due_date->format('d M Y'),
                ],
                $template
            );

            try {
                Mail::to($tenant->email)->send(new ReminderMail(
                    tenantName: $tenant->name,
                    roomNumber: $tenant->room->room_number ?? '-',
                    amount:     number_format($payment->amount, 0, ',', '.'),
                    dueDate:    $payment->due_date->format('d M Y'),
                    type:       $type,
                    template:   $message,
                ));

                Reminder::create([
                    'tenant_id'  => $tenant->id,
                    'payment_id' => $payment->id,
                    'type'       => $type,
                    'channel'    => 'email',
                    'status'     => 'sent',
                    'message'    => $message,
                    'sent_at'    => now(),
                ]);

                $count++;

            } catch (\Exception $e) {
                Reminder::create([
                    'tenant_id'  => $tenant->id,
                    'payment_id' => $payment->id,
                    'type'       => $type,
                    'channel'    => 'email',
                    'status'     => 'failed',
                    'message'    => $e->getMessage(),
                    'sent_at'    => now(),
                ]);

                $failed++;
            }
        }

        $message = "Reminder terkirim: {$count} email.";
        if ($failed > 0) $message .= " Gagal: {$failed}.";
        if ($count === 0 && $failed === 0) $message = "Tidak ada tenant yang perlu diingatkan untuk tipe {$type}.";

        return redirect()->route('reminders.index')->with('success', $message);
    }
}