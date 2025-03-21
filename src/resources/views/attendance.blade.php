@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="attendance__wrapper">
        <div class="attendance-status"><span>{{ $attendanceStatus }}</span></div>
        <div class="attendance-date">{{ $date }}</div>
        <div class="attendance-time">{{ $time }}</div>
        <form class="attendance__form" action="/attendance" method="post">
            <div class="form-group">
                @csrf
                @if ($attendanceStatus == '勤務外')
                    <button class="button-work" type="submit" name="action" value="start">出勤</button>
                @elseif ($attendanceStatus == '出勤中')
                    <button class="button-work" type="submit" name="action" value="end">退勤</button>
                    <button class="button-break" type="submit" name="action" value="break_start">休憩入</button>
                @elseif ($attendanceStatus == '休憩中')
                    <button class="button-break" type="submit" name="action" value="break_end">休憩戻</button>
                @elseif ($attendanceStatus == '退勤済')
                    <div class="message">お疲れ様でした。</div>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection