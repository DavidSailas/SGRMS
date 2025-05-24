<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prompt = $_POST['prompt'];

    $data = array(
        "model" => "llama3.2:1b-instruct-q4_0",
        "messages" => array(
            array(
                "role" => "system",
                "content" => "You are a Guidance Office Support Chatbot that always greets users warmly 
                and uses friendly, casual language—especially when speaking to students. 
                Occasionally use emojis (like 😊 or 📚) to show friendliness and warmth, but don't overuse them.
                Do not use markdown formatting like asterisks (*) or bold text. Instead, communicate in plain, clear 
                sentences that are warm and supportive.  Your job  is to provide general guidance, emotional encouragement, and helpful information 
                related to counseling, academic advising, scheduling, and mental health. Always be kind, supportive, and easy to 
                talk to. Do not answer unrelated questions. If the question is not about guidance office services, respond only 
                with: 'I'm here to help with guidance office-related inquiries only. 
                For other questions, please contact the appropriate department.'"
            ),
            array(
                "role" => "user",
                "content" => $prompt
            )
        )
    );

    $ch = curl_init('http://127.0.0.1:11434/api/chat');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false); // stream manually
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $responseText = "";
    curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($curl, $chunk) use (&$responseText) {
        $lines = explode("\n", trim($chunk));
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;

            $json = json_decode($line, true);
            if ($json && isset($json['message']['content'])) {
                $responseText .= $json['message']['content'];
            }
        }
        return strlen($chunk);
    });

    $result = curl_exec($ch);
    if ($result === false) {
        echo "Failed to connect to AI model: " . curl_error($ch);
    } else {
        echo $responseText;
    }
    curl_close($ch);
}
?>
