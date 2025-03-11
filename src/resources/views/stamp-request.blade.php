@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stamp-request.css') }}">
@endsection

@section('content')
<div class="stamp-request__wrapper">
    <h2 class="stamp-request__title">申請一覧</h2>
    <div class="stamp-request__tab">
        <div class="stamp-request__tab-before"><a class="" href="">承認待ち</a></div>
        <div class="stamp-request__tab-after"><a class="" href="">承認済み</a></div>
    </div>
    <div class="stamp-request__container">
        <table class="stamp-request__table">
            <tr>
                <th>状態</th>
                <th>名前</th>
                <th>対象日時</th>
                <th>申請理由</th>
                <th>申請日時</th>
                <th>詳細</th>
            </tr>
            <tr>
                <td>承認待ち</td>
                <td>西　伶奈</td>
                <td>2023/06/01</td>
                <td>遅延のため</td>
                <td>2023/06/02</td>
                <td><a href="">詳細</a></td>
            </tr>
            <tr>
                <td>承認待ち</td>
                <td>西　伶奈</td>
                <td>2023/06/01</td>
                <td>遅延のため</td>
                <td>2023/06/02</td>
                <td><a href="">詳細</a></td>
            </tr>
        </table>
    </div>
</div>
@endsection