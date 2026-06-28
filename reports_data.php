<?php
require_once 'auth.php';
requireLogin();
header('Content-Type: application/json; charset=utf-8');

$monthlyReservations = [];
$res = $conn->query("SELECT DATE_FORMAT(event_date, '%M') AS month, COUNT(*) AS total FROM reservations WHERE event_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) GROUP BY MONTH(event_date), YEAR(event_date) ORDER BY event_date ASC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $monthlyReservations[] = $row;
    }
    $res->close();
}

$popularPackage = 'No data yet';
$res = $conn->query("SELECT event_type AS package_name, COUNT(*) AS count FROM reservations GROUP BY event_type ORDER BY count DESC LIMIT 1");
if ($res && $res->num_rows) {
    $row = $res->fetch_assoc();
    $popularPackage = $row['package_name'];
    $res->close();
}

sendJson([
    'status' => 'success',
    'data' => [
        'monthly_reservations' => $monthlyReservations,
        'popular_package' => $popularPackage
    ]
]);
