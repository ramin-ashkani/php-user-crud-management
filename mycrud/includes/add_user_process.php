<?php
require_once __DIR__ . "/constant.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_with("../add_user.php", "Invalid request method", "error");
}

if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    redirect_with("../add_user.php", "Security token validation failed", "error");
}

$name = trim($_POST['name'] ?? "");
$email = trim($_POST['email'] ?? "");
$phone = trim($_POST['phone'] ?? "");

if (empty($name) || empty($email) || empty($phone)) {
    redirect_with("../add_user.php", "All fields are required", "error");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect_with("../add_user.php", "Please enter a valid email address", "error");
}

if (strlen($name) > 100) {
    redirect_with("../add_user.php", "Name is too long (max 100 characters)", "error");
}

if (strlen($email) > 100) {
    redirect_with("../add_user.php", "Email is too long (max 100 characters)", "error");
}

if (strlen($phone) > 20) {
    redirect_with("../add_user.php", "Phone number is too long (max 20 characters)", "error");
}

try {
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);

    if ($stmt->execute()) {
        redirect_with("../index.php", "User added successfully", "success");
    } else {
        if ($conn->errno === 1062) {
            redirect_with("../add_user.php", "Email address already exists", "error");
        } else {
            redirect_with("../add_user.php", "Error: " . $conn->error, "error");
        }
    }
} catch (Exception $e) {
    redirect_with("../add_user.php", "An error occurred: " . $e->getMessage(), "error");
}
?>