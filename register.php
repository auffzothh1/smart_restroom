<?php
include 'config.php';
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($name === "" || $email === "" || $password === "") {
        $error = "Please fill in all fields!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters!";
    } else {
        // check if email already registered
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed);

            if ($stmt->execute()) {
                $success = "Account created successfully! You can now login.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - Smart Restroom Monitoring</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body class="login-body">

<div class="login-wrapper">
    <div class="login-left">
        <div class="brand-icons"></div>
        <h1>Smart Restroom Monitoring</h1>
        <p>An IoT-based system designed to monitor soap and waste levels in real-time.</p>
        <ul class="features">
            <li>Real-time monitoring</li>
            <li>Smart maintenance alerts</li>
            <li>Reduce unnecessary checking</li>
        </ul>
    </div>
    <div class="login-right">
        <h2>Create Account</h2>
        <p class="sub">Register to access the monitoring dashboard.</p>

        <?php if ($error): ?>
            <div class="alert-error"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert-success"><?= $success ?> <a href="login.php">Login here</a>.</div>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="Enter your full name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>

            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Re-enter your password" required>

            <button type="submit">REGISTER</button>
        </form>
        <?php endif; ?>

        <p class="footer-text">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</div>

</body>
</html>