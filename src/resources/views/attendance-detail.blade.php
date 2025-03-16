@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-detail.css') }}">
@endsection

@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="attendance-detail__wrapper">
    <h2 class="attendance-detail__title">勤怠詳細</h2>
    <div class="attendance-detail__container">
        <table class="attendance-detail__table">
            <tr>
                <th>名前</th>
                <td colspan="3">{{ $attendance_request->attendance->user->name }}</td>
            </tr>
            <tr>
                <th>日付</th>
                <td>{{ substr($attendance_request->attendance->date, 0, 4) }}年</td>
                <td></td>
                <td>{{ ltrim(substr($attendance_request->attendance->date, 5, 2), "0") }}月{{ ltrim(substr($attendance_request->attendance->date, 8, 2), "0") }}日</td>
            </tr>
            <tr>
                <th>出勤・退勤</th>
                <td>{{ Carbon::parse($attendance_request->start)->format('H:i') }}</td>
                <td>～</td>
                <td>{{ isset($attendance_request->end) ? Carbon::parse($attendance_request->end)->format('H:i') : '' }}</td>
            </tr>
            @php
                $cnt = 0;
            @endphp
            @foreach ($attendance_request->attendance_request_breaks as $attendance_request_break)
                @php
                    $cnt++;
                @endphp
                <tr>
                    <th>休憩 {{ $cnt == 1 ? '' : $cnt }}</th>
                    <td>{{ Carbon::parse($attendance_request_break->break_start)->format('H:i') }}</td>
                    <td>～</td>
                    <td>{{ isset($attendance_request_break->break_start) ? Carbon::parse($attendance_request_break->break_start)->format('H:i') : '' }}</td>
                </tr>
            @endforeach
            <tr>
                <th>備考</th>
                <td colspan="3">{{ $attendance_request->note }}</td>
            </tr>
        </table>
        @if (Auth::guard('admin')->check())
            <form class="attendance-detail__form" action="" method="">
                <button type="submit">承認</button>
            </form>
        @endif
        @if (Auth::guard('web')->check())
            <div class="message">*承認待ちのため修正はできません。</div>
        @endif
    </div>
</div>
@endsection