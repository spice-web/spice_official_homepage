<?php
// Turnstile設定（本番環境用）
// セキュリティ上、本番では.htaccessでの設定を推奨
if (!getenv('TURNSTILE_SECRET_KEY')) {
  putenv('TURNSTILE_SECRET_KEY=0x4AAAAAAB7-ioGVAAJlNweQS_P_fiLzd60');
}

// .envファイルから環境変数を読み込む（開発環境用）
if (file_exists(__DIR__ . '/../.env')) {
  $envFile = file_get_contents(__DIR__ . '/../.env');
  $lines = explode("\n", $envFile);
  foreach ($lines as $line) {
    $line = trim($line);
    if (empty($line) || strpos($line, '#') === 0) {
      continue;
    }
    if (strpos($line, '=') !== false) {
      list($key, $value) = explode('=', $line, 2);
      $key = trim($key);
      $value = trim($value);
      if (!getenv($key)) {
        putenv("$key=$value");
      }
    }
  }
}

// ヘッダー設定（CORS対応）
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// プリフライトリクエスト対応
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

// POSTリクエストのみ許可
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
  exit;
}

// 入力データの取得
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// エラー配列
$errors = [];

// 必須項目チェック
$required_fields = [
  'name' => 'お名前',
  'kana' => 'ふりがな',
  'email' => 'メールアドレス',
  'phone' => '電話番号',
  'subject' => '件名',
  'inquiryType' => 'ご用件',
  'message' => 'お問い合わせ内容',
  'privacyAgreed' => 'プライバシーポリシーへの同意'
];

foreach ($required_fields as $field => $label) {
  if (empty($data[$field])) {
    $errors[] = "{$label}は必須です。";
  }
}

// メールアドレス形式チェック
if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'メールアドレスの形式が正しくありません。';
}

// URLチェック
if (!empty($data['message']) && preg_match('/https?:\/\//', $data['message'])) {
  $errors[] = 'お問い合わせ内容にURLを含めることはできません。';
}

// 日本語チェック
if (!empty($data['message']) && !preg_match('/[ぁ-んァ-ヶー一-龠]/u', $data['message'])) {
  $errors[] = 'お問い合わせ内容には日本語を含めてください。';
}

// プライバシーポリシー同意チェック
if (empty($data['privacyAgreed']) || $data['privacyAgreed'] !== true) {
  $errors[] = 'プライバシーポリシーに同意してください。';
}

// Cloudflare Turnstile検証
if (empty($data['turnstileToken'])) {
  $errors[] = 'セキュリティ認証トークンが必要です。';
  error_log('Turnstile token is empty');
} else {
  // Turnstileシークレットキーを環境変数から取得
  $turnstileSecret = getenv('TURNSTILE_SECRET_KEY');

  if ($turnstileSecret) {
    // Turnstile検証API呼び出し
    $verifyUrl = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
    $verifyData = [
      'secret' => $turnstileSecret,
      'response' => $data['turnstileToken'],
      'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = [
      'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => http_build_query($verifyData)
      ]
    ];

    $context = stream_context_create($options);
    $verifyResponse = @file_get_contents($verifyUrl, false, $context);

    if ($verifyResponse === false) {
      error_log('Failed to connect to Turnstile API');
      $errors[] = 'セキュリティ認証の検証に失敗しました。ネットワーク接続を確認してください。';
    } else {
      $verifyResult = json_decode($verifyResponse, true);
      error_log('Turnstile API response: ' . print_r($verifyResult, true));

      if (!$verifyResult['success']) {
        $errorCodes = isset($verifyResult['error-codes']) ? implode(', ', $verifyResult['error-codes']) : 'unknown';
        error_log('Turnstile verification failed: ' . $errorCodes);
        $errors[] = 'セキュリティ認証に失敗しました。もう一度お試しください。';
      }
    }
  } else {
    error_log('TURNSTILE_SECRET_KEY not set in environment variables');
    $errors[] = 'サーバー設定エラーが発生しました。（Turnstileシークレットキーが未設定）';
  }
}

// エラーがある場合
if (!empty($errors)) {
  http_response_code(400);
  echo json_encode([
    'success' => false,
    'message' => 'バリデーションエラー',
    'errors' => $errors
  ]);
  exit;
}

