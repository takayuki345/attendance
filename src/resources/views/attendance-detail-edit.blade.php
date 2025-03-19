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
                    <td class="table__td-start"><input type="text" name="start" value="{{ old('start', Carbon::parse($attendance->start)->format('H:i')) }}"></td>
                    <td class="table__td-to">～</td>
                    <td class="table__td-end"><input  type="text" name="end" value="{{ old('end', isset($attendance->end) ? Carbon::parse($attendance->end)->format('H:i') : '') }}"></td>
                    <td></td>
                </tr>
                @if ($errors->has('start') || $errors->has('end'))
                    <tr class="error_tr">
                        <td></td>
                        <td colspan="4">
                            @if ($errors->has('start'))
                                <div class="error">{{ $message }}</div>
                            @elseif ($errors->has('end'))
                                <div class="error">{{ $message }}</div>
                            @endif
                        </td>
                    </tr>
                @endif
                @php
                    $cnt = 0;
                @endphp
                @foreach ($attendance->attendance_breaks as $attendanceBreak)
                    @php
                        $cnt++;
                        $idx = $cnt - 1;
                    @endphp
                    <tr>
                        <th>休憩 {{ $cnt == 1 ? '' : $cnt }}</th>
                        <td class="table__td-break-start"><input type="text" name="break_start[]" value="{{ old('break_start.' . ($cnt - 1), Carbon::parse($attendanceBreak->break_start)->format('H:i')) }}"></td>
                        <td class="table__td-to">～</td>
                        <td class="table__td-break-end"><input type="text" name="break_end[]" value="{{ old('break_end.' . ($cnt - 1), isset($attendanceBreak->break_end) ? Carbon::parse($attendanceBreak->break_end)->format('H:i') : '') }}"></td>
                        <td><input type="hidden" name="id[]" value="{{ $attendanceBreak->id }}"></td>
                    </tr>
                    @if ($errors->has('break_start.' . $idx) || $errors->has('break_end.' . $idx))
                        <tr class="error_tr">
                            <td></td>
                            <td colspan="4">
                                @if ($errors->has('break_start.' . $idx))
                                    <div class="error">{{ $message }}</div>
                                @elseif ($errors->has('break_end.' . $idx))
                                    <div class="error">{{ $message }}</div>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
                @php
                    $cnt++;
                @endphp
                <tr>
                    <th>休憩 {{ $cnt == 1 ? '' : $cnt }}</th>
                    <td class="table__td-break-start"><input type="text" name="break_start_add" value="{{ old('break_start_add') }}"></td>
                    <td class="table__td-to">～</td>
                    <td class="table__td-break-end"><input type="text" name="break_end_add" value="{{ old('break_end_add') }}"></td>
                    <td></td>
                </tr>
                @if ($errors->has('break_start_add') || $errors->has('break_end_add'))
                    <tr class="error_tr">
                        <td></td>
                        <td colspan="4">
                            @if ($errors->has('break_start_add'))
                                <div class="error">{{ $message }}</div>
                            @elseif ('break_end_add')
                                <div class="error">{{ $message }}</div>
                            @endif
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>備考</th>
                    <td class="table__td-note" colspan="3"><textarea name="note">{{ old('note', $attendance->note) }}</textarea></td>
                    <td></td>
                </tr>
                @if ($errors->has('note'))
                    <tr class="error_tr">
                        <td></td>
                        <td colspan="4">
                            @error('note')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                @endif
            </table>
            <div class="form__button" >
                <button type="submit">修正</button>
            </div>
        </form>
    </div>
</div>
@endsection