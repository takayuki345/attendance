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
                @if (Auth::guard('web')->check())
                    <li><a href="/attendance">勤怠</a></li>
                    <li><a href="/attendance/list">勤怠一覧</a></li>
                    <li><a href="/stamp_correction_request/list">申請</a></li>
                    <!-- <li><a href="">今月の出勤一覧</a></li>
                    <li><a href="">申請一覧</a></li> -->
                @endif
                <li>
                    @if (Auth::guard('admin')->check())
                        <form action="/admin/logout" method="post">
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    @elseif (Auth::guard('web')->check())
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    @endif
                </li>
            </ul>
        </nav>
    </header>
    <main class="main">
        @yield('content')
    </main>
</body>
</html>