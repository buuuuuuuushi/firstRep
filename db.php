<?php
session_start();

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "wedding_db";
$dbPort = 3307;

$conn = new mysqli($dbHost, $dbUser, $dbPass, '', $dbPort);
if ($conn->connect_error) {
    header("Content-Type: application/json; charset=utf-8");
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit;
}

$conn->query("CREATE DATABASE IF NOT EXISTS `$dbName`");
if (!$conn->select_db($dbName)) {
    header("Content-Type: application/json; charset=utf-8");
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Unable to select database."]);
    exit;
}

$conn->set_charset("utf8mb4");

$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    event_type VARCHAR(100) NOT NULL,
    event_date DATE NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
