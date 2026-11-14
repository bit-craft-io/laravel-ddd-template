# laravel-ddd-template

（作業中）DDD の参考実装(骨組み)を提供する、Laravel 向けのテンプレート。基盤クラスは、Composer パッケージ [laravel-ddd-core](https://github.com/bit-craft-io/laravel-ddd-core) を使う。

## 概要

- 実務で得た経験を基に、設計思想を整理・発展させたリポジトリです。<br />
  再利用性と責務分離を Laravel とドメイン駆動設計(DDD)で実現してます。
- This repository is a part of my professional portfolio, <br>
  demonstrating my learning process and technical skills in software development.
- 基盤クラス(`Base*`、Middleware、Libraries)は、このリポジトリに置かない。core に置く。
- 案件は、このリポジトリから作る。案件固有のものは、案件側に足す。
- `Domains/Item` などの Vo、Vp、Ent は、動作確認用のサンプル。案件には持ち込まない。

## 要件

- PHP 8.5.12 以上
- Laravel 13 系(`^13.0`)、Laravel Sanctum 4 系
- Docker(PHP 8.5、MySQL 8.0、Redis 7.0、Node 20)

バージョンの正は、`composer.json` と `docker/` 配下の Dockerfile。

## 導入

core は、サブモジュール `submodules/laravel-ddd-core` として置く。clone するときは、サブモジュールも取得する。

```bash
git clone --recurse-submodules <URL>
```

Composer と PHP は、コンテナ内で実行する(ホストには入れない)。`docker/` ディレクトリで、`make` を実行すると、メニューからコマンドを選べる。

```bash
cd docker
make
```

主なタスク:

| グループ | 内容 |
|---|---|
| `docker` | コンテナの起動・停止(`docker-up`、`docker-down`) |
| `app` | 初期設定、キャッシュ削除(`app-init`、`app-clean`) |
| `core` | core の取得、状態、切り替え(`core-init`、`core-status`、`core-update`) |
| `migrate` | マイグレーション、シーダー(`migrate-all`、`migrate-seeder-dev`) |
| `php` | 規約、静的解析、例外コードの検査(`php-check`、`php-stan`、`php-except`) |
| `test` | テスト(`test-all`) |

`docker/.env` の `COMPOSE_PROJECT_NAME` と `__WSL_COMPOSE_PROJECT_DIR` は、環境に合わせる。詳細は [CLAUDE.md](CLAUDE.md) を参照。

## ディレクトリ構成

```
app/                           # アプリケーション(利用側)
├── DataSources/               # インフラ層（データソース）、DsHub
├── Domains/                   # ドメイン層
│ └── (Rep, Ent, Vo, Vp)/      # 各ドメインクラス
├── Exceptions/
│ └── Enum/                    # 例外コード(TypeExcept{領域})
├── Http/                      # API
│ ├── Applications/            # ユースケース
│ ├── Controllers/             # プレゼンテーション層
│ ├── Requests/                # バリデーション定義
│ ├── Responses/               # APIレスポンス
│ └── Services/                # ドメインサービス(Svc)
├── Models/                    # インフラ層（モデル）
│ ├── Enum/                    # インフラ層（タイプ）
│ └── (Model)/                 # 各モデルクラス
└── Providers/                 # サービスプロバイダ

submodules/
└── laravel-ddd-core/          # システム基盤(BitCraft\Core\)
```

core の構成(`DataSources`、`Domains`、`Exceptions`、`Http`、`Libraries`)は、[laravel-ddd-core](https://github.com/bit-craft-io/laravel-ddd-core) の README を参照。

## 設計思想

- コードは「責務」で整理
- ドメイン層はビジネスルールを自然言語化して構築（ユビキタス言語）
- システム基盤は抽象構造で設計
- 他人が見て「なるべく迷わない」命名を心がける

## 特徴・ポイント

1. **DataSources を経由して ORM(Model) を操作**
    - インフラ層の責務を DataSources に集約
    - ドメイン層は DB や ORM の存在を意識せず、ビジネスロジックに専念できる
2. **Entity の集合を Iterator で表現**
    - Collection クラスを使わず、Iterator による軽量な疑似 Collection として管理
    - メモリ効率を意識した設計
3. **ValueObject の集合を Iterator で表現**
    - Collection クラスを使わず、Iterator による軽量な疑似 Collection として管理
    - メモリ効率を意識した設計
4. **ValueProxy は Mutable な ValueObject**
    - ValueObject が Immutable に対し、内部状態を更新可能にしたクラス
5. **Transaction の commit や rollback は Middleware で制御**
   - 都度、try-catch を記述せず Middleware で処理
6. **API の Response は Middleware で制御**
   - 共通もしくは個別のレスポンスの型で返す<br />
     ※トランザクションの処理後はスレーブ参照にする為<br />
     　config.database.connections.{db}.sticky = true

## 使用技術

- Laravel(PHP 8.5)
- Docker(MySQL, Redis)
- AWS(EC2, RDS, Valkey)

## その他

- コミットログの内容は割愛してます

## ライセンス

[MIT](LICENSE)
