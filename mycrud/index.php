<?php
require_once __DIR__ . "/includes/constant.php";

$sql = "SELECT id, name, email, phone FROM users ORDER BY id DESC";
$res = $conn->query($sql);
$users = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];

$msg = $_GET['msg'] ?? "";
$type = $_GET['type'] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="topbar">
        <h1>User Management System</h1>
        <a class="btn btn-add" href="add_user.php">+ Add User</a>
    </div>

    <?php if ($msg): ?>
        <div class="message <?php echo e($type); ?>"><?php echo e($msg); ?></div>
    <?php endif; ?>

    <?php if (count($users) === 0): ?>
        <div class="empty-state">
            <p>No users found. Add your first user!</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo e($user['id']); ?></td>
                        <td><?php echo e($user['name']); ?></td>
                        <td><?php echo e($user['email']); ?></td>
                        <td><?php echo e($user['phone']); ?></td>
                        <td class="actions">
                            <a class="btn btn-edit" href="edit_user.php?id=<?php echo (int)$user['id']; ?>">Edit</a>
                            <a class="btn btn-delete" href="includes/delete_user_process.php?id=<?php echo (int)$user['id']; ?>&csrf_token=<?php echo generate_csrf_token(); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
</body>
</html>