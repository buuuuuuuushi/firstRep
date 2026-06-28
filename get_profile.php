<?php
require_once 'auth.php';
requireLogin();

$userId = currentUserId();
$stmt = $conn->prepare('SELECT UserID, Username, FullName, Role, DateCreated FROM tbl_users WHERE UserID = ?');
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($id, $username, $fullname, $role, $dateCreated);
if ($stmt->fetch()) {
    sendJson(['status' => 'success', 'user' => ['id' => $id, 'username' => $username, 'fullname' => $fullname, 'role' => $role, 'dateCreated' => $dateCreated]]);
} else {
    http_response_code(404);
    sendJson(['status' => 'error', 'message' => 'User not found.']);
}
$stmt->close();
