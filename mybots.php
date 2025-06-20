<?php
date_default_timezone_set('Asia/Kolkata');

$chat_id = $message["chat"]["id"];
$user_id = $message["from"]["id"];
$message_id = $message["message_id"];

$botlist_file = "botlist.txt";
$bots = file_exists($botlist_file) ? file($botlist_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

$user_bots = [];
foreach ($bots as $line) {
    $parts = explode(" ", $line);
    if (count($parts) < 4) continue; // Skip invalid lines

    list($bot_username, $bot_token, $owner_id, $status) = $parts;

    if ($owner_id == $user_id) {
        // Validate token and get bot details
        $getme_url = "https://api.telegram.org/bot$bot_token/getMe";
        $getme_response = file_get_contents($getme_url);
        $getme_data = json_decode($getme_response, true);

        if ($getme_data['ok']) {
            $name = $getme_data['result']['first_name'] ?? 'Unknown';
            $username = $getme_data['result']['username'] ?? 'Unknown';
            $bot_id = $getme_data['result']['id'] ?? '0';

            $user_bots[] = [
                'name' => $name,
                'username' => $username,
                'id' => $bot_id,
                'status' => $status
            ];
        }
    }
}

if (count($user_bots) === 0) {
    $msg = "❌ You don't have any bots yet.";
} else {
    $msg = "🧿 You have total " . count($user_bots) . " Bots:\n\n";

    foreach ($user_bots as $bot) {
        $msg .= "🔥 Nᴀᴍᴇ: " . strtoupper($bot['name']) . "\n";
        $msg .= "🧒 Usᴇʀɴᴀᴍᴇ: @" . $bot['username'] . "\n";
        $msg .= "🆔️ Iᴅ: " . $bot['id'] . "\n";
        $msg .= "💠 Sᴛᴀᴛᴜs: " . ucfirst($bot['status']) . " " . ($bot['status'] == "active" ? "✅" : "❌") . "\n\n";
        $msg .= "🗑 Destroy Bot: /destroy" . $bot['id'] . "\n\n";
        $msg .= "💰 Pay here 👉 /PAY" . $bot['id'] . "\n";
        $msg .= "----------------------------------------\n\n";
    }
}

sendMessage($chat_id, $msg, null, $message_id);
?>
