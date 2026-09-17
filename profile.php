<?php
include 'config.php';
include 'includes/auth.php';
$pageTitle = "Profile";
$activePage = "";

$user = $conn->query("SELECT * FROM users WHERE id=".$_SESSION['user_id'])->fetch_assoc();
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newPass = $_POST['new_password'];
    if (!empty($newPass)) {
        $hashed = password_hash($newPass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $hashed, $_SESSION['user_id']);
        $stmt->execute();
        $msg = "Password updated!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="layout">
    <?php include 'includes/sidebar.php'; ?>
    <div class="main">
        <?php include 'includes/topbar.php'; ?>
        <div class="content">
            <div class="panel full">
                <h3> My Profile</h3>
                <?php if ($msg): ?><div class="alert-success"><?= $msg ?></div><?php endif; ?>
                <p><b>Name:</b> <?= $user['name'] ?></p>
                <p><b>Email:</b> <?= $user['email'] ?></p>
                <form method="POST" class="settings-form">
                    <label>New Password</label>
                    <input type="password" name="new_password" placeholder="Leave blank if not changing">
                    <button type="submit">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>