<?php
global $BOT_TOKEN;

$chat_id = $message['chat']['id'] ?? '';
$text = $message['text'] ?? '';

if ($text == "💰 Pay ₹30") {
    $inactiveBots = file("botlist.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $response = "🧾 *List of INACTIVE Bots for payment:*\n\n";
    $found = false;

    foreach ($inactiveBots as $line) {
        list($bot_username, $bot_token, $userid) = explode(" ", $line);
        $bot_id = explode(":", $bot_token)[0];
        if ($userid == $chat_id) {
            $response .= "Click 👉 /PAY$bot_id to pay for @$bot_username\n";
            $found = true;
        }
    }

    if (!$found) {
        $response .= "_No inactive bots found for you._";
    }

    sendMessage($chat_id, $response, null, "Markdown");
}

function sendMessage($chat_id, $text, $keyboard = null, $parse_mode = null) {
    global $BOT_TOKEN;
    $data = [
        'chat_id' => $chat_id,
        'text' => $text
    ];
    if ($keyboard) $data['reply_markup'] = json_encode($keyboard);
    if ($parse_mode) $data['parse_mode'] = $parse_mode;

    file_get_contents("https://api.telegram.org/bot$BOT_TOKEN/sendMessage?" . http_build_query($data));
}
?>
