<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Contact Message</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f9fafb; padding:20px">

    <div style="max-width:600px; margin:auto; background:#ffffff; padding:20px; border-radius:10px">
        <h2 style="color:#111827">New Contact Message</h2>

        <p><strong>Name:</strong> {{ $data['name'] }}</p>
        <p><strong>Email:</strong> {{ $data['email'] }}</p>
        <p><strong>Subject:</strong> {{ $data['subject'] }}</p>

        <hr>

        <p><strong>Message:</strong></p>
        <p style="white-space: pre-line">{{ $data['message'] }}</p>

        <hr>
        <p style="font-size:12px;color:#6b7280">
            Sent from Contact Us form
        </p>
    </div>

</body>

</html>
