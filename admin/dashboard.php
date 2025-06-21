<?php // Main admin dashboard file
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/session_config.php';
require_once __DIR__ . '/../includes/admin_auth.php';
require_once __DIR__ . '/../includes/db.php'; // Ensure db connection is available if needed

// Dashboard statistics
$venue_count = $event_count = $photographer_count = $booking_count = 0;
$events_per_hour = array_fill(0, 24, 0); // 0-23 hours
$event_types = [];

// Total venues
$res = mysqli_query($db, "SELECT COUNT(*) as total FROM venues");
if ($res && $row = mysqli_fetch_assoc($res)) $venue_count = (int)$row['total'];
// Total events
$res = mysqli_query($db, "SELECT COUNT(*) as total FROM events");
if ($res && $row = mysqli_fetch_assoc($res)) $event_count = (int)$row['total'];
// Total photographers
$res = mysqli_query($db, "SELECT COUNT(*) as total FROM photographers");
if ($res && $row = mysqli_fetch_assoc($res)) $photographer_count = (int)$row['total'];
// Total bookings
$res = mysqli_query($db, "SELECT COUNT(*) as total FROM bookings");
if ($res && $row = mysqli_fetch_assoc($res)) $booking_count = (int)$row['total'];

// Events per hour
$res = mysqli_query($db, "SELECT HOUR(event_time) as hour, COUNT(*) as count FROM events WHERE event_time IS NOT NULL GROUP BY hour");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $h = (int)$row['hour'];
        $events_per_hour[$h] = (int)$row['count'];
    }
}
// Events per type
$res = mysqli_query($db, "SELECT type, COUNT(*) as count FROM events GROUP BY type");
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $event_types[$row['type']] = (int)$row['count'];
    }
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mt-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Admin Dashboard</h1>
            </div>

            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

            <!-- Dashboard Widgets -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-primary h-100 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Venues</h5>
                            <p class="card-text display-6 fw-bold"><?php echo $venue_count; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-success h-100 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Events</h5>
                            <p class="card-text display-6 fw-bold"><?php echo $event_count; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-info h-100 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Photographers</h5>
                            <p class="card-text display-6 fw-bold"><?php echo $photographer_count; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-warning h-100 shadow">
                        <div class="card-body">
                            <h5 class="card-title">Bookings</h5>
                            <p class="card-text display-6 fw-bold"><?php echo $booking_count; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Charts Row -->
            <div class="row mb-4">
                <div class="col-lg-8 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Events Per Hour</h5>
                            <canvas id="eventsPerHourChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Event Types</h5>
                            <canvas id="eventTypesChart" height="220"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of dashboard content -->
        </main>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Events per hour data from PHP
const eventsPerHour = <?php echo json_encode(array_values($events_per_hour)); ?>;
const hourLabels = [...Array(24).keys()].map(h => h.toString().padStart(2, '0')+':00');
// Event types data from PHP
const eventTypes = <?php echo json_encode(array_keys($event_types)); ?>;
const eventTypeCounts = <?php echo json_encode(array_values($event_types)); ?>;
// Line Chart: Events per hour
new Chart(document.getElementById('eventsPerHourChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: hourLabels,
        datasets: [{
            label: 'Events',
            data: eventsPerHour,
            backgroundColor: 'rgba(79,70,229,0.1)',
            borderColor: 'rgba(79,70,229,1)',
            borderWidth: 2,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
// Doughnut Chart: Event types
new Chart(document.getElementById('eventTypesChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: eventTypes,
        datasets: [{
            data: eventTypeCounts,
            backgroundColor: [
                '#4f46e5','#0ea5e9','#fd7e14','#6f42c1','#22c55e','#f59e42','#e11d48','#6366f1','#fbbf24','#14b8a6'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?> 