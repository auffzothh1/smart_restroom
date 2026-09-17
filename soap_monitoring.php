<?php
include 'config.php';
include 'includes/auth.php';
$pageTitle = "Soap Monitoring";
$activePage = "soap";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Soap Monitoring</title>
<link rel="stylesheet" href="assets/style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
</head>
<body>
<div class="layout">
    <?php include 'includes/sidebar.php'; ?>
    <div class="main">
        <?php include 'includes/topbar.php'; ?>
        <div class="content">
            <div class="cards">
                <div class="card wide">
                    <h3> Current Soap Level</h3>
                    <p id="soapValBig" class="big-num">--%</p>
                    <div class="bar"><div id="soapBarBig" class="fill soap"></div></div>
                    <span id="soapStatusBig" class="tag">--</span>
                </div>
            </div>
            <div class="chart-box full">
                <h3>Soap Level History</h3>
                <canvas id="soapChartFull"></canvas>
            </div>
            <div class="panel">
                <h3>Soap Reading Log</h3>
                <table id="soapTable"><tr><th>Time</th><th>Level</th><th>Status</th></tr></table>
            </div>
        </div>
    </div>
</div>
<script src="assets/script.js"></script>
</body>
</html>