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
                <td colspan="3">{{ $attendance->user->name }}</td>
            </tr>
            <tr>
                <th>日付</th>
                <td>{{ substr($attendance->date, 0, 4) }}年</td>
                <td></td>
                <td>{{ ltrim(substr($attendance->date, 5, 2), "0") }}月{{ ltrim(substr($attendance->date, 8, 2), "0") }}日</td>
            </tr>
            <tr>
                <th>出勤・退勤</th>
                <td>{{ Carbon::parse($attendance->start)->format('H:i') }}</td>
                <td>～</td>
                <td>{{ isset($attendance->end) ? Carbon::parse($attendance->end)->format('H:i') : '' }}</td>
            </tr>
            @php
                $cnt = 0;
            @endphp
            @foreach ($attendance->attendance_breaks as $attendanceBreak)
                @php
                    $cnt++;
                @endphp
                <tr>
                    <th>休憩 {{ $cnt == 1 ? '' : $cnt }}</th>
                    <td>{{ Carbon::parse($attendanceBreak->break_start)->format('H:i') }}</td>
                    <td>～</td>
                    <td>{{ isset($attendanceBreak->break_end) ? Carbon::parse($attendanceBreak->break_end)->format('H:i') : '' }}</td>
                </tr>
            @endforeach
            <tr>
                <th>備考</th>
                <td colspan="3">{{ $attendance->note }}</td>
            </tr>
        </table>
        <div class="message">*当日の勤怠データのため修正はできません。</div>
    </div>
</div>
@endsection