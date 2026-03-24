<div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background:#f4f6f8; padding:40px;">

    <div
        style="max-width:600px; margin:auto; background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e5e5e5;">

        <!-- HEADER -->
        <div style="text-align:center; padding:20px; background:#f9fafb;">
            <img src="{{ config('app.logo') }}" width="140">
        </div>

        <!-- CONTENT -->
        <div style="padding:25px; color:#333; line-height:1.6;">

            <h2 style="color: #dc3545; text-align: center; margin-bottom: 20px;">
                ❌ Verification Rejected
            </h2>

            <p style="font-size: 16px;">
                Hi <strong>{{ $user->first_name }}</strong>,
            </p>

            <p style="font-size: 16px;">
                We reviewed your profile photos and, unfortunately, your verification was
                <strong style="color: #dc3545;">not approved</strong>.
            </p>

            @if (!empty($reason))
                <p style="font-size: 16px;"><strong>Reason:</strong></p>
                <blockquote
                    style="color:#b33; border-left: 4px solid #b33; padding-left: 12px; margin: 10px 0; font-style: italic;">
                    {{ $reason }}
                </blockquote>
            @else
                <p style="font-size: 16px;">
                    Please re-upload clearer or correct photos and try again.
                </p>
            @endif

        </div>

        <!-- 🔻 FOOTER -->
        <div style="text-align:center; padding:15px; font-size:12px; color:#999; background:#f9fafb;">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

    </div>

</div>
