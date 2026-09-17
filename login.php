<?php
include 'config.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Smart Restroom Monitoring</title>
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
        <h2>Welcome Back!</h2>
        <p class="sub">Login to access the monitoring dashboard.</p>

        <?php if ($error): ?>
            <div class="alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">

            <label>Email</label>
            <input
                type="email"
                name="email"
                placeholder="Enter your email"
                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                required
            >

            <label>Password</label>

            <div class="password-wrapper">
                <input
                    type="password"
                    name="password"
                    id="passwordField"
                    placeholder="Enter your password"
                    required
                >

            </div>

            <button type="submit">LOGIN</button>
        </form>

        <p class="footer-text">
            Don't have an account?
            <a href="register.php">Register here</a>
        </p>
    </div>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('passwordField');

    togglePassword.addEventListener('click', function () {
        const isPassword = passwordField.type === 'password';

        passwordField.type = isPassword ? 'text' : 'password';
        togglePassword.textContent = isPassword ? 'HIDE' : 'SHOW';
    });
</script>

</body>
</html>