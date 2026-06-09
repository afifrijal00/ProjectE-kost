<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Occupancy Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #012619;
            font-size: 20px;
            margin-bottom: 4px;
        }

        .subtitle {
            color: #6b7280;
            font-size: 11px;
            margin-bottom: 20px;
        }

        .summary {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px 20px;
            flex: 1;
            text-align: center;
        }

        .card .label {
            color: #6b7280;
            font-size: 10px;
            margin-bottom: 4px;
        }

        .card .value {
            font-size: 22px;
            font-weight: bold;
            color: #012619;
        }

        .card.green {
            border-top: 3px solid #30BF62;
        }

        .card.blue {
            border-top: 3px solid #60a5fa;
        }

        .card.red {
            border-top: 3px solid #f87171;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        thead tr {
            background-color: #012619;
            color: white;
        }

        th {
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
        }

        td {
            padding: 7px 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .badge {
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .occupied {
            background: #e5e7eb;
            color: #374151;
        }

        .available {
            background: #d1fae5;
            color: #065f46;
        }

        .maintenance {
            background: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 24px;
            font-size: 10px;
            color: #9ca3af;
            text-align: right;
        }
    </style>
</head>

<body>

    <h1>e-Kost — Occupancy Report</h1>
    <p class="subtitle">Generated on {{ now()->format('d F Y, H:i') }}</p>

    <div class="summary">
        <div class="card green">
            <div class="label">Occupancy Rate</div>
            <div class="value">{{ $occupancyRate }}%</div>
        </div>
        <div class="card">
            <div class="label">Total Rooms</div>
            <div class="value">{{ $totalRooms }}</div>
        </div>
        <div class="card green">
            <div class="label">Occupied</div>
            <div class="value">{{ $occupiedRooms }}</div>
        </div>
        <div class="card blue">
            <div class="label">Available</div>
            <div class="value">{{ $availableRooms }}</div>
        </div>
        <div class="card red">
            <div class="label">Maintenance</div>
            <div class="value">{{ $maintenanceRooms }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Room No.</th>
                <th>Type</th>
                <th>Tenant</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
                <tr>
                    <td><strong>Room {{ $room->room_number }}</strong></td>
                    <td>{{ $room->type }}</td>
                    <td>{{ $room->activeTenant->name ?? '-' }}</td>
                    <td>
                        @if($room->status == 'occupied')
                            <span class="badge occupied">Occupied</span>
                        @elseif($room->status == 'available')
                            <span class="badge available">Available</span>
                        @else
                            <span class="badge maintenance">Maintenance</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#9ca3af;">Belum ada data room.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">e-Kost Management System &mdash; {{ now()->format('Y') }}</div>

</body>

</html>