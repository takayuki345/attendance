@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__wrapper">
    <h2 class="register__title">会員登録</h2>
    <div class="register__container">
        <form class="register__form" action="" method="">
            <div class="form-group">
                <label>名前</label>
                <input type="text" name="name">
            </div>
            <div class="form-group">
                <label>メールアドレス</label>
                <input type="text" name="email">
            </div>
            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password">
            </div>
            <div class="form-group">
                <label>パスワード確認</label>
                <input type="password" name="password">
            </div>
            <div class="form-group">
                <button type="submit">登録する</button>
            </div>
        </form>
        <div class="register__link">
            <a href="">ログインはこちら</a>
        </div>
    </div>
</div>
@endsection