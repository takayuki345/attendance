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
        <div class="working-month-last"><a href="/attendance/list?year={{ $targets['before_year'] }}&month={{ $targets['before_month'] }}"><span>前月</span></a></div>
        <div class="working-month-current"><span>{{ $targets['year'] }}/{{ sprintf('%02d', $targets['month']) }}</span></div>
        <div class="working-month-next"><a href="/attendance/list?year={{ $targets['after_year'] }}&month={{ $targets['after_month'] }}"><span>翌月</span></a></div>
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
            @foreach ($time_records as $time_record)
            <tr>
                <td>{{ $time_record['date'] }}</td>
                <td>{{ $time_record['start'] }}</td>
                <td>{{ $time_record['end'] }}</td>
                <td>{{ $time_record['break'] }}</td>
                <td>{{ $time_record['total'] }}</td>
                <td>@if($time_record['id'])<a href="/attendance/{{ $time_record['id'] }}">詳細</a>@endif</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="attendance-list__csv">
        @if (Auth::guard('admin')->check())
        <button>CSV出力</button>
        @endif
    </div>
</div>
@endsection