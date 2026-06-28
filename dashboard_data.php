<?php
require_once 'auth.php';
requireLogin();
header('Content-Type: application/json; charset=utf-8');

$totalReservations = 0;
$upcomingEvents = 0;
$pendingRequests = 0;

$res = $conn->query("SELECT COUNT(*) AS total FROM reservations");
if ($res) {
    $row = $res->fetch_assoc();
    $totalReservations = intval($row['total']);
    $res->close();
}

$res = $conn->query("SELECT COUNT(*) AS total FROM reservations WHERE event_date >= CURDATE()");
if ($res) {
    $row = $res->fetch_assoc();
    $upcomingEvents = intval($row['total']);
    $res->close();
}

$res = $conn->query("SELECT COUNT(*) AS total FROM reservations WHERE status = 'Pending'");
if ($res) {
    $row = $res->fetch_assoc();
    $pendingRequests = intval($row['total']);
    $res->close();
}

sendJson([
    'status' => 'success',
    'data' => [
        'total_reservations' => $totalReservations,
        'upcoming_events' => $upcomingEvents,
        'pending_requests' => $pendingRequests
    ]
]);
