<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/session_config.php';
require_once __DIR__ . '/../includes/admin_auth.php';
require_once __DIR__ . '/../includes/db.php'; // Ensure db connection is available if needed
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

            <?php if (isset($_GET['section']) && $_GET['section'] === 'users'): ?>
                <!-- Users Table Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card modern-card">
                            <div class="card-body">
                                <h5 class="card-title modern-title">Registered Users</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT id, username, email, created_at FROM users";
                                            $result = mysqli_query($db, $sql);
                                            if ($result && mysqli_num_rows($result) > 0):
                                                while($row = mysqli_fetch_assoc($result)):
                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                                </tr>
                                            <?php
                                                endwhile;
                                            else:
                                            ?>
                                                <tr><td colspan="4">No users found.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
            <div class="row mt-4">
                <div class="col-md-4 mb-4">
                    <div class="card modern-card">
                        <div class="card-body">
                            <h5 class="card-title modern-title">Manage Venues</h5>
                            <p class="card-text modern-text">Add, edit, or delete venue information.</p>
                            <a href="<?php echo get_url('admin/venue/dashboard.php'); ?>" class="btn modern-btn" style="background: linear-gradient(to right, #6f42c1, #fd7e14); color: white;">Go to Venues</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card modern-card">
                        <div class="card-body">
                            <h5 class="card-title modern-title">Manage Events</h5>
                            <p class="card-text modern-text">Add, edit, or delete event information.</p>
                            <a href="<?php echo get_url('admin/events/dashboard.php'); ?>" class="btn modern-btn" style="background: linear-gradient(to right, #6f42c1, #fd7e14); color: white;">Go to Events</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card modern-card">
                        <div class="card-body">
                            <h5 class="card-title modern-title">Manage Photographers</h5>
                            <p class="card-text modern-text">Add, edit, or delete photographer profiles.</p>
                            <a href="<?php echo get_url('admin/photographers/dashboard.php'); ?>" class="btn modern-btn" style="background: linear-gradient(to right, #6f42c1, #fd7e14); color: white;">Go to Photographers</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card modern-card">
                        <div class="card-body">
                            <h5 class="card-title modern-title">Manage Bookings</h5>
                            <p class="card-text modern-text">View and manage photographer bookings.</p>
                            <a href="<?php echo get_url('admin/booking/dashboard.php'); ?>" class="btn modern-btn" style="background: linear-gradient(to right, #6f42c1, #fd7e14); color: white;">Go to Bookings</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?> 