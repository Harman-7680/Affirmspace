<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Document Status Update</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f6f6f6; padding:30px;">

    <div style="max-width:600px;margin:auto;background:white;padding:25px;border-radius:6px">

        <h2 style="margin-top:0;">Hello {{ $user->first_name ?? 'User' }},</h2>

        @if ($status == 3)
            <p style="font-size:16px;">
                🎉 <strong>Congratulations!</strong>
            </p>

            <p>
                Your counselor documents have been <strong style="color:green;">approved</strong> by our admin team.
            </p>

            <p>
                You can now start using counselor features on the platform.
            </p>
        @elseif($status == 2)
            <p style="font-size:16px;">
                ⚠️ <strong>Document Verification Failed</strong>
            </p>

            <p>
                Unfortunately your submitted counselor documents have been
                <strong style="color:red;">rejected</strong>.
            </p>

            <p>
                Please upload valid documents again from your dashboard.
            </p>
        @endif


        <hr style="margin:25px 0">

        <p style="font-size:14px;color:#666;">
            If you have any questions, please contact our support team.
        </p>

        <p style="margin-top:20px;">
            Regards,<br>
            <strong>Admin Team</strong>
        </p>

    </div>

</body>

</html>
