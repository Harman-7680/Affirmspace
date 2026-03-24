<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Contact Message</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f4f6f8; padding:40px">

    <div style="max-width:600px; margin:auto; background:#ffffff; border-radius:10px; overflow:hidden;">

        <!-- HEADER -->
        <div style="text-align:center; padding:20px; background:#f9fafb;">
            <img src="{{ config('app.logo') }}" width="140">
        </div>

        <!-- CONTENT -->
        <div style="padding:25px; color:#333; line-height:1.6;">

            <h2 style="color:#111827">New Contact Message</h2>

            <p><strong>Name:</strong> {{ $data['name'] }}</p>
            <p><strong>Email:</strong> {{ $data['email'] }}</p>
            <p><strong>Subject:</strong> {{ $data['subject'] }}</p>

            <hr style="margin:20px 0;">

            <p><strong>Message:</strong></p>
            <p style="white-space: pre-line">{{ $data['message'] }}</p>
        </div>

        <!-- FOOTER -->
        <div style="text-align:center; padding:15px; font-size:12px; color:#999; background:#f9fafb;">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

    </div>

</body>

</html>
