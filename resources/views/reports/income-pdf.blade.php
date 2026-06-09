<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #012619;
            padding-bottom: 10px;
        }

        .header h1 {
            color: #012619;
            margin: 0;
            font-size: 20px;
        }

        .header p {
            color: #666;
            margin: 5px 0 0;
        }

        .summary {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .summary-card {
            flex: 1;
            background: #f5f5f5;
            padding: 10px;
            border-radius: 6px;
            border-left: 4px solid #30BF62;
        }

        .summary-card h3 {
            margin: 0 0 5px;
            font-size: 11px;
            color: #666;
        }

        .summary-card p {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #012619;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background: #012619;
            color: white;
        }

        th {
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
        }

        td {
            padding: 7px 10px;
            border-bottom: 1px solid #eee;
            font-size: 11px;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #999;
            font-size: 10px;
        }

        .period {
            background: #e8f5e9;
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>e-Kost Management</h1>
        <p>Income Report</p>
    </div>

    <div class="period">
        Period: {{ \Carbon\Carbon::parse($startMonth)->format('F Y') }} -
        {{ \Carbon\Carbon::parse($endMonth)->format('F Y') }}
        &nbsp;&nbsp;|&nbsp;&nbsp; Generated: {{ now()->format('d M Y, H:i') }}
    </div>

    <div class="summary">
        <div class="summary-card">
            <h3>Total Income</h3>
            <p>Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
        <div class="summary-card">
            <h3>Avg Monthly</h3>
            <p>Rp {{ number_format($avgMonthly, 0, ',', '.') }}</p>
        </div>
        <div class="summary-card">
            <h3>Total Transactions</h3>
            <p>{{ $totalTransactions }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice</th>
                <th>Tenant</th>
                <th>Room</th>
                <th>Amount</th>
                <th>Paid Date</th>
                <th>Method</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $i => $payment)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>#{{ $payment->invoice_number }}</td>
                    <td>{{ $payment->tenant->name ?? '-' }}</td>
                    <td>Room {{ $payment->tenant->room->room_number ?? '-' }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>{{ $payment->verified_at?->format('d M Y') }}</td>
                    <td>{{ $payment->payment_method ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:#999;">Tidak ada data pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>e-Kost Management System &copy; {{ date('Y') }} — Generated automatically</p>
    </div>
</body>

</html>