# デプロイ手順

さくらレンタルサーバーへのデプロイは GitHub Actions で自動化しています（`.github/workflows/deploy.yml`）。
手作業での `yarn generate` や FTP アップロードは不要です。

## 仕組み

### デプロイが動くタイミング

| きっかけ | 動作 |
|---|---|
| `main` へのマージ（push） | ビルドしてデプロイ |
| microCMS でコンテンツを公開・更新・公開終了・削除 | ビルドしてデプロイ（microCMS の Webhook） |
| GitHub の画面から手動実行 | ビルドしてデプロイ。「お試し実行」も選べる |

### デプロイの中身

1. `yarn install` → `yarn generate`（APIキーは GitHub の Secrets から渡す）
2. ビルド結果の確認
   - `index.html` があるか
   - microCMS の記事が取れているか
   - APIキーが漏れていないか

   問題があればここで中止し、サーバーには何もアップロードしません。
3. rsync（SSH）でアップロード
   - **① 上書きアップロード**：`.output/public` の中身をすべてアップロードします。サーバー上のほかのファイルは削除しません。
     - `mail-config.php`（Turnstile のシークレット）は送りません。サーバー上のファイルを手で管理します。
   - **② サイト専用フォルダの掃除**：下のフォルダの中だけ、ビルド結果にないファイルを削除します。
     ```
     _nuxt _fonts __sitemap__ about business contact hearing-page
     news privacy products sitemap tokushoho
     ```
     `images/` など、ほかのフォルダには一切触れません。
4. 上書き・削除されたファイルは、サーバーの `~/deploy-backup/日時-コミットID/` に退避します。30日たつと自動で削除されます。

### 注意

- このリポジトリは公開（PUBLIC）なので、GitHub Actions のログも誰でも見られます。Secrets の値はログ上で伏せ字になりますが、ログに秘密情報を出力する変更はしないでください。
- 新しいページ（`pages/xxx.vue`）を追加したときは、`deploy.yml` の `MANAGED_DIRS` にもフォルダ名を追加してください。追加しなくてもアップロードはされます。ただし、そのフォルダでは古いファイルの削除が行われません。

---

## 初期設定

上から順番に進めてください。コマンドはすべて Windows の PowerShell で実行します。

### 1. さくらのSSH接続情報を調べる

さくらのコントロールパネルで、次の値を確認します。

| 項目 | 例 | 確認場所 |
|---|---|---|
| ホスト名 | `アカウント名.sakura.ne.jp` | コントロールパネルの「サーバー情報」、または契約時のメール「仮登録完了のお知らせ」 |
| ユーザー名 | `アカウント名` | 同上 |
| パスワード | サーバーパスワード | 同上（最初の接続でだけ使います） |
| 公開フォルダ | `~/www` | — |

### 2. デプロイ専用のSSH鍵を作る

```powershell
ssh-keygen -t ed25519 -C "github-actions-deploy" -f $HOME\.ssh\spice_deploy
```

- パスフレーズを聞かれたら、**何も入力せずに Enter を2回**押します。GitHub Actions が自動で使う鍵なので、パスフレーズは付けません。
- 次の2つのファイルができます。
  - `$HOME\.ssh\spice_deploy`：秘密鍵。GitHub に登録します。**ほかの人には渡さないでください。**
  - `$HOME\.ssh\spice_deploy.pub`：公開鍵。さくらに登録します。

### 3. 公開鍵をさくらに登録する

`アカウント名` は、手順1で調べた値に置き換えてください（以下同じ）。

```powershell
Get-Content $HOME\.ssh\spice_deploy.pub | ssh アカウント名@アカウント名.sakura.ne.jp "mkdir -p ~/.ssh && chmod 700 ~/.ssh && cat >> ~/.ssh/authorized_keys && chmod 600 ~/.ssh/authorized_keys"
```

- 初めて接続すると `Are you sure you want to continue connecting (yes/no)?` と聞かれます。`yes` と入力してください。
- パスワードを聞かれたら、サーバーパスワードを入力します。

### 4. 鍵で接続できるか確認する

```powershell
ssh -i $HOME\.ssh\spice_deploy アカウント名@アカウント名.sakura.ne.jp "cd ~/www && pwd && which rsync"
```

次のように、**パスワードを聞かれずに**2行表示されれば成功です。

```
/home/アカウント名/www
/usr/local/bin/rsync
```

