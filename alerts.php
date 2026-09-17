<?php
include 'config.php';
include 'includes/auth.php';
$pageTitle = "Alerts";
$activePage = "alerts";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Alerts</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="layout">
    <?php include 'includes/sidebar.php'; ?>
    <div class="main">
        <?php include 'includes/topbar.php'; ?>
        <div class="content">
            <div class="panel full">
                <h3>All Alerts</h3>
                <ul id="alertListFull"></ul>
            </div>
        </div>
    </div>
</div>
<script src="assets/script.js"></script>
</body>
</html>