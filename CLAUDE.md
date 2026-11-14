# CLAUDE.md

このファイルは、このリポジトリ(laravel-ddd-template)で作業する AI への指針を定める。

## このリポジトリの役割

- DDD の参考実装(骨組み)。基盤クラスは、Composer パッケージ `bit-craft-io/laravel-ddd-core`(名前空間 `BitCraft\Core\`)を使う。
- 案件(`aidd-project`)は、このリポジトリから作る。案件固有のものは、案件側に足す。
- 基盤クラス(`Base*`、Middleware、Libraries)は、ここに置かない。直す必要があるときは、core のリポジトリで直す。
- `Domains/Item` などの Vo、Vp、Ent は、動作確認用のサンプル。案件には持ち込まない。
- アカウントとユーザ(`Account`、`User`)は、core が持つ。template には、置かない(core の `CLAUDE.md` の「アカウントとユーザ」)。

## 対応バージョン

- PHP は 8.5.12 以上(必須)、Laravel は 13 系。
- バージョンの正は `composer.json` と `docker/` 配下の Dockerfile(PHP、MySQL、Redis、Node)。
- 公式で確認できない仕様は断定せず、「未確認」と書いて報告する。

## core の取得

- core は、サブモジュール `submodules/laravel-ddd-core`(`.gitmodules` で管理)として置く。
- Composer は、path repository(`submodules/laravel-ddd-core`、`symlink: true`)で参照する。`composer.json` では `@dev` で要求する。
- core のバージョンは、サブモジュールの指すコミットで固定する(タグ名ではなく、コミットのハッシュが記録される)。
- core を更新するときは、サブモジュールのコミットを切り替えて、親リポジトリでコミットする。

```bash
git -C submodules/laravel-ddd-core fetch origin
```

```bash
git -C submodules/laravel-ddd-core checkout <コミットまたはタグ>
```

```bash
git add submodules/laravel-ddd-core
```

- clone するときは、サブモジュールも取得する。

```bash
git clone --recurse-submodules <URL>
```

- Composer は、コンテナ内で実行する(ホストに PHP と Composer は入れない)。
- core の規約の正は、core の `CLAUDE.md`(`submodules/laravel-ddd-core/CLAUDE.md`)とする。ここには、利用側が守ることだけを書く。

## 開発環境

- `docker compose` は、`docker/` ディレクトリで実行する(compose ファイルがあるため)。
- `docker/.env` の `COMPOSE_PROJECT_NAME` と `__WSL_COMPOSE_PROJECT_DIR` を、環境に合わせる。draft など、ほかのプロジェクトと値を重ねない。
- コンテナ内の作業ディレクトリは `/var/www/source`。

```bash
docker compose exec -e XDEBUG_MODE=off app composer update
```

## 設計方針

- 流れ: routes → Middleware → Controller(`Cnt*`、薄く保つ) → App/UseCase(`App*`) → Repository(`Rep*`) → Entity/Vo/Vp(`Ent*`、`Vo*`、`VoM*`、`Vp*`) → DataSource(`Ds*`) → Eloquent Model。
- Hub クラス(`*Hub`)に、クラス名の定数を持たせる。参照は `_Domain::rep(RepHub::X)` のように、Trait 経由の静的な呼び出しで行う。
- コンストラクタを使わない。クラスはコンテナ(`StfStaFactory`)で生成し、`init()` で初期化する。
- トランザクションとレスポンスは、ミドルウェア(`mdl.transaction`、`mdl.response`)が制御する。
- 例外は、`ExceptApp`(422)、`ExceptModel`(404)、それ以外(401)として描画される(core の `StlStaBootstrap::exceptions()`)。
- ServiceProvider でのコンテナ登録はしない。結びつけは、登録ではなく、命名規約(下記)で行う。

## 命名

- 接頭辞を守る: `Ent`、`Vo`、`Vp`、`Rep`、`Ds`、`Svc`、`App`、`Cnt`、`Req`、`Res`、`Mdl`、`Stl*`(状態なし・静的)、`Stf*`(状態あり・静的)、`Trait*`。
- interface は `I`、trait は `Trait`、基底クラスは `Base` で始める。

## core との約束(利用側が守ること)

| No | ルール | 内容 |
|---|---|---|
| R1 | `VoM{名前}` と `DsHub` | マスタ用 Vo `VoM{名前}` は、`App\DataSources\DsHub` の定数 `DS_M_{名前}`(大文字・スネークケース)に対応させる |
| R2 | `Ds{名前}` と `{名前}` | `App\DataSources\Ds{名前}` は、モデル `App\Models\{名前}` を使う |
| R3 | `DsHub` への登録 | データソースのクラス名を、`DsHub` の定数(`DS_M_*`、`DS_U_*`)に登録する |
| R4 | コンテナへの登録 | コンテナへの登録は、core の `StfStaFactory` だけが行う。ServiceProvider で登録しない |
| R5 | 設定 `core` | `config/core.php` は任意。書いたキーだけが、core の既定値を上書きする。`null` を明示すると既定値を上書きするので、書かない |
| R6 | `bootstrap/app.php` | 別名は `...StlStaBootstrap::aliases()` を展開して固有を足す(`Middleware::alias()` は置換のため、2回呼ばない)。固有の例外描画は、`StlStaBootstrap::exceptions()` より先に登録する |

- 利用側が用意するもの: `DsHub`、ログ用モデル `App\Models\LogAccessInfo`(接続 `log_db`)、例外コードの enum(`TypeExcept{領域}`)。
- 名前空間は `App\` 固定とする(core が参照するため)。

## 例外コード

- コードは8桁の数値 `TT DDD NNN`。`TT`(種別)は core が定義する。`TT=20`(アプリ)は、利用側が管理する。
- enum は `App\Exceptions\Enum\TypeExcept{領域}` に置く。1つの enum は、1つの `(TT, DDD)` だけを持つ。`ITypeExcept` を実装する。
- ケース名は `{種別}{領域}{内容}`(例: `AppGachaExecCountOver`)。短縮しない。
- 検査(ルールは、core の `CLAUDE.md` の「例外コードの体系」を参照)。

```bash
docker compose exec app vendor/bin/except-code-check app/Exceptions/Enum 'App\Exceptions\Enum'
```

- コードや enum を追加したら、実行する。
- 引数のディレクトリが存在しなくても、エラーにならない(core の既知の課題)。ディレクトリの有無は、自分で確認する。

## コマンド

- コマンドは `docker/` で `make` を実行して選ぶ(メインメニュー → サブメニュー。番号で選び、右側に説明が出る)。

```bash
make
```

- グループは `docker/Makefile` の `include make.d/<名前>.mk` で決まる。タスクと説明は、各 `.mk` の `TASKS += \`(`タスク名:説明`)に書く。グループの説明は `# GROUP:` に書く。
- 実行すると、見出しに、直接実行できる `make` の1行(選択や入力の結果を含む)が、`>>> command: make ...` と表示される(`docker/` で実行する)。次回は、この1行をそのまま実行すれば、メニューを開かずに済む。他のタスクから呼ばれた内側のタスクには、`command` の行は出ない。
- タスク名は、グループ名で始める(例: `core-update`)。
- 説明の書き方: グループは「〇〇の操作」、タスクは「〇〇を〜する」(句点なし)。動詞は、起動する / 停止する / 表示する / 実行する / 作成する / 削除する / 初期化する / 更新する / 確認する / 切り替える / 取得する から選ぶ。外来語はカタカナ、かっこは全角、入力や選択が要るものは末尾に `（入力あり）` `（選択あり）`。
- 引数が要るタスクは、メニューから選ぶだけで済むようにする。引数は、①個別のタスクにして不要にする、②番号で候補から選ぶ(`choose.sh`)、③自由入力(`ask.sh`)の順で考える。変数(`CORE_REF`、`DB_NAME`、`ARGS`)を指定すると、質問を飛ばす。

```bash
make core-update CORE_REF=develop
```

| グループ | 内容 |
|---|---|
| `docker` | コンテナの起動・停止、`docker-mount-check`(mount 元の一致と、コンテナから core が見えるかの確認) |
| `app` | 初期化、キャッシュ削除、`app-legacy-check`(旧記述の残りの検出) |
| `core` | サブモジュールの取得、状態、切り替え(`core-update`) |
| `php` | コーディング規約、静的解析、例外コードの検査(`php-check`、`php-except`) |
| `test` | テスト(規約・静的解析とは分ける) |
| `composer`、`artisan` | よく使う操作と、任意のコマンド(`*-run`) |
| `migrate`、`job` | マイグレーション、seeder、キュー |

## IDE(PhpStorm)

- PHP のインタープリターは、Docker(コンテナ)を指定する。
- `submodules/laravel-ddd-core/tests` を、除外に設定する(core のテスト用の `App\...` が、本物と重複するため)。

## 共通の方針

- 認証情報(API キー、パスワード、秘密鍵、`.env` の実値)を、リポジトリ、issue、PR、ログ、プロンプトに入れない。入れてしまったら、作業を止めて報告する。
- 課金が発生する API の呼び出しなど、確認が要る操作は、実行前に人に確認する。
- 本番環境を変える操作は、人の確認なしに実行しない。
- Git / GitHub の運用は `.claude/rules/git.md` に従う。操作は `/git` スキル(`.claude/skills/git/`)で行う。
- マージ、push、ブランチの削除など、取り消しにくい操作は、実行前に確認する。

## 未決事項

- 開発補助(`StlStaDevelopTool`、`TraitDevelop`、設定 `develop`)の扱い。core の未決事項と連動する。
- 本番と CI での、サブモジュールの取得(SSH の鍵の渡し方)。
