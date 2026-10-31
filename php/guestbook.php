<?php
header("Access-Control-Allow-Origin: *"); // permetti al tuo sito Jekyll di leggerlo
header("Content-Type: application/json; charset=UTF-8");

$dataFile = __DIR__ . '/guestbook.json';

// GET: restituisci i messaggi
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!file_exists($dataFile)) {
        echo json_encode([]);
        exit;
    }
    $content = file_get_contents($dataFile);
    echo $content ?: json_encode([]);
    exit;
}

// POST: salva un nuovo messaggio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Honeypot anti-spam (semplice)
    if (!empty($_POST['website'])) {
        http_response_code(400);
        echo json_encode(["error" => "spam"]);
        exit;
    }

    $name = trim($_POST['name'] ?? 'Anonimo');
    $message = trim($_POST['message'] ?? '');
    $email = trim($_POST['email'] ?? ''); // facoltativo

    if ($message === '') {
        http_response_code(400);
        echo json_encode(["error" => "messaggio vuoto"]);
        exit;
    }

    // Carica messaggi esistenti
    $messages = [];
    if (file_exists($dataFile)) {
        $json = file_get_contents($dataFile);
        $messages = json_decode($json, true) ?: [];
    }

    // Aggiungi nuovo messaggio
    $messages[] = [
        "name"    => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
        "message" => nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')), // conserva a capo
        "date"    => date('Y-m-d H:i:s')
    ];

    // Salva (mantieni ordine cronologico)
    file_put_contents($dataFile, json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // Reindirizza alla pagina del guestbook con messaggio di conferma
    header("Location: https://uran10.github.io//guestbook.html?success=1");
    exit;
}