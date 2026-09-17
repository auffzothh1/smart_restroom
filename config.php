<?php
session_start();
// Copy config.local.example.php to config.local.php on the hosting server.
$local = __DIR__ . '/config.local.php';
if (is_file($local)) { require $local; }
$host = $host ?? getenv('DB_HOST');
$user = $user ?? getenv('DB_USER');
$pass = $pass ?? getenv('DB_PASSWORD');
$dbname = $dbname ?? getenv('DB_NAME');
$sensor_api_key = $sensor_api_key ?? getenv('SENSOR_API_KEY');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    if (!$host || !$user || !$dbname) { throw new RuntimeException('Database configuration missing'); }
    $conn = new mysqli($host, $user, $pass, $dbname);
    $conn->set_charset('utf8mb4');
} catch (Throwable $e) {
    http_response_code(500);
    exit('Database connection unavailable. Please check hosting configuration.');
}
