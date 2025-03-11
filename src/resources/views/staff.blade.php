@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/staff.css') }}">
@endsection

@section('content')
<div class="staff__wrapper">
    <h2 class="staff__title">スタッフ一覧</h2>
    <div class="staff__container">
        <table class="staff__table">
            <tr>
                <th></th>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>月次勤怠</th>
                <th></th>
            </tr>
            <tr>
                <td></td>
                <td>西　伶奈</td>
                <td>reina.n@coachtech.com</td>
                <td><a href="">詳細</a></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>西　伶奈</td>
                <td>reina.n@coachtech.com</td>
                <td><a href="">詳細</a></td>
                <td></td>
            </tr>
        </table>
    </div>
</div>
@endsection