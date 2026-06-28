<?php
require_once 'auth.php';
requireLogin();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    sendJson(['status' => 'error', 'message' => 'Method not allowed.']);
}

$userId = currentUserId();
$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($fullname === '' || $email === '') {
    sendJson(['status' => 'error', 'message' => 'Full name and email are required.']);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendJson(['status' => 'error', 'message' => 'Enter a valid email address.']);
}

$check = $conn->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
$check->bind_param('si', $email, $userId);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    sendJson(['status' => 'error', 'message' => 'That email is already in use.']);
}
$check->close();

if ($password !== '') {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('UPDATE users SET fullname = ?, email = ?, password = ? WHERE id = ?');
    $stmt->bind_param('sssi', $fullname, $email, $hash, $userId);
} else {
    $stmt = $conn->prepare('UPDATE users SET fullname = ?, email = ? WHERE id = ?');
    $stmt->bind_param('ssi', $fullname, $email, $userId);
}

if ($stmt->execute()) {
    sendJson(['status' => 'success']);
} else {
    http_response_code(500);
    sendJson(['status' => 'error', 'message' => 'Unable to update profile.']);
}
$stmt->close();
