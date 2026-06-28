<?php
require_once 'auth.php';
requireLogin();

$userId = currentUserId();
$stmt = $conn->prepare('SELECT id, fullname, email FROM users WHERE id = ?');
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($id, $fullname, $email);
if ($stmt->fetch()) {
    sendJson(['status' => 'success', 'user' => ['id' => $id, 'fullname' => $fullname, 'email' => $email]]);
} else {
    http_response_code(404);
    sendJson(['status' => 'error', 'message' => 'User not found.']);
}
$stmt->close();
