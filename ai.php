<?php
// gemini-proxy.php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

// 1. WEKA API KEY YAKO YA GEMINI HAPA (Mtumiaji wa kawaida hawezi kuiona)
$api_key = "AIzaSy_WEKA_API_KEY_YAKO_HAPA";

// 2. Pokea swali toka kwenye HTML
$input_data = json_decode(file_get_contents("php://input"), true);
$user_message = isset($input_data['message']) ? trim($input_data['message']) : '';

if (empty($user_message)) {
    echo json_encode(["error" => ["message" => "Andika ujumbe kwanza kabla ya kutuma."]]);
    exit;
}

// 3. Maelekezo Maalum ya Mfumo (System Instructions) ili AI ijikite kwenye Kilimo pekee
$system_instruction = "Wewe ni mtaalamu wa kilimo cha kisasa na AI msaidizi kwa mfumo wa DAES (Digital Agriculture Enhancement System). "
                    . "Toa majibu mafupi, ya kina na ya kueleweka kuhusu kilimo cha kidijitali, mazao, mifugo, udongo, hali ya hewa, na masoko ya kilimo. "
                    . "Jibu kwa kutumia lugha ya Kiswahili fasaha na rahisi kueleweka kwa mkulima. "
                    . "Kama swali halihusiani kabisa na kilimo, mifugo, au mifumo ya kidijitali ya kilimo, jibu kwa adabu kwamba unaweza kusaidia kwenye masuala ya kilimo tu.";

// 4. Muundo wa data wa kwenda Google Gemini API
$url = "https://googleapis.com" . $api_key;
$data = [
    "contents" => [
        [
            "parts" => [
                ["text" => $system_instruction . "\n\nSwali la mkulima: " . $user_message]
            ]
        ]
    ]
];

// 5. Tuma data Google kwa njia ya siri kutumia cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => ["message" => "Seva imeshindwa kuunganisha na Google: " . curl_error($ch)]]);
    curl_close($ch);
    exit;
}

curl_close($ch);

// 6. Rudisha majibu kwenye tovuti (HTML)
echo $response;
?>
