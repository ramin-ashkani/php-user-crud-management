<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db_name = "my_crud";

// Create connection
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$create_db_sql = "CREATE DATABASE IF NOT EXISTS $db_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($create_db_sql) === TRUE) {
    // Select database
    $conn->select_db($db_name);

    // Create table if not exists
    $create_table_sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if (!$conn->query($create_table_sql)) {
        die("Error creating table: " . $conn->error);
    }
} else {
    die("Error creating database: " . $conn->error);
}

$conn->set_charset("utf8mb4");

// Escape output function
function e($str) {
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

// Redirect with message function
function redirect_with($url, $msg = "", $type = "success") {
    $params = [];
    if ($msg !== "")  $params[] = "msg=" . urlencode($msg);
    if ($type !== "") $params[] = "type=" . urlencode($type);

    $separator = strpos($url, '?') === false ? '?' : '&';
    $url .= $params ? $separator . implode('&', $params) : '';

    header("Location: $url");
    exit;
}

// CSRF Protection Functions
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>