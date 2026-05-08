<?php

function verifyCaptchaToken(string $token, string $ip): array {
  $payload = http_build_query([
    "secret" => $_ENV['CAPTCHA_SECRET'],
    "response" => $token,
    "remoteip" => $ip,
    "sitekey" => "6c50ffb6-840e-4cc0-a51e-f5589a6ab912",
  ]);
  $ctx = stream_context_create([
    "http" => [
      "method" => "POST",
      "header" => "Content-type: application/x-www-form-urlencoded\r\n",
      "content" => $payload,
      "timeout" => 5,
    ],
  ]);
  $raw = file_get_contents(
    "https://api.hcaptcha.com/siteverify",
    false,
    $ctx
  );
  $j = json_decode($raw, true);
  if (!empty($j["success"])) {
    return [true, []];
  }
  return [false, $j["error-codes"] ?? []];
}


?>