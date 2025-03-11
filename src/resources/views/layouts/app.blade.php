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
                <li><a href="">勤怠一覧</a></li>
                <li><a href="">スタッフ一覧</a></li>
                <li><a href="">申請一覧</a></li>
                <!-- <li><a href="">ログアウト</a></li> -->
                <li>
                    <form action="">
                        <button type="submit">ログアウト</button>
                    </form>
                </li>
                <!-- <li><a href="">勤怠</a></li>
                <li><a href="">勤怠一覧</a></li>
                <li><a href="">申請</a></li>
                <li><a href="">今月の出勤一覧</a></li>
                <li><a href="">申請一覧</a></li>
                <li>
                    <form action="">
                        <button type="submit">ログアウト</button>
                    </form>
                </li> -->
            </ul>
        </nav>
    </header>
    <main class="main">
        @yield('content')
    </main>
</body>
</html>