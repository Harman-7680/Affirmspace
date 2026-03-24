<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>

<body style="font-family: Arial; background:#f4f6f8; padding:40px;">

    <div style="max-width:600px; margin:auto; background:#ffffff; border-radius:10px; overflow:hidden;">

        <!-- HEADER (GLOBAL LOGO) -->
        <div style="text-align:center; padding:20px; background:#f9fafb;">
            <img src="{{ config('app.logo') }}" alt="Logo" width="140">
        </div>

        <!-- CONTENT -->
        <div style="padding:30px;">
            <h2>Hello {{ $user->first_name }}</h2>

            <p>
                Welcome to <strong>{{ config('app.name') }}</strong>.
                Please verify your email to continue.
            </p>

            <a href="{{ $url }}"
                style="display:inline-block; padding:12px 24px;
                       background:#4f46e5; color:#fff;
                       text-decoration:none; border-radius:6px;">
                Verify Email
            </a>

            <p style="margin-top:20px; font-size:13px; color:#666;">
                This link will expire in 60 minutes.
            </p>
        </div>

        <!-- FOOTER -->
        <div style="text-align:center; padding:15px; font-size:12px; color:#999; background:#f9fafb;">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

    </div>

</body>

</html>
