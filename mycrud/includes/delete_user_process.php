<?php
require_once __DIR__ . "/constant.php";

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    redirect_with("../index.php", "Invalid request method", "error");
}

if (!isset($_GET['csrf_token']) || !validate_csrf_token($_GET['csrf_token'])) {
    redirect_with("../index.php", "Security token validation failed", "error");
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    redirect_with("../index.php", "Invalid user ID", "error");
}

try {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            redirect_with("../index.php", "User deleted successfully", "success");
        } else {
            redirect_with("../index.php", "User not found", "error");
        }
    } else {
        redirect_with("../index.php", "Error: " . $conn->error, "error");
    }
} catch (Exception $e) {
    redirect_with("../index.php", "An error occurred: " . $e->getMessage(), "error");
}
?>