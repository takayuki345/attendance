@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-list.css') }}">
@endsection

@section('content')
<div class="attendance-list__wrapper">
    @if (Auth::guard('admin')->check())
        <h2 class="attendance-list__title">{{ $userName }}さんの勤怠</h2>
    @elseif (Auth::guard('web')->check())
        <h2 class="attendance-list__title">勤怠一覧</h2>
    @endif
    <div class="attendance-list__working-month">
        <div class="working-month-last">
            @if (Auth::guard('admin')->check())
                <a href="/admin/attendance/staff/{{ $userId }}?year={{ $targets['beforeYear'] }}&month={{ $targets['beforeMonth'] }}">
            @elseif (Auth::guard('web')->check())
                <a href="/attendance/list?year={{ $targets['beforeYear'] }}&month={{ $targets['beforeMonth'] }}">
            @endif
                <span>前月</span>
            </a>
        </div>
        <div class="working-month-current"><span>{{ $targets['year'] }}/{{ sprintf('%02d', $targets['month']) }}</span></div>
        <div class="working-month-next">
            @if (Auth::guard('admin')->check())
                <a href="/admin/attendance/staff/{{ $userId }}?year={{ $targets['afterYear'] }}&month={{ $targets['afterMonth'] }}">
            @elseif (Auth::guard('web')->check())
                <a href="/attendance/list?year={{ $targets['afterYear'] }}&month={{ $targets['afterMonth'] }}">
            @endif
                <span>翌月</span>
            </a>
        </div>
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
            @foreach ($timeRecords as $timeRecord)
            <tr>
                <td>{{ $timeRecord['date'] }}</td>
                <td>{{ $timeRecord['start'] }}</td>
                <td>{{ $timeRecord['end'] }}</td>
                <td>{{ $timeRecord['break'] }}</td>
                <td>{{ $timeRecord['total'] }}</td>
                <td>@if($timeRecord['id'])<a href="/attendance/{{ $timeRecord['id'] }}">詳細</a>@endif</td>
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