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
            @foreach ($users as $user)
                <tr>
                    <td></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><a href="/admin/attendance/staff/{{ $user->id }}">詳細</a></td>
                    <td></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection