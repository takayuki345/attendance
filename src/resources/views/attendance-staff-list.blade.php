@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-staff-list.css') }}">
@endsection

@section('content')
<div class="attendance-staff-list__wrapper">
    <h2 class="attendance-staff-list__title">2023年6月1日の勤怠</h2>
    <div class="attendance-staff-list__working-day">
        <div class="working-day-yesterday"><a href=""><span>前日</span></a></div>
        <div class="working-day-today"><span>2023/06/01</span></div>
        <div class="working-day-tomorrow"><a href=""><span>翌日</span></a></div>
    </div>
    <div class="attendance-staff-list__container">
        <table class="attendance-staff-list__table">
            <tr>
                <th>名前</th>
                <th></th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
            <tr>
                <td>西　伶奈</td>
                <td></td>
                <td>09:00</td>
                <td>18:00</td>
                <td>1:00</td>
                <td>8:00</td>
                <td><a href="">詳細</a></td>
            </tr>
            <tr>
                <td>西　伶奈</td>
                <td></td>
                <td>09:00</td>
                <td>18:00</td>
                <td>1:00</td>
                <td>8:00</td>
                <td><a href="">詳細</a></td>
            </tr>
        </table>
    </div>
</div>
@endsection