- パスワードを聞かれる場合は、手順3がうまくいっていません。
- `rsync` が表示されない場合は、サーバーで rsync が使えません。この場合は自動デプロイができないので、相談してください。

### 5. サーバーの「本人確認情報」を取得する

GitHub Actions が、偽のサーバーにつながらないようにするための情報です。

```powershell
ssh-keyscan アカウント名.sakura.ne.jp 2>$null | Set-Content $HOME\.ssh\spice_known_hosts
Get-Content $HOME\.ssh\spice_known_hosts
```

`アカウント名.sakura.ne.jp ssh-ed25519 AAAA...` のような行が表示されます。この内容をすべて、手順6で `SSH_KNOWN_HOSTS` として登録します。

### 6. GitHub に Secrets を登録する

GitHub のリポジトリページ → **Settings** → **Secrets and variables** → **Actions** → **Secrets** タブ → **New repository secret** から、1つずつ登録します。

| Name | 値 |
|---|---|
| `MICROCMS_API_KEY` | `.env` の `MICROCMS_API_KEY` と同じ値 |
| `MICROCMS_SERVICE_DOMAIN` | `.env` の `MICROCMS_SERVICE_DOMAIN` と同じ値 |
| `TURNSTILE_SITE_KEY` | `.env` の `TURNSTILE_SITE_KEY` と同じ値 |
| `GTM_ID` | `.env` の `GTM_ID` と同じ値（省略可。省略すると `nuxt.config.ts` の既定値を使います） |
| `SSH_PRIVATE_KEY` | `$HOME\.ssh\spice_deploy`（`.pub` **ではない** ほう）の中身すべて。`-----BEGIN` から `-----END ... KEY-----` までを貼り付けます |
| `SSH_KNOWN_HOSTS` | 手順5で表示された内容すべて |
| `SSH_HOST` | `アカウント名.sakura.ne.jp` |
| `SSH_USER` | `アカウント名` |
| `DEPLOY_PATH` | `~/www` |

`TURNSTILE_SECRET_KEY` は登録しません。ビルドでは使わず、サーバー上の `mail-config.php` で管理しているためです。

GitHub CLI（`gh`）を使う場合は、次のコマンドで登録することもできます（例）。

```powershell
Get-Content -Raw $HOME\.ssh\spice_deploy | gh secret set SSH_PRIVATE_KEY
Get-Content -Raw $HOME\.ssh\spice_known_hosts | gh secret set SSH_KNOWN_HOSTS
gh secret set SSH_HOST --body "アカウント名.sakura.ne.jp"
```

### 7. お試し実行で確認する

リポジトリ変数 `DEPLOY_ENABLED` を `true` にするまでは、どのきっかけで動いても**お試し実行**になります。お試し実行では、サーバーは一切変更されません。

1. `deploy.yml` を `main` にマージします。自動でお試し実行が始まります。
2. GitHub の **Actions** タブ → **Deploy** → 最新の実行結果を開きます。
3. **Deploy to Sakura** のログを確認します。
   - `② サイト専用フォルダの不要ファイル削除` に、`*deleting` の行として削除予定のファイルが出ます。消えてはいけないファイルがないか確認してください（`business/test/` と `business/information/` が出ていれば正常です）。
   - `① 上書きアップロード` に `*deleting` の行は出ません（①では削除しないため）。
4. 接続でエラーになった場合は、下の「トラブルシューティング」を見てください。

### 8. 本番デプロイを有効にする

1. **Settings** → **Secrets and variables** → **Actions** → **Variables** タブ → **New repository variable** から登録します。
   - Name: `DEPLOY_ENABLED`
   - Value: `true`
2. **Actions** → **Deploy** → **Run workflow** を開きます。**「お試し実行」のチェックを外して**実行します。
3. 公開サイトを確認します。
   - トップ・新着情報・商品・事業ページに記事が表示される
   - `/business/test` が `/business/aireha/` に、`/business/information` が `/business/yutaka/` に転送される
   - `/contact` からテスト送信できる
   - `https://spice-web.jp/mail-config.php` が 403 になる

### 9. microCMS から自動デプロイする（Webhook）

#### 9-1. GitHub のトークンを作る

microCMS が GitHub Actions を起動するためのトークンです。

