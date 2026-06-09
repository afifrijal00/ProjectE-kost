<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class TenantPaymentController extends Controller
{
    public function __construct()
{
    \Midtrans\Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
    \Midtrans\Config::$clientKey    = env('MIDTRANS_CLIENT_KEY');
    \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
    \Midtrans\Config::$isSanitized  = env('MIDTRANS_IS_SANITIZED', true);
    \Midtrans\Config::$is3ds        = env('MIDTRANS_IS_3DS', true);
}

    
    // INDEX - tenant lihat tagihan sendiri
public function index()
{
    return redirect()->route('payments.my');
}

// MY PAYMENTS - halaman khusus tenant
public function myPayments()
{
    $tenant = Tenant::where('user_id', Auth::id())->firstOrFail();

    $payments = Payment::where('tenant_id', $tenant->id)
        ->latest()
        ->paginate(10);

    $currentPayment = Payment::where('tenant_id', $tenant->id)
        ->whereIn('status', ['pending', 'overdue'])
        ->latest()
        ->first();

    return view('payments.my-payments', compact('payments', 'tenant', 'currentPayment'));
}

    // SHOW
    public function show($id)
    {
        $payment = Payment::with(['tenant', 'tenant.room'])->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    // PAY - generate Snap token & tampilkan halaman bayar
    public function pay($id)
    {
        $payment = Payment::with(['tenant', 'tenant.room'])->findOrFail($id);
        $tenant  = $payment->tenant;

        // Generate order ID unik
        $orderId = 'ORDER-' . $payment->id . '-' . time();

        // Parameter Midtrans
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $payment->amount,
            ],
            'customer_details' => [
                'first_name' => $tenant->name,
                'email'      => $tenant->email,
                'phone'      => $tenant->phone,
            ],
            'item_details' => [
                [
                    'id'       => 'ROOM-' . $tenant->room->id,
                    'price'    => (int) $payment->amount,
                    'quantity' => 1,
                    'name'     => 'Sewa Kamar ' . $tenant->room->room_number . ' - ' . $payment->due_date->format('F Y'),
                ]
            ],
        ];

        // Generate Snap Token
        $snapToken = Snap::getSnapToken($params);

        // Simpan order ID & snap token
        $payment->update([
            'midtrans_order_id' => $orderId,
            'snap_token'        => $snapToken,
        ]);

        return view('payments.pay', compact('payment', 'snapToken'));
    }

    // WEBHOOK - terima notifikasi dari Midtrans
    public function webhook(Request $request)
    {
        $notification = new Notification();

        $orderId           = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus       = $notification->fraud_status;
        $paymentType       = $notification->payment_type;

        $payment = Payment::where('midtrans_order_id', $orderId)->firstOrFail();

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $payment->update([
                    'status'         => 'paid',
                    'payment_method' => $paymentType,
                    'verified_at'    => now(),
                ]);
            }
        } elseif ($transactionStatus == 'settlement') {
            $payment->update([
                'status'         => 'paid',
                'payment_method' => $paymentType,
                'verified_at'    => now(),
            ]);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $payment->update(['status' => 'pending']);
        } elseif ($transactionStatus == 'pending') {
            $payment->update(['status' => 'pending']);
        }

        return response()->json(['status' => 'ok']);
    }

    // QRIS PAGE
    public function qris()
    {
        $tenant  = Tenant::where('user_id', Auth::id())->firstOrFail();
        $payment = Payment::where('tenant_id', $tenant->id)
            ->whereIn('status', ['pending', 'overdue'])
            ->latest()
            ->first();
        return view('payments.qris', compact('payment'));
    }
}