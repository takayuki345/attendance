@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__wrapper">
    @if (Request::is('admin/login'))
        <h2 class="login__title">管理者ログイン</h2>
    @elseif (Request::is('login'))
        <h2 class="login__title">ログイン</h2>
    @endif
    <div class="login__container">
        @if (Request::is('admin/login'))
            <form class="login__form" action="/admin/login" method="post">
        @elseif (Request::is('login'))
            <form class="login__form" action="/login" method="post">
        @endif
            @csrf
            <div class="form-group">
                <label>メールアドレス</label>
                <input type="text" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password" value="{{ old('password') }}">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                    @if (Request::is('admin/login'))
                        <button type="submit">管理者ログインする</button>
                    @elseif (Request::is('login'))
                        <button type="submit">ログインする</button>
                    @endif
            </div>
        </form>
        @if (Request::is('login'))
            <div class="login__link">
                <a href="/register">会員登録はこちら</a>
            </div>
        @endif
    </div>
</div>
@endsection