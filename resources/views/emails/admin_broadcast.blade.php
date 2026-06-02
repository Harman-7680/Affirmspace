<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Message from AffirmSpace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f3f4f6;padding:40px 15px;">

        <tr>
            <td align="center">

                <!-- MAIN CONTAINER -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="
        max-width:720px;
        width:100%;
        background:#ffffff;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 10px 40px rgba(0,0,0,0.08);
    ">
                    <!-- HEADER -->
                    <tr>
                        <td
                            style="
        background:#e8b7cf;
        padding:45px 20px;
        text-align:center;
    ">

                            <table cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr>

                                    <!-- LOGO ICON -->
                                    <td valign="middle" style="padding-right:14px;">

                                        <img src="https://affirmspace.com/public/images/welcomepage.png" width="62"
                                            style="
                            display:block;
                            border:0;
                        ">

                                    </td>

                                    <!-- BRAND NAME -->
                                    <td valign="middle">

                                        <span
                                            style="
                        font-size:34px;
                        font-weight:700;
                        color:#111827;
                        font-family:Arial,Helvetica,sans-serif;
                        letter-spacing:-1px;
                    ">
                                            Affirmspace
                                        </span>

                                    </td>

                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- BANNER -->
                    <tr>
                        <td style="
        background:#ffffff;
        padding:30px 20px 25px;
    ">

                            <img src="https://affirmspace.com/public/images/admin_mail_baner.png" width="100%"
                                style="
                display:block;
                width:100%;
                max-width:100%;
                margin:auto;
                border-radius:28px;
                border:0;
            ">

                        </td>
                    </tr>


                    <!-- CONTENT -->
                    <tr>
                        <td style="padding:35px 25px 20px;">

                            <p
                                style="
                                margin:0 0 18px;
                                font-size:16px;
                                color:#4b5563;
                                line-height:1.8;
                            ">
                                Hello
                                <strong style="color:#111827;">
                                    {{ $userName }}
                                </strong>
                            </p>

                            <!-- MESSAGE BOX -->
                            <div
                                style="
                                background:#faf7ff;
                                border:1px solid #eadcf7;
                                border-left:5px solid #d946ef;
                                border-radius:14px;
                                padding:22px;
                                font-size:15px;
                                line-height:1.9;
                                color:#374151;
                                margin-bottom:28px;
                            ">
                                {!! nl2br(e($messageText)) !!}
                            </div>

                            <p
                                style="
                                margin:0 0 18px;
                                color:#6b7280;
                                font-size:15px;
                                line-height:1.8;
                            ">
                                If you have any questions or need assistance,
                                our support team is always here to help you.
                            </p>

                            <!-- CTA BUTTON -->
                            <table cellpadding="0" cellspacing="0" border="0" style="margin:30px 0;">
                                <tr>
                                    <td align="center"
                                        style="
                                            background:linear-gradient(135deg,#ec4899,#c026d3);
                                            border-radius:10px;
                                        ">

                                        <a href="https://affirmspace.com"
                                            style="
                                                display:inline-block;
                                                padding:15px 30px;
                                                color:#ffffff;
                                                text-decoration:none;
                                                font-size:15px;
                                                font-weight:bold;
                                            ">
                                            Visit AffirmSpace
                                        </a>

                                    </td>
                                </tr>
                            </table>

                            <p
                                style="
                                margin-top:35px;
                                color:#111827;
                                font-size:15px;
                                line-height:1.8;
                            ">
                                Warm regards,<br>
                                <strong>
                                    AffirmSpace Team
                                </strong>
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td
                            style="
                            background:linear-gradient(135deg,#f5c9dc,#efb5d2);
                            padding:35px 25px;
                        ">

                            <!-- BRAND -->
                            <p
                                style="
                                margin:0;
                                font-size:24px;
                                font-weight:bold;
                                color:#111827;
                            ">
                                AffirmSpace
                            </p>

                            <!-- TAGLINE -->
                            <p
                                style="
                                margin:10px 0 25px;
                                color:#4b5563;
                                font-size:15px;
                                line-height:1.8;
                            ">
                                Creating a safe, supportive, and inclusive
                                space for every identity.
                            </p>

                            <!-- ADDRESS -->
                            <p
                                style="
                                margin:0 0 25px;
                                color:#374151;
                                font-size:14px;
                                line-height:1.8;
                            ">
                                Randhawa road, Kharar<br>
                                India
                            </p>

                            <!-- APP SECTION -->
                            <p
                                style="
                                margin:0 0 18px;
                                font-size:18px;
                                font-weight:bold;
                                color:#111827;
                            ">
                                Download our mobile app
                            </p>

                            <!-- STORE BUTTONS -->
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tr>

                                    {{-- <td style="padding-right:14px;">

                                        <a href="#">
                                            <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                                                width="160" style="display:block;border:0;">
                                        </a>

                                    </td> --}}

                                    <td>

                                        <a href="https://play.google.com/store/apps/details?id=com.affirmspace.app">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                                                width="180" style="display:block;border:0;">
                                        </a>

                                    </td>

                                </tr>
                            </table>

                            <!-- DIVIDER -->
                            <div
                                style="
                                border-top:1px solid rgba(255,255,255,0.5);
                                margin:35px 0 25px;
                            ">
                            </div>

                            <!-- BOTTOM -->
                            <table width="100%" cellpadding="0" cellspacing="0">

                                <tr>

                                    <!-- LEFT -->
                                    <td align="left"
                                        style="
                                            color:#4b5563;
                                            font-size:13px;
                                            line-height:1.7;
                                        ">

                                        © {{ date('Y') }} AffirmSpace.<br>
                                        All rights reserved.

                                    </td>

                                    <!-- RIGHT -->
                                    <td align="right">

                                        <a href="https://www.facebook.com/profile.php?id=61578529115376" style="text-decoration:none;margin-left:8px;">

                                            <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png"
                                                width="38" style="border-radius:8px;">

                                        </a>

                                        <a href="https://x.com/affirm_space" style="text-decoration:none;margin-left:8px;">

                                            <img src="https://cdn-icons-png.flaticon.com/512/5968/5968830.png"
                                                width="38" style="border-radius:8px;">

                                        </a>

                                        <a href="https://www.instagram.com/affirmspaceofficial/" style="text-decoration:none;margin-left:8px;">

                                            <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png"
                                                width="38" style="border-radius:8px;">

                                        </a>

                                    </td>

                                </tr>

                            </table>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>

    </table>

</body>

</html>
