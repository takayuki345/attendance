@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-staff-list.css') }}">
@endsection

@section('content')
<div class="attendance-staff-list__wrapper">
    <h2 class="attendance-staff-list__title">{{ substr($dateSet['target'], 0, 4) }}年{{ ltrim(substr($dateSet['target'], 5, 2), '0') }}月{{ ltrim(substr($dateSet['target'], 8, 2), '0') }}日の勤怠</h2>
    <div class="attendance-staff-list__working-day">
        <div class="working-day-yesterday"><a href="/admin/attendance/list?date={{ $dateSet['before'] }}"><span>前日</span></a></div>
        <div class="working-day-today"><span>{{ substr($dateSet['target'], 0, 4) }}/{{ substr($dateSet['target'], 5, 2) }}/{{ substr($dateSet['target'], 8, 2) }}</span></div>
        <div class="working-day-tomorrow"><a href="/admin/attendance/list?date={{ $dateSet['after'] }}"><span>翌日</span></a></div>
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
            @foreach ($timeRecords as $timeRecord)
                <tr>
                    <td>{{ $timeRecord['userName'] }}</td>
                    <td></td>
                    <td>{{ $timeRecord['start'] }}</td>
                    <td>{{ $timeRecord['end'] }}</td>
                    <td>{{ $timeRecord['break'] }}</td>
                    <td>{{ $timeRecord['total'] }}</td>
                    <td>@if($timeRecord['id'] != '') <a href="/attendance/{{ $timeRecord['id'] }}">詳細</a> @endif</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection