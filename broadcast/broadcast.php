<?php
$bot_token = "7758642802:AAGIqio7yNP0w2MuT0dV5PQBcYt2z1aLB_E";
$users_file = ("../users.txt");
$api_url = "https://api.telegram.org/bot$bot_token/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message'] ?? '');
    $caption = trim($_POST['caption'] ?? '');
    $parse_mode = $_POST['parse_mode'] ?? "HTML";

    if (!file_exists($users_file)) {
        die("❌ <b>users.txt not found!</b>");
    }

    $users = file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $user_ids = [];

    foreach ($users as $line) {
        $parts = explode('|', $line);
        if (count($parts) >= 2) {
            $user_ids[] = trim($parts[1]);
        }
    }

    $sent = 0;
    $failed = 0;

    foreach ($user_ids as $chat_id) {
        $chat_id = trim($chat_id);
        $success = false;

        // If video is uploaded
        if (!empty($_FILES['video']['tmp_name'])) {
            $video_path = $_FILES['video']['tmp_name'];
            $post_fields = [
                'chat_id' => $chat_id,
                'video' => new CURLFile($video_path),
                'caption' => $caption,
                'parse_mode' => $parse_mode
            ];
            $url = $api_url . "sendVideo";

        } elseif (!empty($_FILES['image']['tmp_name'])) {
            // If image is uploaded
            $image_path = $_FILES['image']['tmp_name'];
            $post_fields = [
                'chat_id' => $chat_id,
                'photo' => new CURLFile($image_path),
                'caption' => $caption,
                'parse_mode' => $parse_mode
            ];
            $url = $api_url . "sendPhoto";

        } elseif (!empty($message)) {
            // Only message
            $post_fields = [
                'chat_id' => $chat_id,
                'text' => $message,
                'parse_mode' => $parse_mode
            ];
            $url = $api_url . "sendMessage";
        } else {
            continue;
        }

        // cURL call
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($result && strpos($result, '"ok":true') !== false) {
            $sent++;
        } else {
            $failed++;
        }
    }

    echo "<h3>✅ Broadcast Complete!</h3>";
    echo "<b>✔️ Sent:</b> $sent<br>";
    echo "<b>❌ Failed:</b> $failed<br>";
}
?>
