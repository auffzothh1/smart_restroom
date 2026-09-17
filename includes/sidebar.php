<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <span class="icon"></span>
        <div>Smart Monitoring<br>System</div>
    </div>
    <nav>
        <a href="dashboard.php" class="<?= $activePage=='dashboard'?'active':'' ?>"> Dashboard</a>
        <a href="soap_monitoring.php" class="<?= $activePage=='soap'?'active':'' ?>"> Soap Monitoring</a>
        <a href="waste_monitoring.php" class="<?= $activePage=='waste'?'active':'' ?>"> Waste Monitoring</a>
        <a href="alerts.php" class="<?= $activePage=='alerts'?'active':'' ?>"> Alerts</a>
        <a href="history.php" class="<?= $activePage=='history'?'active':'' ?>"> History</a>
        <a href="settings.php" class="<?= $activePage=='settings'?'active':'' ?>"> Settings</a>
    </nav>
    <a href="logout.php" class="logout-link"> Logout</a>
</div>