<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Event Approved</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; padding: 20px;">
        <h2 style="color: #28a745;">Event Approved Successfully!</h2>
        <p>Hi <strong>{{ $user->first_name }}</strong>,</p>
        <p>We’re excited to inform you that your event <strong>{{ $event->name }}</strong> has been approved and is now
            visible to the community.</p>

        <p>Thank you for contributing to our platform and helping people connect through your event!</p>
        <p style="margin-top: 30px;">Best regards,<br><strong>AffirmSpace Team</strong></p>
    </div>
</body>

</html>
