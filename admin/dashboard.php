<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/session_config.php';
require_once __DIR__ . '/../includes/admin_auth.php';
require_once __DIR__ . '/../includes/header.php';
?>

<style>
.btn-primary {
    background-color: #28a745; /* Green color */
    border-color: #28a745; /* Green color */
}
.btn-primary:hover {
    background-color: #218838;
    border-color: #1e7e34;
}
</style>

<div class="container mt-5">
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Venues</h5>
                    <p class="card-text">Add, edit, or delete venue information.</p>
                    <a href="<?php echo get_url('admin/venue/dashboard.php'); ?>" class="btn btn-primary">Go to Venues</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Photographers</h5>
                    <p class="card-text">Add, edit, or delete photographer profiles.</p>
                    <a href="<?php echo get_url('admin/photographers/dashboard.php'); ?>" class="btn btn-primary">Go to Photographers</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Bookings</h5>
                    <p class="card-text">View and manage photographer bookings.</p>
                    <a href="<?php echo get_url('admin/booking/dashboard.php'); ?>" class="btn btn-primary">Go to Bookings</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?> 