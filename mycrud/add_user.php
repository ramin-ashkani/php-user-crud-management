<?php
require_once __DIR__ . "/includes/constant.php";

$msg = $_GET['msg'] ?? "";
$msg_type = $_GET['type'] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Add New User</h2>
        <a href="index.php" class="btn btn-secondary">Back to List</a>
    </div>

    <?php if ($msg): ?>
        <div class="message <?php echo e($msg_type); ?>"><?php echo e($msg); ?></div>
    <?php endif; ?>

    <form method="post" action="includes/add_user_process.php" class="user-form">
        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">

        <div class="form-group">
            <label for="name">Full Name *</label>
            <input type="text" id="name" name="name" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="tel" id="phone" name="phone" required maxlength="20">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-add">Save User</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>