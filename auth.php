<?php
require_once __DIR__ . '/db.php';

function sendJson($data) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

function requireLogin() {
    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        sendJson(['status' => 'error', 'message' => 'Unauthorized. Please log in.']);
    }
}

function currentUserId() {
    return $_SESSION['user_id'] ?? null;
}
