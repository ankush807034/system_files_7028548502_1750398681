<?php

// Show the rent options with Exit
sendMessage($chat_id, "🤖 RENT BOT\nPlease select which bot you want 😋", [
    [['text' => "🇮🇳 INDO IG BOT"]],
    [['text' => "🚪 Exit"]]
], $message_id);

// Handle "🇮🇳 INDO IG BOT"
if ($text == "🇮🇳 INDO IG BOT") {
    $connectMessage = "Tᴏ Cᴏɴɴᴇᴄᴛ ᴀ Bᴏᴛ, Yᴏᴜ Sʜᴏᴜʟᴅ Fᴏʟʟᴏᴡ Tʜᴇsᴇ Tᴡᴏ Sᴛᴇᴘs :

1. Oᴘᴇɴ @BotFather Cʀᴇᴀᴛᴇ ᴀ Nᴇᴡ Bᴏᴛ
2. Yᴏᴜ'ʟʟ Gᴇᴛ ᴀ Tᴏᴋᴇɴ (ᴇ.ɢ. 12345:6789ABCDEF) —  Jᴜsᴛ Cᴏᴘʏ Pᴀsᴛᴇ Iᴛ Tᴏ Tʜɪs Cʜᴀᴛ

Example

/mybot xxxxxx

⚠️Wᴀʀɴɪɴɢ Dᴏɴ'ᴛ Cᴏɴɴᴇᴄᴛ ᴛʜᴇ ʙᴏᴛ ᴛʜᴀᴛ ᴀʟʀᴇᴀᴅʏ ᴄᴏɴɴᴇᴄᴛᴇᴅ";

    sendMessage($chat_id, $connectMessage, null, $message_id);
    exit;
}

// Handle Exit button in bot.php separately via exit.php
?>
