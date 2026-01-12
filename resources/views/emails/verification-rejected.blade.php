<div
    style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #e5e5e5; border-radius: 12px; background-color: #fafafa;">
    <h2 style="color: #dc3545; text-align: center; margin-bottom: 20px;">❌ Verification Rejected</h2>

    <p style="font-size: 16px;">Hi <strong>{{ $user->first_name }}</strong>,</p>

    <p style="font-size: 16px;">
        We reviewed your profile photos and, unfortunately, your verification was <strong style="color: #dc3545;">not
            approved</strong>.
    </p>

    @if (!empty($reason))
        <p style="font-size: 16px;"><strong>Reason:</strong></p>
        <blockquote
            style="color:#b33; border-left: 4px solid #b33; padding-left: 12px; margin: 10px 0; font-style: italic;">
            {{ $reason }}
        </blockquote>
    @else
        <p style="font-size: 16px;">Please re-upload clearer or correct photos and try again.</p>
    @endif
</div>
