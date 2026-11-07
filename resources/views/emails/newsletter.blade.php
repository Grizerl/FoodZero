@extends('emails.layout')

@section('unsubscribe', $unsubscribeUrl)

@section('content')
    {!! nl2br(e($body)) !!}
@endsection
