@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-detail-edit.css') }}">
@endsection

@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="attendance-detail-edit__wrapper">
    <h2 class="attendance-detail-edit__title">勤怠詳細</h2>
    <div class="attendance-detail-edit__container">
        <form class="attendance-detail-edit__form" action="/attendance/{{ $attendance->id }}" method="post">
            @csrf
            <table class="form__table">
                <tr>
                    <th>名前</th>
                    <td class="table__td-name" colspan="3">{{ $attendance->user->name }}</td>
                    <td></td>
                </tr>
                <tr>
                    <th>日付</th>
                    <td class="table__td-year">{{ substr($attendance->date, 0, 4) }}年</td>
                    <td></td>
                    <td class="table__td-date">{{ ltrim(substr($attendance->date, 5, 2), "0") }}月{{ ltrim(substr($attendance->date, 8, 2), "0") }}日</td>
                    <td></td>
                </tr>
                <tr>
                    <th>出勤・退勤</th>
                    <td class="table__td-start"><input type="text" name="start" value="{{ Carbon::parse($attendance->start)->format('H:i') }}"></td>
                    <td class="table__td-to">～</td>
                    <td class="table__td-end"><input  type="text" name="end" value="{{ isset($attendance->end) ? Carbon::parse($attendance->end)->format('H:i') : '' }}"></td>
                    <td></td>
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
                        <td class="table__td-break-start"><input type="text" name="break_start[]" value="{{ Carbon::parse($attendanceBreak->break_start)->format('H:i') }}"></td>
                        <td class="table__td-to">～</td>
                        <td class="table__td-break-end"><input type="text" name="break_end[]" value="{{ isset($attendanceBreak->break_end) ? Carbon::parse($attendanceBreak->break_end)->format('H:i') : '' }}"></td>
                        <td><input type="hidden" name="id[]" value="{{ $attendanceBreak->id }}"></td>
                    </tr>
                @endforeach
                @php
                    $cnt++;
                @endphp
                <tr>
                    <th>休憩 {{ $cnt == 1 ? '' : $cnt }}</th>
                    <td class="table__td-break-start"><input type="text" name="break_start_add"></td>
                    <td class="table__td-to">～</td>
                    <td class="table__td-break-end"><input type="text" name="break_end_add"></td>
                    <td></td>
                </tr>
                <tr>
                    <th>備考</th>
                    <td class="table__td-note" colspan="3"><textarea name="note">{{ $attendance->note }}</textarea></td>
                    <td></td>
                </tr>
            </table>
            <div class="form__button" >
                <button type="submit">修正</button>
            </div>
        </form>
    </div>
</div>
@endsection