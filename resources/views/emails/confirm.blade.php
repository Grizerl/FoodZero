@extends('emails.layout')

@section('content')
    <p>Thanks for subscribing! Please confirm your email address to start receiving our recipes and news.</p>
    <p><a href="{{ $confirmUrl }}" style="display:inline-block;padding:12px 24px;background:#a7d129;color:#1a2400;text-decoration:none;border-radius:999px;font-weight:bold;">Confirm subscription</a></p>
    <p style="font-size:13px;color:#555;">The link is valid for {{ \App\Models\Subscriber::CONFIRM_LINK_DAYS }} days.</p>
@endsection
