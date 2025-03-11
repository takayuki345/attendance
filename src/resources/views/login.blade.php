@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__wrapper">
    <h2 class="login__title">管理者ログイン</h2>
    <div class="login__container">
        <form class="login__form" action="" method="">
            <div class="form-group">
                <label>メールアドレス</label>
                <input type="text" name="email">
            </div>
            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password">
            </div>
            <div class="form-group">
                <button type="submit">管理者ログインする</button>
            </div>
        </form>
        <div class="login__link">
            <a href="">会員登録はこちら</a>
        </div>
    </div>
</div>
@endsection