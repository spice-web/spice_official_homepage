# デプロイ手順

## 1. 静的ファイル生成

```bash
# 本番用に環境変数を設定
# .envファイルが正しく設定されているか確認

# 静的ファイルを生成
yarn generate
```

生成されたファイルは `.output/public/` に出力されます。

## 2. 生成ファイルの確認

```bash
# Windows
explorer .output/public

# 確認すべき内容:
# - index.html
# - _nuxt/ (JavaScriptとCSS)
# - 各ページのHTML
# - public/ 配下のファイル (images/, contact-mail.php等)
```

## 3. サーバーへのアップロード

### 方法A: FTPでアップロード (推奨)

**FileZillaなどのFTPクライアントを使用:**

1. `.output/public/` の**中身**をすべて選択
2. サーバーの `public_html/` (またはドキュメントルート) にアップロード
3. 既存ファイルとの重複確認:
   - `contact-mail.php` - 上書き
   - `images/` - マージ（既存ファイルを保持）
   - その他既存ファイル - 必要に応じて保持

**重要な注意点:**
- `.output/public/` **フォルダごと**ではなく、**中身**をアップロード
- `_nuxt/` フォルダは完全に上書きしてOK（Nuxtの生成ファイル）
- `images/` 等の既存ディレクトリは慎重にマージ

### 方法B: rsyncでアップロード (上級者向け)

```bash
# サーバーにSSHアクセスできる場合
rsync -avz --delete-after \
  --exclude 'old-data/' \
  --exclude 'backup/' \
  .output/public/ \
  user@spice-web.jp:/home/user/public_html/
```

## 4. アップロード後の確認

### チェックリスト:

- [ ] トップページが表示される
- [ ] すべてのページが正しく表示される
- [ ] 画像が正しく表示される
- [ ] お問い合わせフォームが動作する
- [ ] PHPファイルが正しく動作する
- [ ] Turnstileが表示される
- [ ] GTMが動作している（開発者ツールで確認）
- [ ] microCMSのデータが表示される

### ブラウザキャッシュのクリア:

新しいファイルが表示されない場合:
```
Ctrl + Shift + R (Windows)
Cmd + Shift + R (Mac)
```

## 5. トラブルシューティング

### PHPファイルが動作しない

- サーバーのPHPバージョンを確認
- ファイルのパーミッションを確認（644または755）
- エラーログを確認

### 既存の画像が表示されない

- `public/images/` に既存画像を配置してから再度 `yarn generate`
- または、FTPで既存の `images/` フォルダをマージ

### CSSやJSが反映されない

- `_nuxt/` フォルダを完全に上書き
- ブラウザキャッシュをクリア
- サーバーのキャッシュをクリア（.htaccess等）

## 6. 既存ファイルとの共存

### 既存ファイルを保護する方法:

1. **publicディレクトリに配置:**
   ```
   public/
   ├── old-assets/      # 既存のファイル
   ├── pdf/             # PDFファイル等
   └── downloads/       # ダウンロードファイル
   ```

2. **再生成:**
   ```bash
   yarn generate
   ```

3. **アップロード:**
   `.output/public/` の中身がそのまま既存ファイルも含まれる

## 7. .htaccessの設定 (必要に応じて)

Nuxtは自動的にクリーンURLを生成しますが、サーバー側で設定が必要な場合があります:

```apache
# .htaccess (public_html/.htaccess)

# PHPの設定
<IfModule mod_php.c>
  php_value upload_max_filesize 10M
  php_value post_max_size 10M
</IfModule>

# セキュリティヘッダー
<IfModule mod_headers.c>
  Header set X-Content-Type-Options "nosniff"
  Header set X-Frame-Options "SAMEORIGIN"
  Header set X-XSS-Protection "1; mode=block"
</IfModule>

# エラーページ (オプション)
ErrorDocument 404 /404.html
```

## 8. 定期的な更新フロー

```bash
# 1. コンテンツを更新
# 2. 生成
yarn generate

# 3. テスト
yarn preview

# 4. アップロード
# FTPまたはrsyncで .output/public/ の中身をアップロード
```
