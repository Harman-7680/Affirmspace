<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>

<body style="font-family: Arial; background:#f4f6f8; padding:40px;">
    <div style="max-width:600px; margin:auto; background:#ffffff; padding:30px; border-radius:10px;">
        <h2>Hello {{ $user->first_name }}</h2>

        <p>Welcome to <strong>AffirmSpace</strong>.
            Please verify your email to continue.</p>

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
</body>

</html>
