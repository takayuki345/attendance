@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-detail.css') }}">
@endsection

@section('content')
<div class="attendance-detail__wrapper">
    <h2 class="attendance-detail__title">勤怠詳細</h2>
    <div class="attendance-detail__container">
        <table class="attendance-detail__table">
            <tr>
                <th>名前</th>
                <td colspan="3">西　伶奈</td>
            </tr>
            <tr>
                <th>日付</th>
                <td>2023年</td>
                <td></td>
                <td>6月1日</td>
            </tr>
            <tr>
                <th>出勤・退勤</th>
                <td>09:00</td>
                <td>～</td>
                <td>18:00</td>
            </tr>
            <tr>
                <th>休憩</th>
                <td>12:00</td>
                <td>～</td>
                <td>13:00</td>
            </tr>
            <tr>
                <th>休憩2</th>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>備考</th>
                <td colspan="3">電車遅延のため</td>
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