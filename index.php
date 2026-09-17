<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Smart Restroom Monitoring System</title>
<link rel="stylesheet" href="assets/style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
</head>
<body>

<div class="topbar">
    <h1>Smart Restroom Monitoring System</h1>
    <span id="clock"></span>
</div>

<div class="container">

    <div class="cards">
        <div class="card">
            <h3> Soap Level</h3>
            <p id="soapVal">--%</p>
            <div class="bar"><div id="soapBar" class="fill soap"></div></div>
        </div>
        <div class="card">
            <h3> Waste Level</h3>
            <p id="wasteVal">--%</p>
            <div class="bar"><div id="wasteBar" class="fill waste"></div></div>
        </div>
        <div class="card status">
            <h3>System Status</h3>
            <p id="statusVal">Loading...</p>
        </div>
    </div>

    <div class="chart-box">
        <canvas id="trendChart"></canvas>
    </div>

    <div class="bottom-row">
        <div class="panel">
            <h3>Alerts</h3>
            <ul id="alertList"></ul>
        </div>
        <div class="panel">
            <h3>History</h3>
            <table id="historyTable">
                <tr><th>Time</th><th>Soap</th><th>Waste</th><th>Status</th></tr>
            </table>
        </div>
    </div>

</div>

<script>
const soapChartData = [];
const wasteChartData = [];
const labels = [];

const ctx = document.getElementById('trendChart').getContext('2d');
const trendChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            { label: 'Soap Level (%)', data: soapChartData, borderColor: '#3b82f6', tension: 0.3 },
            { label: 'Waste Level (%)', data: wasteChartData, borderColor: '#f59e0b', tension: 0.3 }
        ]
    },
    options: { scales: { y: { min:0, max:100 } } }
});

function loadData(){
    fetch('api/get_data.php')
    .then(res => res.json())
    .then(data => {
        const latest = data.latest;
        if(latest){
            document.getElementById('soapVal').innerText = latest.soap_level + '%';
            document.getElementById('wasteVal').innerText = latest.waste_level + '%';
            document.getElementById('soapBar').style.width = latest.soap_level + '%';
            document.getElementById('wasteBar').style.width = latest.waste_level + '%';
            document.getElementById('statusVal').innerText = latest.status;
        }

        // history table
        let table = `<tr><th>Time</th><th>Soap</th><th>Waste</th><th>Status</th></tr>`;
        data.history.forEach(row => {
            table += `<tr><td>${row.created_at}</td><td>${row.soap_level}%</td><td>${row.waste_level}%</td><td>${row.status}</td></tr>`;
        });
        document.getElementById('historyTable').innerHTML = table;

        // alerts
        let alertHTML = '';
        data.alerts.forEach(a => {
            alertHTML += `<li><b>${a.type}</b>: ${a.message} <span class="time">${a.created_at}</span></li>`;
        });
        document.getElementById('alertList').innerHTML = alertHTML || '<li>No alerts</li>';

        // chart update
        labels.length = 0; soapChartData.length = 0; wasteChartData.length = 0;
        data.history.slice().reverse().forEach(row => {
            labels.push(row.created_at.split(' ')[1]);
            soapChartData.push(row.soap_level);
            wasteChartData.push(row.waste_level);
        });
        trendChart.update();
    });
}

function updateClock(){
    document.getElementById('clock').innerText = new Date().toLocaleString();
}

loadData();
setInterval(loadData, 5000); // auto refresh 5 second
setInterval(updateClock, 1000);
</script>

</body>
</html>