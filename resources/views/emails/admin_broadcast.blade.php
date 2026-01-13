<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Message from Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0; padding:0; background:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
        <tr>
            <td align="center">

                <table width="100%" max-width="600px" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#0d6efd,#0056d6); padding:20px 30px;">
                            <h2 style="margin:0; color:#ffffff;">📢 Message from Admin</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;">
                            <p style="font-size:15px; color:#333; margin:0 0 10px;">
                                Hello <strong>{{ $userName }}</strong>,
                            </p>

                            <div
                                style="
                            background:#f8f9fa;
                            border-left:4px solid #0d6efd;
                            padding:15px 18px;
                            margin:20px 0;
                            font-size:15px;
                            color:#333;
                            line-height:1.6;
                            border-radius:6px;
                        ">
                                {!! nl2br(e($messageText)) !!}
                            </div>

                            <p style="font-size:14px; color:#555;">
                                If you have any questions, feel free to reply or contact support.
                            </p>

                            <p style="margin-top:30px; font-size:14px; color:#333;">
                                Regards,<br>
                                <strong>Admin Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f1f3f5; padding:15px; text-align:center; font-size:12px; color:#777;">
                            © {{ date('Y') }} AffirmSpace. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>

</html>
