{{-- @component('mail::message')
    # Appointment Status Update

    Hello {{ $appointment->name ?? 'User' }},

    Your appointment with **{{ $appointment->counselor_name ?? 'Counselor' }}**
    has been **{{ ucfirst($status) }}**.

    @component('mail::panel')
        **Date:** {{ optional($appointment->availability)->available_date ?? 'N/A' }}
        **Time:** {{ optional($appointment->availability)->start_time }} - {{ optional($appointment->availability)->end_time }}
    @endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Appointment Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f6f6;
            padding: 20px;
            color: #333;
        }

        .email-container {
            background: #ffffff;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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

        .button {
            background: #007bff;
            color: #fff;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 15px;
        }

        .footer {
            margin-top: 20px;
            font-size: 13px;
            color: #666;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <p class="status">
            {{ $status === 'accepted' ? 'Appointment Confirmed!' : 'Appointment Update' }}
        </p>

        <p>Hello {{ $appointment->name ?? 'User' }},</p>
        <p>Your appointment with <strong>{{ $appointment->counselor_name ?? 'Your Counselor' }}</strong> has been
            <strong>{{ strtoupper($status) }}</strong>.
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

        <div class="footer">
            <p>Thanks for choosing AffirmSpace Team</p>
        </div>
    </div>
</body>

</html>
