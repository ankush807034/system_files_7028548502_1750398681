<?php
include_once 'functions.php'; // Required for sendMessage()

date_default_timezone_set('Asia/Kolkata'); // Set timezone to IST

$name = $message["from"]["first_name"] ?? "User";
$user_id = $message["from"]["id"] ?? "Unknown";
$balance = 0;
$time = date("h:i A");
$date = date("d-m-Y");

// Fetch balance from users.txt
$user_file = "users.txt";
if (file_exists($user_file)) {
    $users = file($user_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($users as $line) {
        $parts = explode(" | ", $line);
        if (count($parts) == 3 && trim($parts[1]) == $user_id) {
            $bal_raw = trim($parts[2]);
            $balance = (int) str_replace("₹", "", $bal_raw);
            break;
        }
    }
}

// Fully bolded profile message
$profileText = "<b>👤  Nᴀᴍᴇ : $name\n";
$profileText .= "🆔 Usᴇʀ ID : $user_id\n\n";
$profileText .= "💵 Bᴀʟᴀɴᴄᴇ : ₹$balance\n\n";
$profileText .= "⌚️ Time : $time\n";
$profileText .= "📆 Dᴀᴛᴇ : $date</b>";

// Send message with full bold formatting
sendMessage($chat_id, $profileText, null, $message["message_id"]);
