<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 30px;
        }

        .header {
            background: #012619;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }

        .message {
            color: #333;
            line-height: 1.6;
            font-size: 15px;
        }

        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #30BF62;
        }

        .footer {
            margin-top: 20px;
            color: #999;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>eKost. Payment Reminder</h2>
        </div>
        <div class="message">
            <p>{{ $template }}</p>
            <hr>
            <p><strong>Tenant:</strong> {{ $tenantName }}</p>
            <p><strong>Room:</strong> {{ $roomNumber }}</p>
            <p><strong>Amount:</strong> <span class="amount">Rp {{ $amount }}</span></p>
            <p><strong>Due Date:</strong> {{ $dueDate }}</p>
        </div>
        <div class="footer">
            <p>e-Kost Management System &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>

</html>