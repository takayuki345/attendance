@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="attendance__wrapper">
        <div class="attendance-status"><span>勤務外</span></div>
        <div class="attendance-date">2023年6月1日(木)</div>
        <div class="attendance-time">08:00</div>
        <form class="attendance__form" action="" method="">
            <div class="form-group">
                <!-- <button class="button-work" type="submit">出勤</button> -->
                <button class="button-work" type="submit">退勤</button>
                <button class="button-break" type="submit">休憩入</button>
                <!-- <button class="button-break" type="submit">休憩戻</button>
                <div class="message">　お疲れ様でした。</div> -->
            </div>
        </form>
    </div>
</div>
@endsection