<?php
// Turnstileシークレットキー設定
if (!getenv('TURNSTILE_SECRET_KEY')) {
  putenv('TURNSTILE_SECRET_KEY=0x4AAAAAAB7-ioGVAAJlNweQS_P_fiLzd60');
}

// .envファイルから環境変数を読み込む（開発環境用）
if (file_exists(__DIR__ . '/../.env')) {
  $envFile = file_get_contents(__DIR__ . '/../.env');
  foreach (explode("\n", $envFile) as $line) {
    $line = trim($line);
    if (empty($line) || strpos($line, '#') === 0 || strpos($line, '=') === false) continue;
    list($key, $value) = explode('=', $line, 2);
    $key = trim($key); $value = trim($value);
    if (!getenv($key)) putenv("$key=$value");
  }
}

// ヘッダー設定
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

if (empty($data['content'])) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => '送信内容が空です。']);
  exit;
}

// Turnstile検証
if (empty($data['turnstileToken'])) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => 'セキュリティ認証トークンが必要です。']);
  exit;
}

$turnstileSecret = getenv('TURNSTILE_SECRET_KEY');
$verifyResponse = @file_get_contents('https://challenges.cloudflare.com/turnstile/v0/siteverify', false, stream_context_create([
  'http' => [
    'method'  => 'POST',
    'header'  => 'Content-Type: application/x-www-form-urlencoded',
    'content' => http_build_query([
      'secret'   => $turnstileSecret,
      'response' => $data['turnstileToken'],
      'remoteip' => $_SERVER['REMOTE_ADDR'],
    ]),
  ],
]));

if ($verifyResponse === false || !json_decode($verifyResponse, true)['success']) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => 'セキュリティ認証に失敗しました。もう一度お試しください。']);
  exit;
}

// メール設定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to = 'info@spice-web.jp';
$subject = '【WEBサイト要件ヒアリング】新しいヒアリング内容が届きました';

$message  = "WEBサイト要件ヒアリングフォームから送信がありました。\n\n";
$message .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";
$message .= $data['content'];
$message .= "\n━━━━━━━━━━━━━━━━━━━━━━\n";
$message .= "送信日時: " . date('Y年m月d日 H:i:s') . "\n";

$headers  = "From: no-reply@spice-web.jp\r\n";

$mail_result = mb_send_mail($to, $subject, $message, $headers);

if ($mail_result) {
  http_response_code(200);
  echo json_encode(['success' => true, 'message' => '送信が完了しました。']);
} else {
  error_log("Hearing mail send failed. Error: " . print_r(error_get_last(), true));
  http_response_code(500);
  echo json_encode(['success' => false, 'message' => 'メール送信に失敗しました。しばらく時間をおいて再度お試しください。']);
}
