@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stamp-request.css') }}">
@endsection

@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="stamp-request__wrapper">
    <h2 class="stamp-request__title">申請一覧</h2>
    <div class="stamp-request__tab">
        <div class="stamp-request__tab-before"><a class="{{ $request_status_id == 2 ? 'tab--selected' : '' }}" href="/stamp_correction_request/list?status=2">承認待ち</a></div>
        <div class="stamp-request__tab-after"><a class="{{ $request_status_id == 3 ? 'tab--selected' : '' }}" href="/stamp_correction_request/list?status=3">承認済み</a></div>
    </div>
    <div class="stamp-request__container">
        <table class="stamp-request__table">
            <tr>
                <th>状態</th>
                <th>名前</th>
                <th>対象日時</th>
                <th>申請理由</th>
                <th>申請日時</th>
                <th>詳細</th>
            </tr>
            @foreach ($attendance_requests as $attendance_request)
                <tr>
                    <td>{{ $attendance_request->request_status->name }}</td>
                    <td>{{ $attendance_request->attendance->user->name }}</td>
                    <td>{{ str_replace('-', '/', $attendance_request->attendance->date) }}</td>
                    <td>{{ $attendance_request->note }}</td>
                    <td>{{ Carbon::parse($attendance_request->request_time)->format('Y/m/d') }}</td>
                    <td><a href="/attendance/{{ $attendance_request->attendance->id }}">詳細</a></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection