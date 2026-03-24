<div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#f4f6f8; padding:40px;">

    <div
        style="max-width:600px; margin:auto; background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e5e5e5;">

        <!-- HEADER -->
        <div style="text-align:center; padding:20px; background:#f9fafb;">
            <img src="{{ config('app.logo') }}" width="140">
        </div>

        <!-- CONTENT -->
        <div style="padding:25px; color:#333; line-height:1.6;">

            <h2 style="color: #28a745; text-align: center; margin-bottom: 20px;">
                🎉 Your Profile is Approved!
            </h2>

            <p style="font-size: 16px;">
                Hello <strong>{{ $user->first_name }}</strong>,
            </p>

            <p style="font-size: 16px;">
                Your dating profile verification is
                <strong style="color: #28a745;">complete</strong>.
                You can now access the dating page and start connecting!
            </p>

            <p style="font-size: 16px;">
                Thank you for being part of our community!
            </p>

        </div>

        <!-- 🔻 FOOTER -->
        <div style="text-align:center; padding:15px; font-size:12px; color:#999; background:#f9fafb;">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

    </div>

</div>
