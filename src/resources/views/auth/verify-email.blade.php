@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="verify-email__wrapper">
    <div class="verify-email__message">登録していただいたメールアドレスに認証メールを送信しました。<br>メール認証を完了してください。</div>
    <div class="verify-email__link"><a href="https://mailtrap.io/inboxes">認証はこちらから</a></div>
    <div class="verify-email__resend">
        <form action="/email/verification-notification" method="post">
            @csrf
            <button type="submit">認証メールを再送する</button>
        </form>
    </div>
</div>

@endsection