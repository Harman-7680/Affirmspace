<div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#f4f6f8; padding:40px;">

    <div
        style="max-width:600px; margin:auto; background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e5e5e5;">

        <!-- HEADER -->
        <div style="text-align:center; padding:20px; background:#f9fafb;">
            <img src="{{ config('app.logo') }}" width="140">
        </div>

        <!-- 📩 CONTENT -->
        <div style="padding:25px; color:#333; line-height:1.6;">

            <h2 style="color: #ff4d6d; text-align: center; margin-bottom: 20px;">
                Profile for Verification received
            </h2>

            <p style="font-size: 16px;">
                Hello <strong>{{ $user->name }}</strong>,
            </p>

            <p style="font-size: 16px;">
                Your profile photos have been submitted
                <strong style="color: #ff4d6d;">successfully</strong>.
            </p>

            <p style="font-size: 16px;">
                We are currently reviewing them. You will receive an update soon.
            </p>

            <p style="font-size: 16px;">
                Thank you for being a valued member!
            </p>

        </div>

        <!-- 🔻 FOOTER -->
        <div style="text-align:center; padding:15px; font-size:12px; color:#999; background:#f9fafb;">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

    </div>

</div>
