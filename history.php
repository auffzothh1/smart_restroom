<?php
include 'config.php';
include 'includes/auth.php';
$pageTitle = "History";
$activePage = "history";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>History</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="layout">
    <?php include 'includes/sidebar.php'; ?>
    <div class="main">
        <?php include 'includes/topbar.php'; ?>
        <div class="content">
            <div class="panel full">
                <h3> Full History</h3>
                <table id="historyTableFull">
                    <tr><th>Time</th><th>Soap</th><th>Waste</th><th>Status</th></tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="assets/script.js"></script>
</body>
</html>