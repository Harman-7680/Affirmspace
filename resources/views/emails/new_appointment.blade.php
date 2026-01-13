<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>New Appointment Request</title>
</head>

<body style="background:#f4f6f8;padding:20px;font-family:Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" style="background:#ffffff;border-radius:8px;padding:20px;">

                    <tr>
                        <td align="center" style="padding-bottom:20px;">
                            <h2 style="color:#2563eb;margin:0;">📅 New Appointment Request</h2>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>Hello <strong>{{ $counselor->first_name }}</strong>,</p>

                            <p>You have received a new appointment request. Below are the details:</p>

                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="background:#f9fafb;border-radius:6px;">
                                <tr>
                                    <td><strong>From:</strong></td>
                                    <td>{{ $sender->first_name }} ({{ $sender->email }})</td>
                                </tr>

                                <tr>
                                    <td><strong>Subject:</strong></td>
                                    <td>{{ $subject }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Message:</strong></td>
                                    <td>{{ $messageBody }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Appointment Time:</strong></td>
                                    <td>
                                        {{ $availability->date }} <br>
                                        {{ $availability->start_time }} – {{ $availability->end_time }}
                                    </td>
                                </tr>
                            </table>

                            <p style="margin-top:20px;">
                                Please login to your account to approve or reject this appointment.
                            </p>

                            <p style="margin-top:30px;">
                                Regards,<br>
                                <strong>AffirmSpace</strong>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
