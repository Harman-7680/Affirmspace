<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }} OTP Verification</title>
</head>

<body style="font-family: 'Arial', sans-serif; background-color: #f4f7fa; margin: 0; padding: 0;">

    <table align="center" width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden;">

        <!-- HEADER -->
        <tr>
            <td style="background-color: #f9fafb; text-align: center; padding: 20px;">
                <img src="{{ config('app.logo') }}" alt="Logo" width="120">
                <h1 style="color: #2563eb; margin: 10px 0 0; font-size: 20px;">
                    {{ config('app.name') }} Verification
                </h1>
            </td>
        </tr>

        <!-- CONTENT -->
        <tr>
            <td style="padding: 30px; color: #333333;">

                <h2 style="margin-bottom: 10px;">Hello 👋</h2>

                <p style="font-size: 16px; line-height: 1.5; color: #444;">
                    Thank you for connecting with <strong>{{ config('app.name') }}</strong>!
                    To complete your verification, please use the OTP below:
                </p>

                <div style="text-align: center; margin: 30px 0;">
                    <span style="font-size: 36px; font-weight: bold; color: #2563eb; letter-spacing: 5px;">
                        {{ $otp }}
                    </span>
                </div>

                <p style="font-size: 15px; color: #555;">
                    This code is valid for <strong>5 minutes</strong>.
                    Please do not share it with anyone.
                </p>

                <p style="margin-top: 30px; font-size: 14px; color: #888;">
                    — The {{ config('app.name') }} Team 🌿
                    <br>
                    <a href="https://affirmspace.com"
                        style="color: #2563eb; text-decoration: none;">www.affirmspace.com</a>
                </p>

            </td>
        </tr>

        <!-- FOOTER -->
        <tr>
            <td style="background-color: #f1f5f9; text-align: center; padding: 15px; font-size: 13px; color: #777;">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </td>
        </tr>

    </table>

</body>

</html>
