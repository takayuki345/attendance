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
                <td colspan="3">{{ $attendanceRequest->attendance->user->name }}</td>
            </tr>
            <tr>
                <th>日付</th>
                <td>{{ substr($attendanceRequest->attendance->date, 0, 4) }}年</td>
                <td></td>
                <td>{{ ltrim(substr($attendanceRequest->attendance->date, 5, 2), "0") }}月{{ ltrim(substr($attendanceRequest->attendance->date, 8, 2), "0") }}日</td>
            </tr>
            <tr>
                <th>出勤・退勤</th>
                <td>{{ Carbon::parse($attendanceRequest->start)->format('H:i') }}</td>
                <td>～</td>
                <td>{{ isset($attendanceRequest->end) ? Carbon::parse($attendanceRequest->end)->format('H:i') : '' }}</td>
            </tr>
            @php
                $cnt = 0;
            @endphp
            @foreach ($attendanceRequest->attendance_request_breaks as $attendanceRequestBreak)
                @php
                    $cnt++;
                @endphp
                <tr>
                    <th>休憩 {{ $cnt == 1 ? '' : $cnt }}</th>
                    <td>{{ Carbon::parse($attendanceRequestBreak->break_start)->format('H:i') }}</td>
                    <td>～</td>
                    <td>{{ isset($attendanceRequestBreak->break_end) ? Carbon::parse($attendanceRequestBreak->break_end)->format('H:i') : '' }}</td>
                </tr>
            @endforeach
            <tr>
                <th>備考</th>
                <td colspan="3">{{ $attendanceRequest->note }}</td>
            </tr>
        </table>
        @if (Auth::guard('admin')->check())
            @if ($attendanceRequest->request_status_id == 2)
                <form class="attendance-detail__form" action="/stamp_correction_request/approve/{{ $attendanceRequest->id }}" method="post">
                    @csrf
                    <button type="submit">承認</button>
                </form>
            @elseif ($attendanceRequest->request_status_id == 3)
                <form class="attendance-detail__form" action="" method="">
                    <button type="submit" disabled>承認済み</button>
                </form>
            @endif
        @endif
        @if (Auth::guard('web')->check())
            @if ($attendanceRequest->request_status_id == 2)
            <div class="message">*承認待ちのため修正はできません。</div>
            @endif
        @endif
    </div>
</div>
@endsection