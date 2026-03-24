<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Appointment Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 40px;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px;
            background: #f9fafb;
        }

        .content {
            padding: 25px;
        }

        .status {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
            color: {{ $status === 'accepted' ? '#28a745' : '#dc3545' }};
        }

        .panel {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #999;
            background: #f9fafb;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <img src="{{ config('app.logo') }}" width="130">
        </div>

        <!-- CONTENT -->
        <div class="content">

            <p class="status">
                {{ $status === 'accepted' ? 'Appointment Confirmed!' : 'Appointment Update' }}
            </p>

            <p>Hello {{ $appointment->name ?? 'User' }},</p>

            <p>
                Your appointment with
                <strong>{{ $appointment->counselor_name ?? 'Your Counselor' }}</strong>
                has been <strong>{{ strtoupper($status) }}</strong>.
            </p>

            <div class="panel">
                <p><strong>Date:</strong> {{ optional($appointment->availability)->available_date ?? 'N/A' }}</p>

                <p><strong>Time:</strong>
                    @if (optional($appointment->availability)->start_time && optional($appointment->availability)->end_time)
                        {{ \Carbon\Carbon::parse($appointment->availability->start_time)->format('h:i A') }}
                        - {{ \Carbon\Carbon::parse($appointment->availability->end_time)->format('h:i A') }}
                    @else
                        N/A
                    @endif
                </p>
            </div>

            @if ($status === 'accepted')
                <p>Great news! Your counselor will contact you soon.</p>
            @else
                <p>Unfortunately, this appointment was not approved. You may request another slot.</p>
            @endif

        </div>

        <!-- FOOTER -->
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
            Thanks for choosing {{ config('app.name') }}
        </div>

    </div>

</body>

</html>
