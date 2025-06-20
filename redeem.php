<?php
$parts = explode(" ", $text);
if (count($parts) != 2) {
    sendMessage($chat_id, "⚠️ Usage: /redeem CODE");
    return;
}

$code_input = strtoupper(trim($parts[1]));
$code_input = str_replace("CODE_", "", $code_input); // Remove prefix if given

$codes_file = "codes.txt";
$users_file = "users.txt";

// Read codes
$codes = file_exists($codes_file) ? file($codes_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
$found = false;
$new_codes = [];

foreach ($codes as $line) {
    list($code, $price) = explode("|", $line);
    if (trim($code) == $code_input) {
        $found = true;
        $price = intval(trim($price));
        continue; // Remove used code
    }
    $new_codes[] = $line;
}

if (!$found) {
    sendMessage($chat_id, "❌ Invalid or already used code: CODE_$code_input");
    return;
}

// Update codes.txt
file_put_contents($codes_file, implode("\n", $new_codes) . "\n");

// Update balance in users.txt
$users = file_exists($users_file) ? file($users_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
$updated = false;

foreach ($users as &$line) {
    $parts = explode(" | ", $line);
    if (count($parts) == 3 && trim($parts[1]) == $user_id) {
        // Remove ₹ if present, then add
        $bal = (int)str_replace("₹", "", trim($parts[2]));
        $new_bal = $bal + $price;
        $parts[2] = "₹$new_bal";
        $line = implode(" | ", $parts);
        $updated = true;
        break;
    }
}

// Add new user if not found
if (!$updated) {
    $users[] = "$username | $user_id | ₹$price";
} else {
    unset($line);
}

file_put_contents($users_file, implode("\n", $users) . "\n");

// Confirm message
sendMessage($chat_id, "✅ Code 'CODE_$code_input' redeemed!\n💰 ₹$price added to your balance.");
