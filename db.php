<?php
session_start();

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "wedding_db";
$dbPort = 3307;

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
if ($conn->connect_error) {
    header("Content-Type: application/json; charset=utf-8");
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

$conn->set_charset("utf8mb4");