1. GitHub 右上のアイコン → **Settings** → **Developer settings** → **Personal access tokens** → **Fine-grained tokens** → **Generate new token** を開きます。
2. 次のように設定します。

   | 項目 | 設定 |
   |---|---|
   | Token name | `microcms-deploy` |
   | Resource owner | `spice-web` |
   | Expiration | 1年（期限が切れると microCMS からのデプロイが止まるので、更新日をカレンダーに入れておく） |
   | Repository access | **Only select repositories** → `spice_official_homepage` |
   | Permissions → Repository permissions | **Contents: Read and write**（ほかはすべて No access のまま） |

3. **Generate token** を押します。表示されたトークン（`github_pat_...`）をコピーします。**この画面を閉じると二度と表示されません。**

`spice-web` 組織の設定によっては、トークンに組織の管理者の承認が必要です。「Pending」と表示された場合は、組織の **Settings** → **Personal access tokens** → **Pending requests** から承認してください。

#### 9-2. microCMS に Webhook を登録する

API ごとに設定が必要です。`information`、`site-production`、`products` の3つすべてに、同じ設定をしてください。

1. microCMS の管理画面 → 対象の API → **API設定** → **Webhook** → **追加** → **GitHub Actions** を選びます。
2. 次のように入力します。

   | 項目 | 値 |
   |---|---|
   | 名前 | `自動デプロイ` |
   | GitHubトークン | 9-1 でコピーしたトークン |
   | ユーザー名 | `spice-web` |
   | リポジトリ名 | `spice_official_homepage` |
   | トリガーイベント名 | `microcms-update` |

3. 通知のタイミングは、次の項目をオンにします。
   - コンテンツの公開時・更新時
   - コンテンツの公開終了時
   - 公開中コンテンツの削除時

   下書きの保存はオフのままにしてください（公開サイトに関係しないため）。
4. 試しに記事を1件更新し、GitHub の **Actions** タブで Deploy が動くことを確認します。

---

## 普段の運用

| やりたいこと | 方法 |
|---|---|
| コードの変更を公開 | `develop` で作業 → `main` にマージ |
| microCMS の記事を公開 | microCMS で公開するだけ（数分で反映） |
| 今すぐ作り直したい | Actions → Deploy → Run workflow（お試し実行のチェックを外す） |
| 自動デプロイを一時的に止めたい | 変数 `DEPLOY_ENABLED` を `false` にする（以後はお試し実行になる） |
| Turnstile のシークレットを変えたい | サーバー上の `mail-config.php` を直接書き換える（自動デプロイでは上書きされない） |

### 元に戻したいとき

- **コードが原因の場合**：`main` で該当のコミットを revert してマージします。直前の状態で作り直されます。
- **ファイル単位で戻したい場合**：サーバーの `~/deploy-backup/日時-コミットID/` に、上書き・削除される前のファイルがあります。SSH でコピーして戻してください。

---

## トラブルシューティング

### `Check build output` で失敗する

- `microCMS の記事が取得できていません`：Secrets の `MICROCMS_API_KEY` / `MICROCMS_SERVICE_DOMAIN` が正しいか確認します。microCMS で APIキーを作り直した場合は、Secrets も更新してください。
- `APIキーが含まれています`：コードのどこかで APIキーをブラウザ側に渡しています。`nuxt.config.ts` の `runtimeConfig.public` を確認してください。

### `Deploy to Sakura` で失敗する

- `Permission denied (publickey)`：`SSH_PRIVATE_KEY` の内容が正しくないか、さくらに公開鍵が登録されていません。手順3・4・6を見直してください。
- `Host key verification failed`：`SSH_KNOWN_HOSTS` が正しくありません。手順5をやり直してください。
- `Connection timed out`：さくらのコントロールパネル → **セキュリティ** → **国外IPアドレスフィルタ** など、海外からのアクセス制限を確認してください。GitHub Actions は海外のサーバーで動いています。
- `DEPLOY_PATH が不正です`：`DEPLOY_PATH` が空、またはホームフォルダそのものを指しています。`~/www` になっているか確認してください。

### microCMS で更新しても反映されない

- GitHub の Actions タブに Deploy の実行が出ていない場合：
  - 9-1 のトークンの期限切れ、または権限不足
  - 9-2 のトリガーイベント名の誤り（`microcms-update` でないと起動しません）
- 実行されているのにお試し実行になっている場合：変数 `DEPLOY_ENABLED` が `true` か確認してください。

### メールが届かない

`EMAIL-TROUBLESHOOTING.md` を参照してください。
