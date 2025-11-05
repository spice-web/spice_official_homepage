# クイックデプロイガイド

## 📦 デプロイ手順（簡易版）

### 1. 静的ファイル生成

```bash
yarn generate
```

### 2. アップロードするファイル

`.output/public/` の **中身全て** をサーバーにアップロード：

```
必須ファイル:
✓ _nuxt/                  # 完全に上書き（古いファイルは削除）
✓ index.html
✓ about/index.html
✓ business/index.html
✓ contact/index.html
✓ contact/thanks/index.html  # 新規
✓ news/index.html
✓ privacy/index.html
✓ sitemap/index.html
✓ tokushoho/index.html
✓ contact-mail.php        # 更新済み
✓ .htaccess               # 新規（環境変数設定）
✓ favicon.ico
✓ images/                 # 既存とマージ

テスト用（テスト後削除）:
✓ test-mail.php
✓ test-turnstile.php
```

### 3. アップロード方法（FTP）

1. FileZillaなどのFTPクライアントを起動
2. サーバーに接続
3. `.output/public/` フォルダを開く
4. **中身全て**を選択
5. サーバーの `public_html/` にドラッグ&ドロップ
6. 「上書きしますか？」→「全て上書き」を選択

### 4. 動作確認

#### ✅ チェック1: サイトの表示
```
https://spice-web.jp/
https://spice-web.jp/contact
https://spice-web.jp/contact/thanks
```

#### ✅ チェック2: Turnstileテスト
```
https://spice-web.jp/test-turnstile.php
```

**確認項目:**
- [ ] TURNSTILE_SITE_KEY: ✓ 設定済み
- [ ] TURNSTILE_SECRET_KEY: ✓ 設定済み
- [ ] Turnstileウィジェットが表示される
- [ ] チェックボックスをクリックできる
- [ ] 「テスト送信」で検証成功

#### ✅ チェック3: メールテスト
```
https://spice-web.jp/test-mail.php
```

**確認項目:**
- [ ] テストメールが送信できる
- [ ] メールが届く

#### ✅ チェック4: お問い合わせフォーム
```
https://spice-web.jp/contact
```

**テスト手順:**
1. 全項目を入力
2. Turnstileにチェック（✓ セキュリティ認証完了 と表示）
3. 送信ボタンをクリック
4. サンクスページにリダイレクト
5. 管理者にメールが届く
6. 送信者に自動返信メールが届く

### 5. テストファイルの削除

動作確認が完了したら、以下のファイルを削除：

```
test-mail.php
test-turnstile.php
```

FTPで削除するか、サーバーのファイルマネージャーから削除してください。

## 🚨 トラブルシューティング

### 問題1: Turnstileが「未設定」と表示される

**原因:** .htaccessが正しく読み込まれていない

**解決方法:**
1. `.htaccess`がアップロードされているか確認
2. ファイル名が正しいか確認（先頭のドット`.`が必要）
3. contact-mail.phpの4-6行目で直接設定しているため、基本的には動作するはず

### 問題2: メールが届かない

**確認:**
1. test-mail.phpでテストメール送信
2. 迷惑メールフォルダを確認
3. SPFレコードの設定（EMAIL-TROUBLESHOOTING.md参照）

### 問題3: 「セキュリティ認証を完了してください」エラー

**確認:**
1. ブラウザのコンソールログを確認（F12キー）
2. test-turnstile.phpでTurnstileの動作確認
3. ページを再読み込み（Ctrl+Shift+R）

### 問題4: CSSやJSが反映されない

**解決方法:**
1. `_nuxt/`フォルダを完全に削除してから再アップロード
2. ブラウザのキャッシュをクリア（Ctrl+Shift+R）
3. サーバーのキャッシュをクリア

## 📝 定期更新の流れ

```bash
# 1. コンテンツを編集
# 2. 生成
yarn generate

# 3. プレビュー（オプション）
yarn preview

# 4. アップロード
# .output/public/ の中身全てをFTPでアップロード

# 5. 動作確認
# サイトをブラウザで確認
```

## 💡 よくある質問

**Q: 毎回全ファイルをアップロードする必要がありますか？**
A: `_nuxt/`フォルダは毎回完全に置き換える必要があります。HTMLファイルも基本的に全て上書きを推奨します。

**Q: 画像フォルダはどうすればいいですか？**
A: 既存の画像を保持したまま、新しい画像だけ追加してください。

**Q: .htaccessは毎回アップロードが必要ですか？**
A: 初回のみで大丈夫です。ただし、変更した場合は再アップロードしてください。

**Q: contact-mail.phpだけ修正した場合は？**
A: contact-mail.phpのみアップロードで大丈夫です。

---

**詳細な情報は DEPLOY.md を参照してください。**
