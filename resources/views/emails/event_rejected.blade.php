<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Event Rejected</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; padding: 20px;">
        <h2 style="color: #dc3545;">Event Rejected</h2>
        <p>Hi <strong>{{ $user->first_name }}</strong>,</p>
        <p>We appreciate your effort in submitting your event <strong>{{ $event->name }}</strong>. However, after
            review, we regret to inform you that it doesn’t currently meet our community guidelines.</p>
        <p>If you’d like, you can revise and resubmit it for another review.</p>
        <p>For any clarification, feel free to contact our support team.</p>
        <p style="margin-top: 30px;">Warm regards,<br><strong>AffirmSpace Team</strong></p>
    </div>
</body>

</html>
