# メール送信トラブルシューティングガイド

## 実装完了内容

### ✅ 完了した対応

1. **サンクスページの作成**
   - `/contact/thanks` - お問い合わせ送信完了ページ
   - 送信成功時に自動リダイレクト

2. **メール送信の改善**
   - Fromアドレスをサーバードメインに変更 (`no-reply@spice-web.jp`)
   - Reply-Toで送信者のメールアドレスを設定
   - mb_language, mb_internal_encodingの設定追加
   - エラーログの追加

3. **自動返信メールの改善**
   - 会社情報を含む丁寧な自動返信
   - エラーログの追加

## メールが届かない場合の確認手順

### 1. テストメール送信

```bash
# ブラウザで以下にアクセス
https://spice-web.jp/test-mail.php
```

「テストメールを送信」ボタンをクリックして、メールが届くか確認してください。

**⚠️ 重要: テスト完了後は必ず `test-mail.php` を削除してください！**

### 2. 迷惑メールフォルダの確認

メールクライアントの迷惑メールフォルダを確認してください：
- Gmail: 「迷惑メール」フォルダ
- Outlook: 「迷惑メール」フォルダ
- その他: スパムフォルダ

### 3. メールサーバーのログ確認

さくらレンタルサーバーの場合：
1. サーバーコントロールパネルにログイン
2. 「ログ」→「エラーログ」を確認
3. メール送信に関するエラーを探す

### 4. DNS設定の確認（SPFレコード）

#### SPFレコードとは

SPF（Sender Policy Framework）は、メールの送信元を認証する仕組みです。

#### 設定方法（さくらインターネット）

1. サーバーコントロールパネルにログイン
2. 「ドメイン/SSL」→「ドメイン設定」
3. 対象ドメイン（spice-web.jp）の「詳細」
4. 「DNS」タブ
5. 以下のSPFレコードを追加:

```
種別: TXT
名前: @
値: v=spf1 a:www<サーバー番号>.sakura.ne.jp mx ~all
```

例:
```
v=spf1 a:www512.sakura.ne.jp mx ~all
```

**設定反映まで数時間〜24時間かかる場合があります。**

### 5. DKIM設定（推奨）

DKIM（DomainKeys Identified Mail）も設定するとより確実です。

さくらレンタルサーバーでは、メールボックス設定から有効化できます。

## よくある問題と解決方法

### 問題1: 管理者にも送信者にもメールが届かない

**原因:**
- PHPのmail関数が動作していない
- サーバーのメール送信制限

**解決方法:**
1. `test-mail.php` で送信テスト
2. エラーログを確認
3. サーバー会社に問い合わせ

### 問題2: 管理者には届くが、送信者に自動返信が届かない

**原因:**
- 送信者のメールアドレスが無効
- 送信者側の迷惑メール設定

**解決方法:**
1. 送信者のメールアドレスが正しいか確認
2. 迷惑メールフォルダを確認
3. SPF/DKIM設定

### 問題3: 迷惑メールに入る

**原因:**
- SPFレコードが未設定
- DKIMが未設定
- 送信元ドメインとFromアドレスの不一致

**解決方法:**
1. SPFレコードを設定（上記参照）
2. DKIMを有効化
3. Fromアドレスが `@spice-web.jp` であることを確認

### 問題4: さくらレンタルサーバーで送信制限に引っかかる

**制限:**
- 1時間あたり約200通
- 1日あたり約2,000通

**解決方法:**
1. 送信数を確認
2. 必要に応じてプラン変更
3. 外部SMTPサービスの利用（SendGrid, Amazon SES等）

## 外部SMTPサービスの利用（上級者向け）

確実にメールを送信したい場合は、外部SMTPサービスの利用を検討してください。

### 推奨サービス

1. **SendGrid**
   - 無料プラン: 1日100通
   - 信頼性が高い

2. **Amazon SES**
   - 低コスト
   - AWS環境と連携

3. **Mailgun**
   - 開発者向け
   - 詳細なログ

### PHPMailerの使用例

```php
// PHPMailerをインストール
// composer require phpmailer/phpmailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // SMTPサーバー設定
    $mail->isSMTP();
    $mail->Host       = 'smtp.sendgrid.net';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'apikey';
    $mail->Password   = 'YOUR_SENDGRID_API_KEY';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // 送信元・送信先
    $mail->setFrom('no-reply@spice-web.jp', '株式会社SPICE');
    $mail->addAddress($to);
    $mail->addReplyTo($data['email'], $data['name']);

    // 内容
    $mail->CharSet = 'UTF-8';
    $mail->Subject = $subject;
    $mail->Body    = $message;

    $mail->send();
} catch (Exception $e) {
    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
}
```

## 確認チェックリスト

送信前に以下を確認してください：

- [ ] `test-mail.php` でテストメールが送信できる
- [ ] 迷惑メールフォルダを確認済み
- [ ] SPFレコードを設定済み（または設定予定）
- [ ] contact-mail.phpのFromアドレスが `no-reply@spice-web.jp`
- [ ] contact-mail.phpの送信先が正しい（info@spice-web.jp）
- [ ] サーバーのエラーログを確認済み
- [ ] TURNSTILE_SECRET_KEYが環境変数に設定済み

## サポート

メール送信がうまくいかない場合は、以下の情報を添えてサーバー会社に問い合わせてください：

1. エラーログの内容
2. test-mail.phpの実行結果
3. 使用しているPHPバージョン
4. メール送信関数（mb_send_mail）が利用可能か

---

**最終更新: 2025年**
