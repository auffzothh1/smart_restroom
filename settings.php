<?php
include 'config.php';
include 'includes/auth.php';
$pageTitle = "Settings";
$activePage = "settings";
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $soap_t = intval($_POST['soap_threshold']);
    $waste_t = intval($_POST['waste_threshold']);
    $stmt = $conn->prepare("UPDATE settings SET soap_threshold=?, waste_threshold=? WHERE id=1");
    $stmt->bind_param("ii", $soap_t, $waste_t);
    $stmt->execute();
    $msg = "Settings updated!";
}

$s = $conn->query("SELECT * FROM settings WHERE id=1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Settings</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="layout">
    <?php include 'includes/sidebar.php'; ?>
    <div class="main">
        <?php include 'includes/topbar.php'; ?>
        <div class="content">
            <div class="panel full">
                <h3> Alert Threshold Settings</h3>
                <?php if ($msg): ?><div class="alert-success"><?= $msg ?></div><?php endif; ?>
                <form method="POST" class="settings-form">
                    <label>Soap Alert Threshold (%) — alert when below this value</label>
                    <input type="number" name="soap_threshold" value="<?= $s['soap_threshold'] ?>" min="0" max="100" required>

                    <label>Soap Alert Threshold (%) — alert when above this value</label>
                    <input type="number" name="waste_threshold" value="<?= $s['waste_threshold'] ?>" min="0" max="100" required>

                    <button type="submit">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>