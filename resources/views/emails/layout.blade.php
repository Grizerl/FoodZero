<!doctype html>
<html lang="en">
<body style="margin:0;padding:24px;background:#f4f4f0;font-family:Arial,Helvetica,sans-serif;color:#222;">
    <div style="max-width:560px;margin:0 auto;background:#fff;padding:32px;border-radius:8px;line-height:1.6;">
        <h1 style="margin:0 0 16px;font-size:22px;">Food Zero</h1>
        @yield('content')
        <hr style="border:none;border-top:1px solid #e5e5e0;margin:28px 0 16px;">
        <p style="font-size:12px;color:#777;margin:0;">
            You are receiving this email because this address was subscribed to the Food Zero newsletter on our website.
            @hasSection('unsubscribe')
                <a href="@yield('unsubscribe')">Unsubscribe</a>.
            @else
                If it was not you, simply ignore this message and nothing will happen.
            @endif
        </p>
    </div>
</body>
</html>
