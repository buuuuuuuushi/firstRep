<?php
require_once 'auth.php';
requireLogin();
header('Content-Type: application/json; charset=utf-8');

$result = $conn->query("SELECT id, customer_name, event_type, DATE_FORMAT(event_date, '%M %e, %Y') AS event_date, status FROM reservations ORDER BY event_date ASC LIMIT 50");
$rows = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $result->close();
}

sendJson(['status' => 'success', 'records' => $rows]);
