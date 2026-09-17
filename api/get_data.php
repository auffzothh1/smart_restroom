<?php
header('Content-Type: application/json');
include '../config.php';

$latest = $conn->query("SELECT * FROM sensor_data ORDER BY id DESC LIMIT 1")->fetch_assoc();
$history = $conn->query("SELECT * FROM sensor_data ORDER BY id DESC LIMIT 10");
$alerts = $conn->query("SELECT * FROM alerts ORDER BY id DESC LIMIT 5");

$historyArr = [];
while ($row = $history->fetch_assoc()) { $historyArr[] = $row; }

$alertArr = [];
while ($row = $alerts->fetch_assoc()) { $alertArr[] = $row; }

echo json_encode([
    "latest" => $latest,
    "history" => $historyArr,
    "alerts" => $alertArr
]);
?>