// メール設定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to = 'info@spice-web.jp'; // 送信先メールアドレス（適切なアドレスに変更してください）
$subject = '【お問い合わせ】' . $data['subject'];

// メール本文作成
$message = "お問い合わせがありました。\n\n";
$message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
$message .= "お名前: " . $data['name'] . "\n";
$message .= "ふりがな: " . $data['kana'] . "\n";
$message .= "メールアドレス: " . $data['email'] . "\n";

// 任意項目（郵便番号・住所）
if (!empty($data['postal'])) {
  $message .= "郵便番号: " . $data['postal'] . "\n";
}
if (!empty($data['address'])) {
  $message .= "住所: " . $data['address'] . "\n";
}

$message .= "電話番号: " . $data['phone'] . "\n";
$message .= "件名: " . $data['subject'] . "\n";
$message .= "ご用件: " . $data['inquiryType'] . "\n";
$message .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";
$message .= "【お問い合わせ内容】\n";
$message .= $data['message'] . "\n\n";
$message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
$message .= "送信日時: " . date('Y年m月d日 H:i:s') . "\n";

// メールヘッダー（Fromはサーバーのドメインに設定）
$headers = "From: no-reply@spice-web.jp\r\n";
$headers .= "Reply-To: " . $data['email'] . "\r\n";
$headers .= "X-Sender-Email: " . $data['email'] . "\r\n";
$headers .= "X-Sender-Name: " . mb_encode_mimeheader($data['name']) . "\r\n";

// メール送信
$mail_result = mb_send_mail($to, $subject, $message, $headers);

// エラーログ
if (!$mail_result) {
  error_log("Mail send failed to: " . $to);
  error_log("Error: " . print_r(error_get_last(), true));
}

if ($mail_result) {
  // 自動返信メール（レスポンス前に送信）
  $auto_reply_subject = '【自動返信】お問い合わせを受け付けました - 株式会社スパイス';
  $auto_reply_message = $data['name'] . " 様\n\n";
  $auto_reply_message .= "この度はお問い合わせいただき、誠にありがとうございます。\n";
  $auto_reply_message .= "以下の内容でお問い合わせを受け付けました。\n\n";
  $auto_reply_message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
  $auto_reply_message .= "件名: " . $data['subject'] . "\n";
  $auto_reply_message .= "ご用件: " . $data['inquiryType'] . "\n";
  $auto_reply_message .= "お問い合わせ内容:\n" . $data['message'] . "\n";
  $auto_reply_message .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";
  $auto_reply_message .= "担当者が内容を確認次第、ご連絡させていただきます。\n";
  $auto_reply_message .= "今しばらくお待ちくださいませ。\n\n";
  $auto_reply_message .= "※このメールは自動送信されています。\n";
  $auto_reply_message .= "※このメールに返信されても、お答えできませんのでご了承ください。\n\n";
  $auto_reply_message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
  $auto_reply_message .= "株式会社スパイス\n";
  $auto_reply_message .= "〒733-0031 広島県広島市西区観音町13-9\n";
  $auto_reply_message .= "TEL: 082-209-0601\n";
  $auto_reply_message .= "Web: https://spice-web.jp\n";
  $auto_reply_message .= "━━━━━━━━━━━━━━━━━━━━━━\n";

  $auto_reply_headers = "From: no-reply@spice-web.jp\r\n";
  $auto_reply_headers .= "Reply-To: info@spice-web.jp\r\n";

  $auto_reply_result = mb_send_mail($data['email'], $auto_reply_subject, $auto_reply_message, $auto_reply_headers);

  // 自動返信のエラーログ
  if (!$auto_reply_result) {
    error_log("Auto-reply mail send failed to: " . $data['email']);
  }

  // 送信成功レスポンス
  http_response_code(200);
  echo json_encode([
    'success' => true,
    'message' => 'お問い合わせを受け付けました。担当者より折り返しご連絡いたします。'
  ]);
  exit; // 重要: ここで処理を終了
} else {
  // 送信失敗
  http_response_code(500);
  echo json_encode([
    'success' => false,
    'message' => 'メール送信に失敗しました。しばらく時間をおいて再度お試しください。'
  ]);
  exit; // 重要: ここで処理を終了
}
