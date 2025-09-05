<?php
require_once __DIR__ . "/includes/constant.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    redirect_with("index.php", "Invalid user ID", "error");
}

$stmt = $conn->prepare("SELECT id, name, email, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    redirect_with("index.php", "User not found", "error");
}

$msg = $_GET['msg'] ?? "";
$msg_type = $_GET['type'] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Edit User</h2>
        <a href="index.php" class="btn btn-secondary">Back to List</a>
    </div>

    <?php if ($msg): ?>
        <div class="message <?php echo e($msg_type); ?>"><?php echo e($msg); ?></div>
    <?php endif; ?>

    <form method="post" action="includes/edit_user_process.php" class="user-form">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
        <input type="hidden" name="id" value="<?php echo e($user['id']); ?>">

        <div class="form-group">
            <label for="name">Full Name *</label>
            <input type="text" id="name" name="name" value="<?php echo e($user['name']); ?>" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" value="<?php echo e($user['email']); ?>" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="tel" id="phone" name="phone" value="<?php echo e($user['phone']); ?>" required maxlength="20">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-add">Update User</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>