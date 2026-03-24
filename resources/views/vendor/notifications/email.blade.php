<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">

                <!-- MAIN CARD -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:10px; overflow:hidden;">

                    <!-- HEADER -->
                    <tr>
                        <td style="text-align:center; padding:20px; background:#f9fafb;">
                            <img src="{{ config('app.logo') }}" width="140" alt="Logo">
                        </td>
                    </tr>

                    <!-- CONTENT -->
                    <tr>
                        <td style="padding:30px;">

                            <h2 style="margin-top:0;">Hello {{ $user->first_name ?? 'User' }} 👋</h2>

                            <p style="color:#555;">
                                You are receiving this email because we received a password reset request for your
                                account.
                            </p>

                            <!-- BUTTON -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ $actionUrl }}"
                                    style="background:#374151; color:#fff; padding:12px 25px;
                                           text-decoration:none; border-radius:6px; display:inline-block;">
                                    Reset Password
                                </a>
                            </div>

                            <p style="font-size:14px; color:#777;">
                                This password reset link will expire in 60 minutes.
                            </p>

                            <p style="font-size:14px; color:#777;">
                                If you did not request a password reset, no further action is required.
                            </p>

                            <p style="margin-top:20px;">
                                Regards,<br>
                                <strong>{{ config('app.name') }}</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="text-align:center; padding:15px; font-size:12px; color:#999; background:#f9fafb;">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
