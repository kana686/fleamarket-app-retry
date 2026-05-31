# COACHTECHフリマアプリ

## 概要

本アプリは、ユーザーが商品の閲覧・出品・購入ができるフリマアプリです。

- 会員登録/ログイン済みユーザー：商品の閲覧・出品・購入が可能です。
- 未ログインユーザー：商品の閲覧が可能です。

## 目次

- [実装機能一覧](#実装機能一覧)
- [ER図](#er図)
- [環境構築手順](#環境構築手順)
- [プロジェクト設定](#プロジェクト設定)
- [使用技術](#使用技術)

### 実装機能一覧

- 会員登録画面
    - 新規会員登録機能
    - 会員登録後にプロフィール設定画面への遷移
    - ログイン画面への遷移
    - メール認証画面への遷移(応用)
- メール認証画面(応用)
    - 新規会員登録時のメール認証機能
    - メール認証再送機能
- ログイン画面
    - ログイン機能
    - 商品一覧画面への遷移
- ログアウト
    - セッション破棄・ログアウト機能
- 商品一覧画面
    - 商品一覧取得機能
    - マイリスト一覧取得機能
    - 商品検索機能
- 商品詳細画面
    - 商品詳細取得機能
    - いいね機能
    - コメント送信機能
    - 購入画面への遷移
- 商品購入画面
    - 購入前商品情報取得機能
    - 商品購入機能
    - 支払い方法選択機能
    - 配送先変更機能
- プロフィール画面
    - ユーザー情報取得機能
    - プロフィール編集画面への遷移
- プロフィール編集画面
    - ユーザー情報変更機能
- 商品出品画面
    - 出品商品情報登録機能
    - 出品商品画像アップロード機能

## ER図

![ER図](src/images/coachtech-fleamarket-app-er.drawio.png)

## 環境構築手順

**リポジトリをクローンした後、以下の手順でアプリケーションを起動してください。**

1.  依存パッケージのインストール
    Composerを使用してライブラリをインストールします。

    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        -e COMPOSER_CACHE_DIR=/tmp/composer_cache \
        laravelsail/php82-composer:latest \
        composer install
    ```

2.  環境変数の設定
    `.env.example`をコピーして`.env`を作成します。

    ```bash
        cp .env.example .env
    ```

        ※ 必要に応じて .env 内のデータベース設定が以下と一致しているか確認してください。

        ```bash
        DB_CONNECTION=mysql
        DB_HOST=mysql
        DB_PORT=3306
        DB_DATABASE=laravel
        DB_USERNAME=sail
        DB_PASSWORD=password
        ```

    <details>
    <summary><b>※推奨設定：エイリアスの登録</b></summary>

    `sail`コマンドを短縮して入力できるようにするため、エイリアスの設定を推奨します。
    これにより`./vendor/bin/sail`を毎回入力する手間が省けます。

    Zshの場合（macOS Catalina以降のデフォルト）

    ```bash
    echo "alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'" >> ~/.zshrc
    ```

    Bashの場合

    ```bash
    echo "alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'" >> ~/.bashrc
    ```

    設定を反映するために、シェルを再起動します。(ターミナルの再起動)

    ```bash
    exec $SHELL
    ```

    この設定により、以降`sail`コマンドだけでSailを実行できるようになります。

    ```bash
    # エイリアス設定前
    ./vendor/bin/sail up -d

    # エイリアス設定後
    sail up -d
    ```

    </details>

3.  アプリケーションキーの生成

    ```bash
    sail artisan key:generate
    ```

4.  Dockerコンテナの起動

    ```bash
    sail up -d
    ```

5.  データベースの構築
    テーブルを作成し、マイグレーションを実行します。

    ```bash
    sail artisan migrate
    ```

6.  フロントエンドの準備
    パッケージをインストールし、開発用ビルドを実行します。

    ```bash
    # パッケージのインストール
    sail npm install

    # 開発用ビルド（変更監視モード）
    sail npm run dev
    ```

7.  テストの実行とカバレッジの確認
    **テストの実行**
    開発中の機能が正常に動作しているかを確認するために、以下のコマンドでテストを実行できます。

    ```bash
    sail test
    ```

    **カバレッジの確認**

    ```bash
    sail test --coverage
    ```

## プロジェクト設定

本プロジェクトでは、日本国内での利用を想定し`config/app.php`にて以下の設定を行っています。

- タイムゾーン:`Asia/Tokyo`（日本標準時）
- 言語（ロケール）:`ja`（日本語）
- Fakerロケール:`ja_JP`（テストデータ生成時の日本語対応）

## 使用技術

### バックエンド

- PHP 8.2
- Laravel 10.x
- Laravel Fortify (認証)
- Laravel Lang (言語対応)

### データベース

- MySQL 8.0
- phpMyAdmin

### フロントエンド

- Tailwind CSS / Vite / Alpine.js

### 開発支援ツール

- **Docker / Laravel Sail:** 開発環境構築
- **Laravel Pint:** PHPコードスタイル校正
- **Prettier:** フロントエンドコード整形

**開発環境URL**: http://localhost

**作成者**: 乾 華菜
