<?php
// Only admin (owner) can use /gen
$owner_id = file_exists("owner.txt") ? trim(file_get_contents("owner.txt")) : $ADMIN_ID;
if ($user_id != $owner_id) {
    sendMessage($chat_id, "❌ You are not authorized to generate codes.");
    return;
}

$parts = explode(" ", $text);
if (count($parts) != 3) {
    sendMessage($chat_id, "⚠️ Usage: /gen price amount\nExample: /gen 30 2");
    return;
}

$price = intval($parts[1]);
$amount = intval($parts[2]);

if ($price <= 0 || $amount <= 0) {
    sendMessage($chat_id, "❌ Invalid price or amount.");
    return;
}

$codes_file = "codes.txt";
$generated = [];

for ($i = 0; $i < $amount; $i++) {
    $code = strtoupper(bin2hex(random_bytes(4))); // 8-character code
    $generated[] = $code;
    file_put_contents($codes_file, "$code|$price\n", FILE_APPEND);
}

$code_list = implode("\n", array_map(fn($c) => "CODE_$c", $generated));
sendMessage($chat_id, "✅ Generated $amount code(s):\n\n<code>$code_list</code>");
