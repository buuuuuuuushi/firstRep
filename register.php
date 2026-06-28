<?php
require_once 'db.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
    exit;
}

$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if ($fullname === '' || $email === '' || $password === '' || $confirmPassword === '') {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
    exit;
}

if ($password !== $confirmPassword) {
    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
    exit;
}

$check = $conn->prepare('SELECT UserID FROM tbl_users WHERE Username = ?');
$check->bind_param('s', $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'That email/username is already registered.']);
    exit;
}
$check->close();

$hash = password_hash($password, PASSWORD_DEFAULT);
$insert = $conn->prepare('INSERT INTO tbl_users (Username, FullName, Password, Role, DateCreated) VALUES (?, ?, ?, ?, CURDATE())');
$role = 'Staff';
$insert->bind_param('ssss', $email, $fullname, $hash, $role);
if ($insert->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Registration failed.']);
}
$insert->close();
