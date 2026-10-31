<?php

function anonymizeIp(string $ip): string
{
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        $parts = explode('.', $ip);
        $parts[3] = 'xxx';
        return implode('.', $parts);
    }

    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        $parts = explode(':', $ip);
        return implode(':', array_slice($parts, 0, 4)) . '::';
    }

    return 'unknown';
}

function getClientIp(): string
{
    $headers = [
        'HTTP_CF_CONNECTING_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_REAL_IP',
        'REMOTE_ADDR'
    ];
    
    foreach ($headers as $h) {
        if (!empty($_SERVER[$h])) {
            $ip = trim(explode(',', $_SERVER[$h])[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

// Ricevi solo GET
$data = $_GET;

$pageUrl   = $data['page_url']   ?? $_SERVER['HTTP_REFERER']      ?? '';
$referrer  = $data['referrer']   ?? '';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$ip        = anonymizeIp(getClientIp());
$screenW   = $data['screen_w']   ?? null;
$screenH   = $data['screen_h']   ?? null;
$language  = $data['lang']       ?? ($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=xxx;charser=utf8mb4", 'xxx', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->prepare("
        INSERT INTO visits (page_url, referrer, user_agent, ip, screen_width, screen_height, language)
        VALUES (:page_url, :referrer, :user_agent, :ip, :screen_width, :screen_height, :language)
    ");
    
    $stmt->execute([
        ':page_url'      => mb_substr($pageUrl, 0, 2048),
        ':referrer'     => mb_substr($referrer, 0, 2048),
        ':user_agent'   => mb_substr($userAgent, 0, 512),
        ':ip'           => $ip,
        ':screen_width' => $screenW !== '' && $screenW !== null ? (int)$screenW : null,
        ':screen_height'=> $screenH !== '' && $screenH !== null ? (int)$screenH : null,
        ':language'     => mb_substr($language, 0, 50),
    ]);
} catch (PDOException $e) {
    // Ignora in produzione
}

// Restituisci pixel 1x1 (IMPORTANTE: nessun header CORS necessario)
header('Content-Type: image/png');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');
exit;