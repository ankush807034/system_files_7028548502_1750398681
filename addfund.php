<?php
include_once 'functions.php'; // Make sure this defines sendMessage() and sendPhoto()

$admin_id = 7028548502;

// ✅ /qr update
if (preg_match('/^\/qr\s+(https?:\/\/[^\s]+)/i', $text, $matches)) {
    if ($chat_id == $admin_id) {
        $new_link = trim($matches[1]);
        if (filter_var($new_link, FILTER_VALIDATE_URL)) {
            file_put_contents("qr_image.txt", $new_link);
            sendMessage($chat_id, "✅ QR Updated!", null, $message_id);
        } else {
            sendMessage($chat_id, "❌ Invalid URL format.", null, $message_id);
        }
    }
    exit;
}

// ✅ /qrcap update
if (preg_match('/^\/qrcap\s+(.+)/is', $text, $matches)) {
    if ($chat_id == $admin_id) {
        $new_caption = trim($matches[1]);
        file_put_contents("qr_caption.txt", $new_caption);
        sendMessage($chat_id, "✅ QR Caption Updated!", null, $message_id);
    } else {
        sendMessage($chat_id, "❌ You are not authorized to update caption.", null, $message_id);
    }
    exit;
}

// ✅ Show waiting message with <pre> formatting
sendMessage($chat_id, "<pre>⏳ PLEASE WAIT.. GENERATING QR 👨‍💻</pre>", null, $message_id);
sleep(1);

// ✅ Inline keyboard
$inline_keyboard = [
    "inline_keyboard" => [
        [
            ["text" => "CHECK ✅", "url" => "https://t.me/LIMITED_BALAK_bot?text=I%20want%20to%20add%20funds"]
        ]
    ]
];

// ✅ Load caption
$caption = file_exists("qr_caption.txt") ? trim(file_get_contents("qr_caption.txt")) :
"𝗣𝗔𝗬 𝗢𝗡 𝗧𝗛𝗜𝗦 𝗤𝗥 𝗔𝗡𝗗 𝗖𝗟𝗜𝗖𝗞 𝗢𝗡 𝗖𝗛𝗘𝗖𝗞 ✅ 𝗧𝗢 𝗔𝗗𝗗 𝗬𝗢𝗨𝗥 𝗕𝗔𝗟𝗔𝗡𝗖𝗘 ✅

🔴𝗔𝗟𝗟 𝗣𝗔𝗬𝗠𝗘𝗡𝗧𝗦 𝗠𝗘𝗧𝗛𝗢𝗗 𝗔𝗖𝗖𝗘𝗣𝗧𝗘𝗗🔴

⚠️𝗬𝗢𝗨 𝗖𝗔𝗡 𝗔𝗗𝗗 𝗕𝗔𝗟𝗔𝗡𝗖𝗘 𝗧𝗢 𝗬𝗢𝗨𝗥 𝗔𝗖𝗖𝗢𝗨𝗡𝗧 𝗕𝗬 𝗖𝗟𝗜𝗖𝗞𝗜𝗡𝗚 𝗢𝗡 𝗧𝗛𝗘 𝗖𝗛𝗘𝗖𝗞✅ 𝗕𝗨𝗧𝗧𝗢𝗡 𝗢𝗥 𝗕𝗬 𝗦𝗘𝗡𝗗𝗜𝗡𝗚 𝗧𝗥𝗔𝗡𝗦𝗔𝗖𝗧𝗜𝗢𝗡 𝗜𝗗 ⚠️";

// ✅ Load QR image
$default_qr = "https://myappme.shop/img/file_251.jpg";
$qr_image = $default_qr;

if (file_exists("qr_image.txt")) {
    $custom_qr = trim(file_get_contents("qr_image.txt"));
    if (filter_var($custom_qr, FILTER_VALIDATE_URL)) {
        $qr_image = $custom_qr;
    }
}

// ✅ Send QR photo
sendPhoto(
    $chat_id,
    $qr_image,
    $caption,
    $inline_keyboard,
    $message_id
);
?>
