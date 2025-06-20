<?php

if (!function_exists('sendMessage')) {
    function sendMessage($chat_id, $text, $keyboard = null, $reply_to = null) {
        global $BOT_TOKEN;
        $url = "https://api.telegram.org/bot$BOT_TOKEN/sendMessage";

        $data = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'HTML'
        ];

        if ($keyboard) {
            $data['reply_markup'] = json_encode($keyboard);
        }

        if ($reply_to) {
            $data['reply_to_message_id'] = $reply_to;
        }

        // cURL POST request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);

        // Uncomment to debug
        // file_put_contents('sendMessage_debug.txt', $result);
    }
}

if (!function_exists('sendPhoto')) {
    function sendPhoto($chat_id, $photo_url, $caption = "", $keyboard = null, $reply_to = null) {
        global $BOT_TOKEN;
        $url = "https://api.telegram.org/bot$BOT_TOKEN/sendPhoto";

        $data = [
            'chat_id' => $chat_id,
            'photo' => $photo_url,
            'caption' => $caption,
            'parse_mode' => 'HTML'
        ];

        if ($keyboard) {
            $data['reply_markup'] = json_encode($keyboard);
        }

        if ($reply_to) {
            $data['reply_to_message_id'] = $reply_to;
        }

        // cURL POST request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);

        // Uncomment to debug
        // file_put_contents('sendPhoto_debug.txt', $result);
    }
}

?>
