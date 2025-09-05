<?php
require_once __DIR__ . "/constant.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_with("../index.php", "Invalid request method", "error");
}

if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
    redirect_with("../index.php", "Security token validation failed", "error");
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = trim($_POST['name'] ?? "");
$email = trim($_POST['email'] ?? "");
$phone = trim($_POST['phone'] ?? "");

if ($id <= 0) {
    redirect_with("../index.php", "Invalid user ID", "error");
}

if (empty($name) || empty($email) || empty($phone)) {
    redirect_with("../edit_user.php?id=$id", "All fields are required", "error");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect_with("../edit_user.php?id=$id", "Please enter a valid email address", "error");
}

if (strlen($name) > 100) {
    redirect_with("../edit_user.php?id=$id", "Name is too long (max 100 characters)", "error");
}

if (strlen($email) > 100) {
    redirect_with("../edit_user.php?id=$id", "Email is too long (max 100 characters)", "error");
}

if (strlen($phone) > 20) {
    redirect_with("../edit_user.php?id=$id", "Phone number is too long (max 20 characters)", "error");
}

try {
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $phone, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            redirect_with("../index.php", "User updated successfully", "success");
        } else {
            redirect_with("../edit_user.php?id=$id", "No changes detected", "info");
        }
    } else {
        if ($conn->errno === 1062) {
            redirect_with("../edit_user.php?id=$id", "Email address already exists", "error");
        } else {
            redirect_with("../edit_user.php?id=$id", "Error: " . $conn->error, "error");
        }
    }
} catch (Exception $e) {
    redirect_with("../edit_user.php?id=$id", "An error occurred: " . $e->getMessage(), "error");
}
?>