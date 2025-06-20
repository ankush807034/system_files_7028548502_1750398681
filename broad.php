// ✅ Handle /broad command
if ($text == "/br") {
    $button = [
        "inline_keyboard" => [[
            ["text" => "📡 Do Broadcast", "web_app" => ["url" => "https://yourdomain.com/bot.php?webpanel=1"]]
        ]]
    ];
    sendPhoto($chat_id, "https://myappme.shop/img/file_238.jpg", "📡 Do Broadcast", $button);
    sendMessage($chat_id, "TESTING......");
    exit;
}

// ✅ WebApp Panel
if (isset($_GET["webpanel"])) {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>📡 Broadcast Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                background: linear-gradient(135deg, #ffd89b, #19547b);
                font-family: "Comic Sans MS", cursive;
                padding: 20px;
                color: #333;
            }
            h1, h2 {
                text-align: center;
                font-weight: bold;
            }
            h1 { color: red; font-size: 24px; }
            h2 { color: black; font-size: 20px; margin-bottom: 30px; }
            label {
                font-weight: bold;
                font-size: 18px;
                display: block;
                margin: 15px 0 5px;
            }
            textarea, input[type="file"], input[type="text"] {
                width: 100%;
                padding: 10px;
                border-radius: 10px;
                border: 1px solid #ccc;
                font-size: 16px;
                margin-bottom: 15px;
                background-color: white;
            }
            button {
                width: 100%;
                background-color: #28a745;
                color: white;
                padding: 12px;
                font-size: 18px;
                border: none;
                border-radius: 10px;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <h2>Send Message For Bot</h2>
        <h1>By <span style="color:red;">@its_m_sagar</span> on Telegram</h1>

        <form method="post" enctype="multipart/form-data">
            <label>For Message</label>
            <textarea name="text" placeholder="Type your message..."></textarea>

            <label>For Image</label>
            <input type="file" name="image" accept="image/*">

            <label>For Video</label>
            <input type="file" name="video" accept="video/*">

            <label>Caption (if sending an image or video):</label>
            <input type="text" name="caption" placeholder="Your caption here...">

            <button type="submit">Send</button>
        </form>
    </body>
    </html>
    ';
    exit;
}

// ✅ Handle broadcast post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = file("users.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $caption = $_POST['caption'] ?? '';
    $text = $_POST['text'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $imgPath = $_FILES['image']['tmp_name'];
        foreach ($users as $uid) {
            sendImageFromFile($uid, $imgPath, $caption);
        }
    } elseif (isset($_FILES['video']) && $_FILES['video']['size'] > 0) {
        $vidPath = $_FILES['video']['tmp_name'];
        foreach ($users as $uid) {
            sendVideoFromFile($uid, $vidPath, $caption);
        }
    } elseif (!empty($text)) {
        foreach ($users as $uid) {
            sendMessage($uid, $text);
        }
    }

    echo "✅ Broadcast Sent!";
    exit;
}

// ✅ Support Functions

function sendMessage($chat_id, $text, $keyboard = null) {
    global $API_URL;
    $data = [
        "chat_id" => $chat_id,
        "text" => $text,
        "parse_mode" => "HTML"
    ];
    if ($keyboard) {
        $data["reply_markup"] = json_encode($keyboard);
    }
    file_get_contents($API_URL . "sendMessage?" . http_build_query($data));
}

function sendImageFromFile($chat_id, $file_path, $caption = "") {
    global $API_URL;
    $post = [
        'chat_id' => $chat_id,
        'caption' => $caption,
        'photo' => new CURLFile(realpath($file_path))
    ];
    sendCurlRequest("sendPhoto", $post);
}

function sendVideoFromFile($chat_id, $file_path, $caption = "") {
    global $API_URL;
    $post = [
        'chat_id' => $chat_id,
        'caption' => $caption,
        'video' => new CURLFile(realpath($file_path))
    ];
    sendCurlRequest("sendVideo", $post);
}

function sendPhoto($chat_id, $photo_url, $caption, $keyboard = null) {
    global $API_URL;
    $data = [
        "chat_id" => $chat_id,
        "photo" => $photo_url,
        "caption" => $caption,
        "parse_mode" => "HTML"
    ];
    if ($keyboard) {
        $data["reply_markup"] = json_encode($keyboard);
    }
    file_get_contents($API_URL . "sendPhoto?" . http_build_query($data));
}

function sendCurlRequest($method, $postData) {
    global $API_URL;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $API_URL . $method);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_exec($ch);
    curl_close($ch);
}
