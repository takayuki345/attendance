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
        <div class="stamp-request__tab-before"><a class="{{ $requestStatusId == 2 ? 'tab--selected' : '' }}" href="/stamp_correction_request/list?status=2">承認待ち</a></div>
        <div class="stamp-request__tab-after"><a class="{{ $requestStatusId == 3 ? 'tab--selected' : '' }}" href="/stamp_correction_request/list?status=3">承認済み</a></div>
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
            @foreach ($attendanceRequests as $attendanceRequest)
                <tr>
                    <td>{{ $attendanceRequest->request_status->name }}</td>
                    <td>{{ $attendanceRequest->attendance->user->name }}</td>
                    <td>{{ str_replace('-', '/', $attendanceRequest->attendance->date) }}</td>
                    <td>{{ $attendanceRequest->note }}</td>
                    <td>{{ Carbon::parse($attendanceRequest->request_time)->format('Y/m/d') }}</td>
                    <td>
                        @if (Auth::guard('admin')->check())
                            <a href="/stamp_correction_request/approve/{{ $attendanceRequest->id }}">詳細</a>
                        @else
                            <!-- <a href="/attendance/{{-- $attendanceRequest->attendance->id --}}">詳細</a> -->
                            <a href="/stamp_correction_request/{{ $attendanceRequest->id }}">詳細</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection