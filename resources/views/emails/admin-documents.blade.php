<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Counselor Documents</title>
</head>

<body style="font-family: Arial; background:#f4f6f8; padding:40px;">

    <div style="max-width:600px; background:white; border-radius:10px; overflow:hidden; margin:auto;">

        <!-- HEADER -->
        <div style="text-align:center; padding:20px; background:#f9fafb;">
            <img src="{{ config('app.logo') }}" width="130">
        </div>

        <!-- CONTENT -->
        <div style="padding:25px; color:#333; line-height:1.6;">

            <h2 style="color:#333;">New Counselor Document Submission</h2>

            <p>A counselor has uploaded documents for verification.</p>

            <hr style="margin:20px 0;">

            <p><strong>Name:</strong> {{ $user->first_name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>User ID:</strong> {{ $user->id }}</p>

            <hr style="margin:20px 0;">

            <p>Please login to admin panel to verify documents.</p>

        </div>

        <!-- FOOTER -->
        <div style="text-align:center; padding:15px; font-size:12px; color:#999; background:#f9fafb;">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

    </div>

</body>

</html>
