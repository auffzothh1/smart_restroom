//Sidebar toggle (mobile)
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
}

//Clock 
function updateClock() {
    const now = new Date();
    const clockEl = document.getElementById('clock');
    const clockBigEl = document.getElementById('clockBig');
    const dateEl = document.getElementById('dateVal');
    if (clockEl) clockEl.innerText = now.toLocaleTimeString();
    if (clockBigEl) clockBigEl.innerText = now.toLocaleTimeString().slice(0,5);
    if (dateEl) dateEl.innerText = now.toLocaleDateString();
}
setInterval(updateClock, 1000);
updateClock();

// Dashboard page
if (document.getElementById('soapVal')) {
    const soapCtx = document.getElementById('soapChart').getContext('2d');
    const wasteCtx = document.getElementById('wasteChart').getContext('2d');

    const soapChart = new Chart(soapCtx, { type:'line', data:{ labels:[], datasets:[{label:'Soap Level',data:[],borderColor:'#3b82f6',backgroundColor:'rgba(59,130,246,0.1)',fill:true,tension:0.3}] }, options:{ scales:{ y:{min:0,max:100} } } });
    const wasteChart = new Chart(wasteCtx, { type:'line', data:{ labels:[], datasets:[{label:'Waste Level',data:[],borderColor:'#f59e0b',backgroundColor:'rgba(245,158,11,0.1)',fill:true,tension:0.3}] }, options:{ scales:{ y:{min:0,max:100} } } });

    function loadDashboard() {
        fetch('api/get_data.php?limit=10').then(r=>r.json()).then(data=>{
            const latest = data.latest;
            if (latest) {
                document.getElementById('soapVal').innerText = latest.soap_level + '%';
                document.getElementById('wasteVal').innerText = latest.waste_level + '%';
                document.getElementById('soapBar').style.width = latest.soap_level + '%';
                document.getElementById('wasteBar').style.width = latest.waste_level + '%';
                document.getElementById('statusVal').innerText = latest.status;
                document.getElementById('soapStatusText').innerText = latest.soap_level < 20 ? 'Low' : 'Good';
                document.getElementById('wasteStatusText').innerText = latest.waste_level > 80 ? 'High' : 'Moderate';
            }
            let alertHTML = '';
            data.alerts.forEach(a => { alertHTML += `<li><b>${a.type}</b>: ${a.message} <span class="time">${a.created_at}</span></li>`; });
            document.getElementById('alertList').innerHTML = alertHTML || '<li>No alerts</li>';

            const rev = data.history.slice().reverse();
            soapChart.data.labels = rev.map(r => r.created_at.split(' ')[1]);
            soapChart.data.datasets[0].data = rev.map(r => r.soap_level);
            wasteChart.data.labels = soapChart.data.labels;
            wasteChart.data.datasets[0].data = rev.map(r => r.waste_level);
            soapChart.update(); wasteChart.update();
        });
    }
    loadDashboard();
    setInterval(loadDashboard, 5000);
}

//Soap Monitoring page 
if (document.getElementById('soapValBig')) {
    const ctx = document.getElementById('soapChartFull').getContext('2d');
    const chart = new Chart(ctx, { type:'line', data:{ labels:[], datasets:[{label:'Soap Level',data:[],borderColor:'#3b82f6',fill:true,backgroundColor:'rgba(59,130,246,0.1)',tension:0.3}] }, options:{ scales:{ y:{min:0,max:100} } } });

    function loadSoap() {
        fetch('api/get_data.php?limit=20').then(r=>r.json()).then(data=>{
            const latest = data.latest;
            if (latest) {
                document.getElementById('soapValBig').innerText = latest.soap_level + '%';
                document.getElementById('soapBarBig').style.width = latest.soap_level + '%';
                document.getElementById('soapStatusBig').innerText = latest.soap_level < 20 ? 'Low - Need Refill' : 'Good';
            }
            let table = `<tr><th>Time</th><th>Level</th><th>Status</th></tr>`;
            data.history.forEach(r => { table += `<tr><td>${r.created_at}</td><td>${r.soap_level}%</td><td>${r.soap_level < 20 ? 'Low' : 'Good'}</td></tr>`; });
            document.getElementById('soapTable').innerHTML = table;

            const rev = data.history.slice().reverse();
            chart.data.labels = rev.map(r => r.created_at.split(' ')[1]);
            chart.data.datasets[0].data = rev.map(r => r.soap_level);
            chart.update();
        });
    }
    loadSoap();
    setInterval(loadSoap, 5000);
}

// Waste Monitoring page 
if (document.getElementById('wasteValBig')) {
    const ctx = document.getElementById('wasteChartFull').getContext('2d');
    const chart = new Chart(ctx, { type:'line', data:{ labels:[], datasets:[{label:'Waste Level',data:[],borderColor:'#f59e0b',fill:true,backgroundColor:'rgba(245,158,11,0.1)',tension:0.3}] }, options:{ scales:{ y:{min:0,max:100} } } });

    function loadWaste() {
        fetch('api/get_data.php?limit=20').then(r=>r.json()).then(data=>{
            const latest = data.latest;
            if (latest) {
                document.getElementById('wasteValBig').innerText = latest.waste_level + '%';
                document.getElementById('wasteBarBig').style.width = latest.waste_level + '%';
                document.getElementById('wasteStatusBig').innerText = latest.waste_level > 80 ? 'High - Need Clearing' : 'Moderate';
            }
            let table = `<tr><th>Time</th><th>Level</th><th>Status</th></tr>`;
            data.history.forEach(r => { table += `<tr><td>${r.created_at}</td><td>${r.waste_level}%</td><td>${r.waste_level > 80 ? 'High' : 'Moderate'}</td></tr>`; });
            document.getElementById('wasteTable').innerHTML = table;

            const rev = data.history.slice().reverse();
            chart.data.labels = rev.map(r => r.created_at.split(' ')[1]);
            chart.data.datasets[0].data = rev.map(r => r.waste_level);
            chart.update();
        });
    }
    loadWaste();
    setInterval(loadWaste, 5000);
}

// Alerts page
if (document.getElementById('alertListFull')) {
    function loadAlerts() {
        fetch('api/get_data.php?limit=50').then(r=>r.json()).then(data=>{
            let html = '';
            data.alerts.forEach(a => { html += `<li><b>${a.type}</b>: ${a.message} <span class="time">${a.created_at}</span></li>`; });
            document.getElementById('alertListFull').innerHTML = html || '<li>No alerts</li>';
        });
    }
    loadAlerts();
    setInterval(loadAlerts, 5000);
}

// History page
if (document.getElementById('historyTableFull')) {
    function loadHistory() {
        fetch('api/get_data.php?limit=50').then(r=>r.json()).then(data=>{
            let table = `<tr><th>Time</th><th>Soap</th><th>Waste</th><th>Status</th></tr>`;
            data.history.forEach(r => { table += `<tr><td>${r.created_at}</td><td>${r.soap_level}%</td><td>${r.waste_level}%</td><td>${r.status}</td></tr>`; });
            document.getElementById('historyTableFull').innerHTML = table;
        });
    }
    loadHistory();
    setInterval(loadHistory, 5000);
}