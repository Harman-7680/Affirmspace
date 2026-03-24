<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Event Pending Approval</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 40px; color: #333;">

    <div
        style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 10px; overflow:hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

        <!-- HEADER -->
        <div style="text-align: center; padding: 20px; background:#f9fafb;">
            <img src="{{ config('app.logo') }}" width="140">
        </div>

        <!-- CONTENT -->
        <div style="padding: 25px;">

            <h2 style="color: #2563eb; text-align: center;">
                New Paid Event Submitted!
            </h2>

            <p>Hello <strong>Admin</strong>,</p>

            <p>
                A new event has been created and payment has been successfully received.
                The event is now <strong>pending your approval</strong>.
            </p>

            <div
                style="background: #f3f4f6; border-left: 4px solid #2563eb; padding: 15px; border-radius: 4px; margin: 20px 0;">

                <p><strong>Event Name:</strong> {{ $event->name }}</p>
                <p><strong>City:</strong> {{ $event->city }}</p>
                <p><strong>Created By:</strong> {{ $event->user->first_name }} ({{ $event->user->email }})</p>

                <p><strong>Area Range:</strong>
                    @if ($event->area_range == 'above_5km')
                        Above 5 KM
                    @else
                        Up to {{ $event->area_range }} meters
                    @endif
                </p>

                <p><strong>Amount Paid:</strong> ₹{{ $event->amount }}</p>

            </div>

            <p>
                You can review and approve this event by visiting the admin Dashboard
            </p>

            <p style="margin-top: 30px;">
                Best regards,<br>
                <strong>{{ config('app.name') }} Team</strong>
            </p>

        </div>

        <!-- FOOTER -->
        <div style="text-align:center; padding:15px; font-size:12px; color:#999; background:#f9fafb;">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

    </div>

</body>

</html>
