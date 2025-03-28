<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;


    // １．認証機能（一般ユーザー）

    public function test01_01()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test0@test',
            'password' => 'test0test0',
            'password_confirmation' => 'test0test0',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
    }
    public function test01_02()
    {
        $response = $this->post('/register', [
            'name' => 'test0',
            'email' => '',
            'password' => 'test0test0',
            'password_confirmation' => 'test0test0',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }
    public function test01_03()
    {
        $response = $this->post('/register', [
            'name' => 'test0',
            'email' => 'test0@test',
            'password' => 'test0',
            'password_confirmation' => 'test0',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }
    public function test01_04()
    {
        $response = $this->post('/register', [
            'name' => 'test0',
            'email' => 'test0@test',
            'password' => 'test0test0',
            'password_confirmation' => 'abcdefghij',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません',
        ]);
    }
    public function test01_05()
    {
        $response = $this->post('/register', [
            'name' => 'test0',
            'email' => 'test0@test',
            'password' => '',
            'password_confirmation' => 'test0test0',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }
    public function test01_06()
    {
        $response = $this->post('/register', [
            'name' => 'test0',
            'email' => 'test0@test',
            'password' => 'test0test0',
            'password_confirmation' => 'test0test0',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'test0',
            'email' => 'test0@test',
        ]);
    }


    // ２．ログイン認証機能（一般ユーザー）

    public function test02_01()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'test1test1',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }
    public function test02_02()
    {
        $response = $this->post('/login', [
            'email' => 'test1@test',
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }
    public function test02_03()
    {
        $response = $this->post('/login', [
            'email' => 'abcdefg@test',
            'password' => 'test1test1',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }


    // ３．ログイン認証機能（管理者）

    public function test03_01()
    {
        $response = $this->post('/admin/login', [
            'email' => '',
            'password' => 'admin1admin1',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }
    public function test03_02()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin1@admin',
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }
    public function test03_03()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin1@admin',
            'password' => 'abcdefghij',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }


    // ４．日時取得機能

    public function test04_01()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/attendance');

        $date = Carbon::now()->isoFormat('YYYY年M月D日(ddd)');
        $time = Carbon::now()->isoFormat('HH:mm');

        $response->assertSee([$date, $time]);
    }


    // ５．ステータス確認機能

    public function test05_01()
    {
        // 「勤務外」のユーザー
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/attendance');

        $response->assertSee('<span>勤務外</span>', false);

    }
    public function test05_02()
    {
        // 「出勤中」のユーザー
        $user = User::find(2);

        $response = $this->actingAs($user)->get('/attendance');

        $response->assertSee('<span>出勤中</span>', false);
    }
    public function test05_03()
    {
        // 「休憩中」のユーザー
        $user = User::find(3);

        $response = $this->actingAs($user)->get('/attendance');

        $response->assertSee('<span>休憩中</span>', false);
    }
    public function test05_04()
    {
        // 「退勤済」のユーザー
        $user = User::find(4);

        $response = $this->actingAs($user)->get('/attendance');

        $response->assertSee('<span>退勤済</span>', false);
    }


    // ６．出勤機能

    public function test06_01()
    {
        // 「勤務外」のユーザー
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/attendance');

        $response->assertSee('>出勤</button>', false);

        $response = $this->post('/attendance', [
            'action' => 'start',
        ]);

        $this->followRedirects($response)->assertSee('<span>出勤中</span>', false);
    }
    public function test06_02()
    {
        // 「退勤済」のユーザー
        $user = User::find(4);

        $response = $this->actingAs($user)->get('/attendance');

        $response->assertDontSee('>出勤</button>', false);

    }
    public function test06_03()
    {
        // 「勤務外」のユーザー
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/attendance');

        $response = $this->post('/attendance', [
            'action' => 'start',
        ]);

        $date = Carbon::now()->isoFormat('MM/DD(ddd)');
        $time = Carbon::now()->isoFormat('HH:mm');

        $response = $this->get('attendance/list');

        // 【途中】
        $response->assertSeeInOrder([$date, $time]);
    }


    // ７．休憩機能

    public function test07_01()
    {
        // 「出勤中」のユーザー
        $user = User::find(2);

        $response = $this->actingAs($user)->get('/attendance');

        $response->assertSee('>休憩入</button>', false);

        $response = $this->post('/attendance', [
            'action' => 'break_start'
        ]);

        $this->followRedirects($response)->assertSee('<span>休憩中</span>', false);

    }
    public function test07_02()
    {
        // 「出勤中」のユーザー
        $user = User::find(2);

        $response = $this->actingAs($user)->get('/attendance');

        $this->post('/attendance', [
            'action' => 'break_start'
        ]);

        $response = $this->post('/attendance', [
            'action' => 'break_end'
        ]);

        $this->followRedirects($response)->assertSee('>休憩入</button>', false);
    }
    public function test07_03()
    {
        // 「出勤中」のユーザー
        $user = User::find(2);

        $response = $this->actingAs($user)->get('/attendance');

        $response = $this->post('/attendance', [
            'action' => 'break_start'
        ]);

        $this->followRedirects($response)->assertSee('>休憩戻</button>', false);

        $response = $this->post('/attendance', [
            'action' => 'break_end'
        ]);

        $this->followRedirects($response)->assertSee('<span>出勤中</span>', false);
    }
    public function test07_04()
    {
        // 「出勤中」のユーザー
        $user = User::find(2);

        $response = $this->actingAs($user)->get('/attendance');

        $this->post('/attendance', [
            'action' => 'break_start'
        ]);

        $this->post('/attendance', [
            'action' => 'break_end'
        ]);

        $response = $this->post('/attendance', [
            'action' => 'break_start'
        ]);

        $this->followRedirects($response)->assertSee('>休憩戻</button>', false);
    }
    public function test07_05()
    {
        // 「出勤中」のユーザー (出勤時間 01:00)
        $user = User::find(2);

        $response = $this->actingAs($user)->get('/attendance');

        $this->post('/attendance', [
            'action' => 'break_start'
        ]);

        $breakStart = Carbon::now()->seconds(0);

        $response = $this->post('/attendance', [
            'action' => 'break_end'
        ]);

        $breakEnd = Carbon::now()->seconds(0);

        $date = Carbon::now()->isoFormat('MM/DD(ddd)');
        $nextDate = Carbon::now()->addDay()->isoFormat('MM/DD(ddd)');

        $diffInMinutes = $breakStart->diffInMinutes($breakEnd);

        $hours = floor($diffInMinutes / 60);
        $minutes = $diffInMinutes % 60;

        $breakTime = sprintf('%02d:%02d', $hours, $minutes);

        $response = $this->get('/attendance/list');

        if (Carbon::now()->isLastOfMonth()) {
            $response->assertSeeInOrder([$date, '01:00', $breakTime]);
        } else {
            $response->assertSeeInOrder([$date, '01:00', $breakTime, $nextDate]);
        }
    }


    // ８．退勤機能

    public function test08_01()
    {
        // 「出勤中」のユーザー
        $user = User::find(2);

        $response = $this->actingAs($user)->get('/attendance');

        $response->assertSee('>退勤</button>', false);

        $response = $this->post('/attendance', [
            'action' => 'end',
        ]);

        $this->followRedirects($response)->assertSee('<span>退勤済</span>', false);
    }
    public function test08_02()
    {
        // 「勤務外」のユーザー
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/attendance');

        $this->post('/attendance', [
            'action' => 'start',
        ]);

        $start = Carbon::now()->seconds(0)->format('H:i');

        $this->post('/attendance', [
            'action' => 'end',
        ]);

        $end = Carbon::now()->seconds(0)->format('H:i');

        $response = $this->get('attendance/list');

        $date = Carbon::now()->isoFormat('MM/DD(ddd)');
        $nextDate = Carbon::now()->addDay()->isoFormat('MM/DD(ddd)');

        if (Carbon::now()->isLastOfMonth()) {
            $response->assertSeeInOrder([$date, $start, $end]);
        } else {
            $response->assertSeeInOrder([$date, $start, $end, $nextDate]);
        }
    }


    // ９．勤怠一覧情報取得機能（一般ユーザー）

    public function test09_01()
    {
        // 当月初日にデータを持つユーザー
        $user = User::find(5);

        $response = $this->actingAs($user)->get('/attendance/list');

        $date = Carbon::now()->startOfMonth()->isoFormat('MM/DD(ddd)');
        $nextDate = Carbon::now()->startOfMonth()->addDay()->isoFormat('MM/DD(ddd)');

        $response->assertSeeInOrder([$date, '08:00', '20:00', '02:00', '10:00', $nextDate]);
    }
    public function test09_02()
    {
        // 任意のユーザー
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/attendance/list');

        $thisMonth = Carbon::now()->isoFormat('YYYY/MM');

        $response->assertSee('<span>' . $thisMonth . '</span>', false);
    }

    public function test09_03()
    {
        // 前月に勤務データを持つユーザー
        $user = User::find(5);

        $response = $this->actingAs($user)->get('/attendance/list');

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('a:contains("前月")')->attr('href');

        $response = $this->get($link);

        $date = Carbon::now()->subMonth()->startOfMonth()->isoFormat('MM/DD(ddd)');
        $nextDate = Carbon::now()->subMonth()->startOfMonth()->addDay()->isoFormat('MM/DD(ddd)');

        $response->assertSeeInOrder([$date, '07:00', '21:00', '03:00', '11:00', $nextDate]);
    }
    public function test09_04()
    {
        // 翌月に勤務データを持つユーザー
        $user = User::find(5);

        $response = $this->actingAs($user)->get('/attendance/list');

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('a:contains("翌月")')->attr('href');

        $response = $this->get($link);

        $date = Carbon::now()->addMonth()->startOfMonth()->isoFormat('MM/DD(ddd)');
        $nextDate = Carbon::now()->addMonth()->startOfMonth()->addDay()->isoFormat('MM/DD(ddd)');

        $response->assertSeeInOrder([$date, '09:00', '19:00', '01:00', '09:00', $nextDate]);
    }
    public function test09_05()
    {
        // 当月初日に勤務データを持つユーザー
        $user = User::find(5);

        $response = $this->actingAs($user)->get('/attendance/list');

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('a:contains("詳細")')->attr('href');

        $response = $this->get($link);

        $year = Carbon::now()->isoFormat('YYYY年');
        $day = Carbon::now()->startOfMonth()->isoFormat('M月D日');

        $response->assertSeeInOrder([
            '名前', $user->name,
            '日付', $year, $day,
            '出勤・退勤', '08:00', '20:00',
            '休憩', '11:30', '13:30',
        ]);
    }


    // １０．勤怠詳細情報取得機能（一般ユーザー）

    public function test10_01()
    {
        // 当月初日に勤怠データを持つユーザー
        $user = User::find(5);

        $response = $this->actingAs($user)->get('/attendance/list');

        $crawler = new Crawler($response->getContent());

        $href = $crawler->filter('table tr:contains("/01(") a')->attr('href');

        $response = $this->get($href);

        $response->assertSeeInOrder(['名前', $user->name]);
    }

    public function test10_02()
    {
        // 当月初日に勤怠データを持つユーザー
        $user = User::find(5);

        $response = $this->actingAs($user)->get('/attendance/list');

        $crawler = new Crawler($response->getContent());

        $href = $crawler->filter('table tr:contains("/01(") a')->attr('href');

        $response = $this->get($href);

        $date = Carbon::now()->startOfMonth();
        $year = $date->isoFormat('YYYY年');
        $day = $date->isoFormat('M月D日');

        $response->assertSeeInOrder(['日付', $year, $day]);
    }
    public function test10_03()
    {
        // 当月初日に勤怠データを持つユーザー
        $user = User::find(5);

        $response = $this->actingAs($user)->get('/attendance/list');

        $crawler = new Crawler($response->getContent());

        $href = $crawler->filter('table tr:contains("/01(") a')->attr('href');

        $response = $this->get($href);

        $response->assertSeeInOrder(['出勤・退勤', '08:00', '20:00', '休憩']);
    }

    public function test10_04()
    {
        // 当月初日に勤怠データを持つユーザー
        $user = User::find(5);

        $response = $this->actingAs($user)->get('/attendance/list');

        $crawler = new Crawler($response->getContent());

        $href = $crawler->filter('table tr:contains("/01(") a')->attr('href');

        $response = $this->get($href);

        $response->assertSeeInOrder(['休憩', '11:30', '13:30', '休憩 2']);
    }


    // １１．勤怠詳細情報修正機能（一般ユーザー）

    public function test11_01()
    {
        // 当月月初や前月月初に勤怠データを持つユーザー
        $user = User::find(5);

        $response = $this->actingAs($user)->get('/attendance/list');

        if (Carbon::now()->day == 1) {

            $crawler = new Crawler($response->getContent());

            $link = $crawler->filter('a:contains("前月")')->attr('href');

            $response = $this->get($link);

        }

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('table tr:contains("/01(") a')->attr('href');

        $this->get($link);

        $response = $this->post($link, [
            'start' => '18:00',
            'end' => '17:00',
        ]);

        $response->assertSessionHasErrors([
            'start' => '出勤時間もしくは退勤時間が不適切な値です',
        ]);
    }
    public function test11_02()
    {
        // 当月月初や前月月初に勤怠データを持つユーザー
        $user = User::find(5);

        $response = $this->actingAs($user)->get('/attendance/list');

        if (Carbon::now()->day == 1) {

            $crawler = new Crawler($response->getContent());

            $link = $crawler->filter('a:contains("前月")')->attr('href');

            $response = $this->get($link);

        }

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('table tr:contains("/01(") a')->attr('href');

        $this->get($link);

        $response = $this->post($link, [
            'start' => '01:30',
            'end' => '05:30',
            'break_start' => ['22:30'],
            'break_end' => ['23:30'],
        ]);

        $response->assertSessionHasErrors([
            'break_end.0' => '休憩時間が勤務時間外です',
        ]);
    }
    public function test11_03()
    {
        // 当月月初や前月月初に勤怠データを持つユーザー
        $user = User::find(5);

        $response = $this->actingAs($user)->get('/attendance/list');

        if (Carbon::now()->day == 1) {

            $crawler = new Crawler($response->getContent());

            $link = $crawler->filter('a:contains("前月")')->attr('href');

            $response = $this->get($link);

        }

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('table tr:contains("/01(") a')->attr('href');

        $this->get($link);

        $response = $this->post($link, [
            'start' => '01:30',
            'end' => '05:30',
            'break_start' => ['03:30'],
            'break_end' => ['23:30'],
        ]);

        $response->assertSessionHasErrors([
            'break_end.0' => '休憩時間が勤務時間外です',
        ]);
    }
    public function test11_04()
    {
        // 当月月初や前月月初に勤怠データを持つユーザー
        $user = User::find(5);

        $response = $this->actingAs($user)->get('/attendance/list');

        if (Carbon::now()->day == 1) {

            $crawler = new Crawler($response->getContent());

            $link = $crawler->filter('a:contains("前月")')->attr('href');

            $response = $this->get($link);

        }

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('table tr:contains("/01(") a')->attr('href');

        $this->get($link);

        $response = $this->post($link, [
            'start' => '08:30',
            'end' => '17:30',
            'break_start.0' => '12:00',
            'break_end.0' => '13:00',
            'note' => '',
        ]);

        $response->assertSessionHasErrors([
            'note' => '備考を記入してください',
        ]);
    }
    public function test11_05()
    {
        // 当月月初や前月月初に勤怠データを持つユーザー
        // ※当日の勤怠データは編集不可の仕様のために、当日が当月月初であれば前月月初でテストを行う
        $user = User::find(5);

        $start = '05:00';
        $end = '16:00';
        $breakStart = '10:00';
        $breakEnd = '11:00';
        $note = 'test11_05';

        $response = $this->actingAs($user)->get('/attendance/list');

        if (Carbon::now()->day == 1) {

            $crawler = new Crawler($response->getContent());

            $link = $crawler->filter('a:contains("前月")')->attr('href');

            $response = $this->get($link);

            $date = Carbon::now()-subMonth()->startOfMonth()->isoFormat('YYYY/MM/DD');
            $year = Carbon::now()-subMonth()->isoFormat('YYYY年');
            $day = Carbon::now()-subMonth()->startOfMonth()->isoFormat('M月D日');

        } else {

            $date = Carbon::now()->startOfMonth()->isoFormat('YYYY/MM/DD');
            $year = Carbon::now()->isoFormat('YYYY年');;
            $day = Carbon::now()->startOfMonth()->isoFormat('M月D日');

        }

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('table tr:contains("/01(") a')->attr('href');

        $response = $this->get($link);

        $crawler = new Crawler($response->getContent());

        $id = $crawler->filter('input[name="id[]"]')->attr('value');

        $response = $this->post($link, [
            'start' => $start,
            'end' => $end,
            'break_start' => [$breakStart],
            'break_end' => [$breakEnd],
            'id' => [$id],
            'break_start_add' => '',
            'break_start_end' => '',
            'note' => $note,
        ]);

        $this->get('/logout');

        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/stamp_correction_request/list');

        $response->assertSeeInOrder(['承認待ち', $user->name, $date, $note]);

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filterXPath("//table//tr[contains(., '{$user->name}') and contains(., '{$date}')]//a")
                ->attr('href');

        $response = $this->get($link);

        $response->assertSeeInOrder([
            '名前', $user->name,
            '日付', $year, $day,
            '出勤・退勤', $start, $end,
            '休憩', $breakStart, $breakEnd,
            '備考', $note,
        ]);
    }
    public function test11_06()
    {
        // 承認前の申請データを持つユーザー
        $user = User::find(1);

        $response = $this->actingAs($user)->get('stamp_correction_request/list');

        $day = Carbon::now()->subMonth(2)->startOfMonth()->isoFormat('YYYY/MM/DD');

        $response->assertSeeInOrder(['承認待ち', $user->name, $day]);
    }
    public function test11_07()
    {
        // 承認後の申請データを持つユーザー
        $user = User::find(4);

        $response = $this->actingAs($user)->get('stamp_correction_request/list?status=3');

        $day = Carbon::now()->subMonth(2)->startOfMonth()->isoFormat('YYYY/MM/DD');

        $response->assertSeeInOrder(['承認済み', $user->name, $day]);
    }
    public function test11_08()
    {
        // 申請データを持つ任意のユーザー
        $user = User::find(2);

        $response = $this->actingAs($user)->get('stamp_correction_request/list');

        $crawler = new Crawler($response->getContent());

        $year = Carbon::now()->subMonth(2)->isoFormat('YYYY年');
        $day = Carbon::now()->subMonth(2)->startOfMonth()->isoFormat('M月D日');

        $link = $crawler->filter('a:contains("詳細")')->attr('href');

        $response = $this->get($link);

        $response->assertSeeInOrder([
            '名前', $user->name,
            '日付', $year, $day,
            '出勤・退勤', '08:10', '20:10',
            '休憩', '11:40', '13:40',
        ]);
    }


    // １２．勤怠一覧情報取得機能（管理者）

    public function test12_01()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/list');

        $this->followRedirects($response)->assertSeeInOrder([
            'test1',
            'test2', '01:00', '詳細',
            'test3', '01:00', '詳細',
            'test4', '08:00', '20:00', '02:00', '10:00', '詳細',
            'test5',
        ]);
    }
    public function test12_02()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/list');

        $day = Carbon::now()->isoFormat('YYYY年M月D日');

        $this->followRedirects($response)->assertSee($day . 'の勤怠');
    }
    public function test12_03()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/list');

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('a:contains("前日")')->attr('href');

        $response = $this->get($link);

        $day = Carbon::now()->subDay()->isoFormat('YYYY年M月D日');

        $this->followRedirects($response)->assertSee($day . 'の勤怠');
    }
    public function test12_04()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/list');

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('a:contains("翌日")')->attr('href');

        $response = $this->get($link);

        $day = Carbon::now()->addDay()->isoFormat('YYYY年M月D日');

        $this->followRedirects($response)->assertSee($day . 'の勤怠');
    }


    // １３．勤怠詳細情報取得・修正機能（管理者）

    public function test13_01()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/list');

        $crawler = new Crawler($response->getContent());

        // 当日の確定した勤怠データを持つユーザー
        $user = User::find(4);

        $start = $crawler->filter('tr:contains("' . $user->name . '") td:nth-of-type(3)')->text();
        $end = $crawler->filter('tr:contains("' . $user->name . '") td:nth-of-type(4)')->text();
        $link = $crawler->filter('tr:contains("' . $user->name . '") a')->attr('href');

        $response = $this->get($link);

        $date = Carbon::now();
        $year = $date->isoFormat('YYYY年');
        $day = $date->isoFormat('M月D日');

        $response->assertSeeInOrder([
            '名前', $user->name,
            '日付', $year, $day,
            '出勤・退勤', $start, $end,
            '休憩',
        ]);
    }
    public function test13_02()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/list');

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('a:contains("前日")')->attr('href');

        $response = $this->get($link);

        // 前日の勤怠データを持つユーザー
        $user = User::find(4);

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('tr:contains("' . $user->name . '") a')->attr('href');

        $response = $this->get($link);

        $crawler = new Crawler($response->getContent());

        $node = $crawler->filter('input[name="id[]"]');

        if ($node->count() > 0) {
            $id = $node->attr('value');
        } else {
            $id = null;
        }

        if ($id == null) {
            $param = [
                'start' => '20:00',
                'end' => '19:00',
                'break_start_add' => null,
                'break_end_add' => null,
                'note' => 'test13_02',
            ];
        } else {
            $param = [
                'start' => '20:00',
                'end' => '19:00',
                'break_start' => ['12:00'],
                'break_end' => ['13:00'],
                'id' => [$id],
                'break_start_add' => null,
                'break_end_add' => null,
                'note' => 'test13_02',
            ];
        }

        $response = $this->post($link, $param);

        $response->assertSessionHasErrors([
            'start' => '出勤時間もしくは退勤時間が不適切な値です',
        ]);
    }
    public function test13_03()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/list');

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('a:contains("前日")')->attr('href');

        $response = $this->get($link);

        // 前日の勤怠データを持つユーザー
        $user = User::find(4);

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('tr:contains("' . $user->name . '") a')->attr('href');

        $response = $this->get($link);

        $crawler = new Crawler($response->getContent());

        $node = $crawler->filter('input[name="id[]"]');

        if ($node->count() > 0) {
            $id = $node->attr('value');
        } else {
            $id = null;
        }

        if ($id == null) {
            $param = [
                'start' => '07:00',
                'end' => '19:00',
                'break_start_add' => '22:00',
                'break_end_add' => '23:00',
                'note' => 'test13_02',
            ];
        } else {
            $param = [
                'start' => '07:00',
                'end' => '19:00',
                'break_start' => ['22:00'],
                'break_end' => ['23:00'],
                'id' => [$id],
                'break_start_add' => '22:00',
                'break_end_add' => '23:00',
                'note' => 'test13_02',
            ];
        }

        $response = $this->post($link, $param);

        if ($id == null) {
            $param2 = [
                'break_end_add' => '休憩時間が勤務時間外です',
            ];
        } else {
            $param2 = [
                'break_end.0' => '休憩時間が勤務時間外です',
                'break_end_add' => '休憩時間が勤務時間外です',
            ];
        }

        $response->assertSessionHasErrors($param2);
    }
    public function test13_04()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/list');

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('a:contains("前日")')->attr('href');

        $response = $this->get($link);

        // 前日の勤怠データを持つユーザー
        $user = User::find(4);

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('tr:contains("' . $user->name . '") a')->attr('href');

        $response = $this->get($link);

        $crawler = new Crawler($response->getContent());

        $node = $crawler->filter('input[name="id[]"]');

        if ($node->count() > 0) {
            $id = $node->attr('value');
        } else {
            $id = null;
        }

        if ($id == null) {
            $param = [
                'start' => '07:00',
                'end' => '19:00',
                'break_start_add' => '17:00',
                'break_end_add' => '23:00',
                'note' => 'test13_02',
            ];
        } else {
            $param = [
                'start' => '07:00',
                'end' => '19:00',
                'break_start' => ['17:00'],
                'break_end' => ['23:00'],
                'id' => [$id],
                'break_start_add' => '17:00',
                'break_end_add' => '23:00',
                'note' => 'test13_02',
            ];
        }

        $response = $this->post($link, $param);

        if ($id == null) {
            $param2 = [
                'break_end_add' => '休憩時間が勤務時間外です',
            ];
        } else {
            $param2 = [
                'break_end.0' => '休憩時間が勤務時間外です',
                'break_end_add' => '休憩時間が勤務時間外です',
            ];
        }

        $response->assertSessionHasErrors($param2);
    }
    public function test13_05()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/list');

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('a:contains("前日")')->attr('href');

        $response = $this->get($link);

        // 前日の勤怠データを持つユーザー
        $user = User::find(4);

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('tr:contains("' . $user->name . '") a')->attr('href');

        $response = $this->get($link);

        $crawler = new Crawler($response->getContent());

        $node = $crawler->filter('input[name="id[]"]');

        if ($node->count() > 0) {
            $id = $node->attr('value');
        } else {
            $id = null;
        }

        if ($id == null) {
            $param = [
                'start' => '07:00',
                'end' => '19:00',
                'break_start_add' => '12:00',
                'break_end_add' => '13:00',
                'note' => null,
            ];
        } else {
            $param = [
                'start' => '07:00',
                'end' => '19:00',
                'break_start' => ['12:00'],
                'break_end' => ['13:00'],
                'id' => [$id],
                'break_start_add' => '12:00',
                'break_end_add' => '13:00',
                'note' => null,
            ];
        }

        $response = $this->post($link, $param);

        $response->assertSessionHasErrors([
            'note' => '備考を記入してください',
        ]);
    }


    // １４．ユーザー情報取得機能（管理者）

    public function test14_01()
    {
        $admin = Admin::find(1);

        $users = User::all();

        $userList = [];

        foreach ($users as $user) {
            array_push($userList, $user->name);
            array_push($userList, $user->email);
        }

        $response = $this->actingAs($admin, 'admin')->get('/admin/staff/list');

        $response->assertSeeInOrder($userList);
    }
    public function test14_02()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/staff/list');

        // 当日の完了した勤怠データを持つユーザー
        $user = User::find(4);

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('tr:contains("' . $user->name . '") a')->attr('href');

        $response = $this->get($link);

        $today = Carbon::now()->isoFormat('M/D(ddd)');
        $tomorrow = Carbon::now()->addDay()->isoFormat('M/D(ddd)');

        if (Carbon::now()->addDay()->day == 1) {
            $checkList = [$today, '08:00', '20:00', '02:00', '10:00'];
        } else {
            $checkList = [$today, '08:00', '20:00', '02:00', '10:00', $tomorrow];
        }

        $response->assertSeeInOrder($checkList);
    }
    public function test14_03()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/staff/list');

        // 前月初日に勤務データを持つユーザー
        $user = User::find(5);

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('tr:contains("' . $user->name . '") a')->attr('href');

        $response = $this->get($link);

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('a:contains("前月")')->attr('href');

        $response = $this->get($link);

        $day = Carbon::now()->subMonth()->startOfMonth()->isoFormat('MM/DD(ddd)');
        $nextDay = Carbon::now()->subMonth()->startOfMonth()->addDay()->isoFormat('MM/DD(ddd)');

        $checkList = [$day, '07:00', '21:00', '03:00', '11:00', $nextDay];

        $response->assertSeeInOrder($checkList);
    }
    public function test14_04()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/staff/list');

        // 翌月初日の勤務データを持つユーザー
        $user = User::find(5);

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('tr:contains("' . $user->name . '") a')->attr('href');

        $response = $this->get($link);

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('a:contains("翌月")')->attr('href');

        $response = $this->get($link);

        $day = Carbon::now()->addMonth()->startOfMonth()->isoFormat('MM/DD(ddd)');
        $nextDay = Carbon::now()->addMonth()->startOfMonth()->addDay()->isoFormat('MM/DD(ddd)');

        $checkList = [$day, '09:00', '19:00', '01:00', '09:00', $nextDay];

        $response->assertSeeInOrder($checkList);
    }
    public function test14_05()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/staff/list');

        // 当日の勤怠データを持つユーザー
        $user = User::find(4);

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('tr:contains("' . $user->name . '") a')->attr('href');

        $response = $this->get($link);

        $crawler = new Crawler($response->getContent());

        $day = Carbon::now()->isoFormat('M/D(ddd)');

        $link = $crawler->filter('tr:contains("' . $day . '") a')->attr('href');

        $response = $this->get($link);

        $year = Carbon::now()->isoFormat('YYYY年');
        $day2 = Carbon::now()->isoFormat('M月D日');

        $checkList = ['名前', $user->name, '日付', $year, $day2, '出勤・退勤','08:00', '20:00', '休憩', '11:30', '13:30'];

        $response->assertSeeInOrder($checkList);
    }


    // １５．勤怠情報修正機能（管理者）

    public function test15_01()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('stamp_correction_request/list');

        $date = Carbon::now()->subMonth(2)->startOfMonth()->isoFormat('YYYY/MM/DD');

        $checkList = [
            '承認待ち', 'test1', $date,
            '承認待ち', 'test2', $date,
            '承認待ち', 'test3', $date,
            ];

        $response->assertSeeInOrder($checkList);
    }
    public function test15_02()
    {
        $admin = Admin::find(1);

        $response = $this->actingAs($admin, 'admin')->get('stamp_correction_request/list');

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('a:contains("承認済")')->attr('href');

        $response = $this->get($link);

        $date = Carbon::now()->subMonth(2)->startOfMonth()->isoFormat('YYYY/MM/DD');

        $checkList = [
            '承認済み', 'test4', $date,
            '承認済み', 'test5', $date,
            ];

        $response->assertSeeInOrder($checkList);
    }
    public function test15_03()
    {
        $admin = Admin::find(1);

        // 前々月初日の申請データを持つ任意のユーザー
        $user = User::find(1);

        $response = $this->actingAs($admin, 'admin')->get('stamp_correction_request/list');

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('tr:contains("' . $user->name . '") a:contains("詳細")')->attr('href');

        $response = $this->get($link);

        $year = Carbon::now()->subMonth(2)->startOfMonth()->isoFormat('YYYY年');
        $day = Carbon::now()->subMonth(2)->startOfMonth()->isoFormat('M月D日');

        $checkList = [
            '名前', $user->name,
            '日付', $year, $day,
            '出勤・退勤', '09:10', '19:10',
            '休憩', '12:10', '13:10',
            ];

        $response->assertSeeInOrder($checkList);
    }
    public function test15_04()
    {
        $admin = Admin::find(1);

        // 前々月初日の申請データを持つ任意のユーザー
        $user = User::find(1);

        $response = $this->actingAs($admin, 'admin')->get('stamp_correction_request/list');

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('tr:contains("' . $user->name . '") a:contains("詳細")')->attr('href');

        $response = $this->get($link);

        $this->post($link);

        $year = Carbon::now()->subMonth(2)->year;
        $year2 = Carbon::now()->subMonth(2)->startOfMonth()->isoFormat('YYYY年');
        $month = Carbon::now()->subMonth(2)->month;
        $day = Carbon::now()->subMonth(2)->startOfMonth()->isoFormat('MM/DD(ddd)');
        $day2 = Carbon::now()->subMonth(2)->startOfMonth()->isoFormat('M月D日');

        $link = '/admin/attendance/staff/' . $user->id . '?year=' . $year . '&month=' .$month;

        $response = $this->get($link);

        $crawler = new Crawler($response->getContent());

        $link = $crawler->filter('tr:contains("' . $day . '") a:contains("詳細")')->attr('href');

        $response = $this->get($link);

        $checkList = [
            '名前', $user->name,
            '日付', $year2, $day2,
            '出勤・退勤', '09:10', '19:10',
            '休憩', '12:10', '13:10',
            ];

        $response->assertSeeInOrder($checkList);
    }

}
