<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理システム</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__logo"><img src="{{ asset('img/coachtech.svg') }}" alt=""></div>
        <nav class="header__nav">
            <ul>
                @if (Auth::guard('admin')->check())
                    <li><a href="/admin/attendance/list">勤怠一覧</a></li>
                    <li><a href="/admin/staff/list">スタッフ一覧</a></li>
                    <li><a href="/stamp_correction_request/list">申請一覧</a></li>
                @endif
                @if (Auth::guard('web')->check() && Auth::guard('web')->user()->hasVerifiedEmail())
                    @if (isset($attendanceStatus) && $attendanceStatus == '退勤済')
                        <li><a href="/attendance/list">今月の出勤一覧</a></li>
                        <li><a href="/stamp_correction_request/list">申請一覧</a></li>
                    @else
                        <li><a href="/attendance">勤怠</a></li>
                        <li><a href="/attendance/list">勤怠一覧</a></li>
                        <li><a href="/stamp_correction_request/list">申請</a></li>
                    @endif
                @endif
                @if (Auth::guard('admin')->check())
                    <li>
                        <form action="/admin/logout" method="post">
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    </li>
                @elseif (Auth::guard('web')->check() && Auth::guard('web')->user()->hasVerifiedEmail())
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    </li>
                @endif
            </ul>
        </nav>
    </header>
    <main class="main">
        @yield('content')
    </main>
</body>
</html>