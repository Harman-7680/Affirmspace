<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Event Rejected</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">

    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 10px; overflow:hidden;">

        <!-- HEADER -->
        <div style="text-align:center; padding:20px; background:#f9fafb;">
            <img src="{{ config('app.logo') }}" width="140">
        </div>

        <!-- CONTENT -->
        <div style="padding:25px; color:#333; line-height:1.6;">

            <h2 style="color: #dc3545;">Event Rejected</h2>

            <p>Hi <strong>{{ $user->first_name }}</strong>,</p>

            <p>
                We appreciate your effort in submitting your event
                <strong>{{ $event->name }}</strong>. However, after review, we regret to inform you
                that it doesn’t currently meet our community guidelines.
            </p>

            <p>
                If you’d like, you can revise and resubmit it for another review.
            </p>

            <p>
                For any clarification, feel free to contact our support team.
            </p>

            <p style="margin-top: 30px;">
                Warm regards,<br>
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
