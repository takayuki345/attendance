@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-list.css') }}">
@endsection

@section('content')
<div class="attendance-list__wrapper">
    @if (Auth::guard('admin')->check())
        <h2 class="attendance-list__title">西伶奈さんの勤怠</h2>
    @elseif (Auth::guard('web')->check())
        <h2 class="attendance-list__title">勤怠一覧</h2>
    @endif
    <div class="attendance-list__working-month">
        <div class="working-month-last"><a href=""><span>前月</span></a></div>
        <div class="working-month-current"><span>2023/06</span></div>
        <div class="working-month-next"><a href=""><span>翌月</span></a></div>
    </div>
    <div class="attendance-list__container">
        <table class="attendance-list__table">
            <tr>
                <th>日付</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
            <tr>
                <td>06/01(木)</td>
                <td>09:00</td>
                <td>18:00</td>
                <td>1:00</td>
                <td>8:00</td>
                <td><a href="/attendance/1">詳細</a></td>
            </tr>
            <tr>
                <td>06/02(金)</td>
                <td>09:00</td>
                <td>18:00</td>
                <td>1:00</td>
                <td>8:00</td>
                <td><a href="/attendance/1">詳細</a></td>
            </tr>
            <tr>
                <td>06/03(土)</td>
                <td>09:00</td>
                <td>18:00</td>
                <td>1:00</td>
                <td>8:00</td>
                <td><a href="/attendance/2">詳細</a></td>
            </tr>
        </table>
    </div>
    @if (Auth::guard('admin')->check())
        <div class="attendance-list__csv">
            <button>CSV出力</button>
        </div>
    @endif
</div>
@endsection