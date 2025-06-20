<?php
include_once 'functions.php';

$chat_id = $data["message"]["chat"]["id"];
$admin = "6308208399";

$image_url = "https://balak807034.serv00.net/uploads/img_683ebde3b87b0.jpg";

$caption = "Pʟᴇᴀsᴇ ᴄᴏɴᴛᴀᴄᴛ ᴛʜᴇ ᴀᴅᴍɪɴɪsᴛʀᴀᴛᴏʀ ᴀɴᴅ sʜᴀʀᴇ ʏᴏᴜʀ qᴜᴇʀʏ ᴡɪᴛʜ ᴜs. Wᴇ'ʀᴇ ʜᴇʀᴇ ᴀɴᴅ ʀᴇᴀᴅʏ ᴛᴏ ᴀssɪsᴛ ʏᴏᴜ.";

$inline_keyboard = [
    "inline_keyboard" => [
        [
            [
                "text" => "🆘 𝐂𝐨𝐧𝐭𝐚𝐜𝐭 𝐮𝐬",
                "url" => "https://t.me/BALAK_TRUSTED"
            ]
        ]
    ]
];

// Send the main photo
$post = [
    'chat_id' => $chat_id,
    'photo' => $image_url,
    'caption' => $caption,
    'parse_mode' => 'HTML',
    'reply_markup' => json_encode($inline_keyboard)
];
file_get_contents(API_URL . "sendPhoto?" . http_build_query($post));

// ✅ Send QR photo
sendPhoto(
    $chat_id,
    $qr_image,       // make sure this is defined somewhere
    $caption,
    $inline_keyboard,
    $message_id      // also make sure this is defined somewhere
);
?>
