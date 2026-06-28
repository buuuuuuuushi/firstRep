<?php
require_once 'auth.php';

if (!empty($_SESSION['user_id'])) {
    sendJson(['status' => 'success', 'user_id' => $_SESSION['user_id']]);
}

http_response_code(401);
sendJson(['status' => 'error', 'message' => 'Not logged in.']);
