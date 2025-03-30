# 勤怠管理アプリ

## Dockerビルド
1. GitHubからクローン
``` bash
git clone git@github.com:takayuki345/attendance.git
```
2. 大元OSでDockerDesktopアプリの起動
3. 作成された「attendance」ディレクトリに移動し、Dockerコンテナ群を起動
``` bash
docker compose up -d --build
```

### Laravel環境構築
1. phpコンテナに入る
``` bash
docker compose exec php bash
```
2. 必要なパッケージをインストール
``` bash
composer install
```
3. .envを.env.exampleファイルからコピー作成
``` bash
cp .env.example .env
```
4. .envで以下の環境変数の値をメンテナンス（※メール関連は「Mailtrap」から参照）
``` text

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

        （中略）

MAIL_MAILER=（Mailtrapから参照）
MAIL_HOST=（Mailtrapから参照）
MAIL_PORT=（Mailtrapから参照）
MAIL_USERNAME=（Mailtrapから参照）
MAIL_PASSWORD=（Mailtrapから参照）
MAIL_ENCRYPTION=（Mailtrapから参照）
MAIL_FROM_ADDRESS=no-reply@test

```
5. アプリケーションキーの作成
``` bash
php artisan key:generate
```
6. マイグレーションおよびシーディングの実行
``` bash
php artisan migrate --seed
```

## 使用技術（実行環境）
- php 7.4.9
- Laravel 8.83.29
- Mysql 8.0.26

## ER図
![ER図](ER_diagram.jpg)

## URL
- 開発環境：http://localhost/
***（アクセス権の問題で`sudo chmod 777 -R src`が必要となる場合あり）***
- pypMyAdmin：http://localhost:8080/
- mailtrap：https://mailtrap.io/

## テストアカウントおよびデータ概要

- 一般ユーザー
``` text
name: test1
email: test1@test
password: test1test1
-------------------------
name: test2
email: test2@test
password: test2test2
-------------------------
name: test3
email: test3@test
password: test3test3
-------------------------
name: test4
email: test4@test
password: test4test4
-------------------------
name: test5
email: test5@test
password: test5test5
```
- 管理者
``` text
name: admin1
email: admin1@admin
password: admin1admin1
```

![ER図](Test_data.jpg)


## PHPUnitによるテスト
1. .env.testingを.envファイルからコピー作成
``` bash
cp .env .env.testing
```
2. env.testingで以下の環境変数の値をメンテナンス（※アプリケーションキーの値は削除しておく）
``` text

APP_ENV=test
APP_KEY=（削除）

        （中略）

DB_DATABASE=demo_test
DB_USERNAME=root
DB_PASSWORD=root

```

3. アプリケーションキー作成
``` bash
php artisan key:generate --env=testing
```
4. データベースの作成（※mysqlコンテナで行う、パスワードは「root」）
``` bash
docker-compose exec mysql bash
```
``` bash
mysql -u root -p
```
``` bash
create database demo_test;
```

5. マイグレーションおよびシーディングの実行（※phpコンテナで行う）
``` bash
docker-compose exec php bash
```
``` bash
php artisan migrate --seed --env=testing
```
6. キャッシュ関連クリア
``` bash
php artisan config:clear
php artisan cache:clear
```
7. PUPUnitでテスト
``` bash
vendor/bin/phpunit tests/Feature/AttendanceTest.php
```
