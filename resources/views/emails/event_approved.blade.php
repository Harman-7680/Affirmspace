<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Event Approved</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 40px;">

    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 10px; overflow:hidden;">

        <!-- HEADER -->
        <div style="text-align:center; padding:20px; background:#f9fafb;">
            <img src="{{ config('app.logo') }}" width="140">
        </div>

        <!-- CONTENT -->
        <div style="padding:25px; color:#333; line-height:1.6;">

            <h2 style="color: #28a745;">Event Approved Successfully!</h2>

            <p>Hi <strong>{{ $user->first_name }}</strong>,</p>

            <p>
                We’re excited to inform you that your event
                <strong>{{ $event->name }}</strong> has been approved and is now
                visible to the community.
            </p>

            <p>
                Thank you for contributing to our platform and helping people connect through your event!
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
