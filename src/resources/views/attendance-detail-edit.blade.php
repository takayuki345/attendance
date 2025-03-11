@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-detail-edit.css') }}">
@endsection

@section('content')
<div class="attendance-detail-edit__wrapper">
    <h2 class="attendance-detail-edit__title">勤怠詳細</h2>
    <div class="attendance-detail-edit__container">
        <form class="attendance-detail-edit__form" action="" method="">
            <table class="form__table">
                <tr>
                    <th>名前</th>
                    <td class="table__td-name" colspan="3">西　伶奈</td>
                    <td></td>
                </tr>
                <tr>
                    <th>日付</th>
                    <td class="table__td-year">2023年</td>
                    <td></td>
                    <td class="table__td-date">6月1日</td>
                    <td></td>
                </tr>
                <tr>
                    <th>出勤・退勤</th>
                    <td class="table__td-start"><input type="text" value="09:00"></td>
                    <td class="table__td-to">～</td>
                    <td class="table__td-end"><input  type="text" value="18:00"></td>
                    <td></td>
                </tr>
                <tr>
                    <th>休憩</th>
                    <td class="table__td-break-start"><input type="text" value="12:00"></td>
                    <td class="table__td-to">～</td>
                    <td class="table__td-break-end"><input type="text" value="13:00"></td>
                    <td></td>
                </tr>
                <tr>
                    <th>休憩2</th>
                    <td class="table__td-break-start"><input type="text"></td>
                    <td class="table__td-to">～</td>
                    <td class="table__td-break-end"><input type="text"></td>
                    <td></td>
                </tr>
                <tr>
                    <th>備考</th>
                    <td class="table__td-note" colspan="3"><textarea name="" id="">電車遅延のため</textarea></td>
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