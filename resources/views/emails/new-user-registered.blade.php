<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>New User Registered</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">

    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 10px; overflow: hidden;">

        <!-- HEADER -->
        <div style="text-align: center; padding: 20px; background: #f9fafb;">
            <img src="{{ config('app.logo') }}" width="140">
        </div>

        <!-- CONTENT -->
        <div style="padding: 25px; color: #333; line-height: 1.6;">

            <h2 style="color: #198754;">New User Registered</h2>

            <p>
                A new user has successfully registered on
                <strong>{{ config('app.name') }}</strong>.
            </p>

            <p style="margin-top: 25px;">
                <strong>Registration Details:</strong>
            </p>

            <table cellpadding="10" cellspacing="0" width="100%"
                style="border-collapse: collapse; border: 1px solid #ddd;">

                <tr>
                    <td style="border: 1px solid #ddd; background: #f9fafb;">
                        <strong>First Name</strong>
                    </td>
                    <td style="border: 1px solid #ddd;">
                        {{ $user->first_name }}
                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #ddd; background: #f9fafb;">
                        <strong>Last Name</strong>
                    </td>
                    <td style="border: 1px solid #ddd;">
                        {{ $user->last_name }}
                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #ddd; background: #f9fafb;">
                        <strong>Email</strong>
                    </td>
                    <td style="border: 1px solid #ddd;">
                        {{ $user->email }}
                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #ddd; background: #f9fafb;">
                        <strong>Gender</strong>
                    </td>
                    <td style="border: 1px solid #ddd;">
                        {{ $user->gender ?? 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #ddd; background: #f9fafb;">
                        <strong>Role</strong>
                    </td>
                    <td style="border: 1px solid #ddd;">
                        {{ $user->role == 1 ? 'Counselor' : 'User' }}
                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #ddd; background: #f9fafb;">
                        <strong>Address</strong>
                    </td>
                    <td style="border: 1px solid #ddd;">
                        {{ $user->address ?? 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #ddd; background: #f9fafb;">
                        <strong>Specialization</strong>
                    </td>
                    <td style="border: 1px solid #ddd;">
                        {{ $user->specialization_id ?? 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #ddd; background: #f9fafb;">
                        <strong>Referral Code</strong>
                    </td>
                    <td style="border: 1px solid #ddd;">
                        {{ $user->refer_code }}
                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #ddd; background: #f9fafb;">
                        <strong>Referred By</strong>
                    </td>
                    <td style="border: 1px solid #ddd;">
                        {{ $user->referred_by ?? 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <td style="border: 1px solid #ddd; background: #f9fafb;">
                        <strong>Status</strong>
                    </td>
                    <td style="border: 1px solid #ddd;">
                        {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                    </td>
                </tr>

            </table>

            <p style="margin-top: 30px;">
                A new account has been created successfully. You can review the
                user's details from the admin panel.
            </p>

            <p style="margin-top: 30px;">
                Warm regards,<br>
                <strong>{{ config('app.name') }} Team</strong>
            </p>

        </div>

        <!-- FOOTER -->
        <div style="text-align: center; padding: 15px; font-size: 12px; color: #999; background: #f9fafb;">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

    </div>

</body>

</html>
