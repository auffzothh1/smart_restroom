<?php
include 'config.php';
include 'includes/auth.php';
$pageTitle = "Dashboard";
$activePage = "dashboard";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Smart Restroom Monitoring</title>
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
                <div class="card">
                    <h3> Soap Level</h3>
                    <p id="soapVal">--%</p>
                    <span id="soapStatusText" class="tag">--</span>
                    <div class="bar"><div id="soapBar" class="fill soap"></div></div>
                </div>
                <div class="card">
                    <h3>Waste Level</h3>
                    <p id="wasteVal">--%</p>
                    <span id="wasteStatusText" class="tag">--</span>
                    <div class="bar"><div id="wasteBar" class="fill waste"></div></div>
                </div>
                <div class="card">
                    <h3>System Status</h3>
                    <p id="statusIcon">✔️</p>
                    <span id="statusVal" class="tag">System Normal</span>
                </div>
                <div class="card">
                    <h3>Last Updated</h3>
                    <p id="clockBig">--:--</p>
                    <span id="dateVal" class="tag">--</span>
                </div>
            </div>

            <div class="chart-row">
                <div class="chart-box">
                    <h3>Soap Level (Real-time)</h3>
                    <canvas id="soapChart"></canvas>
                </div>
                <div class="chart-box">
                    <h3>Waste Level (Real-time)</h3>
                    <canvas id="wasteChart"></canvas>
                </div>
            </div>

            <div class="bottom-row">
                <div class="panel">
                    <h3>Alerts</h3>
                    <ul id="alertList"></ul>
                </div>
                <div class="panel">
                    <h3>IoT Device (Prototype View)</h3>
                    <div class="device-row">
                        <div class="device-box"><br>Smart Soap Dispenser</div>
                        <div class="device-box"><br>Smart Waste Bin</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="assets/script.js"></script>
</body>
</html>