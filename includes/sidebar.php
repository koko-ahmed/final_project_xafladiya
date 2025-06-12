<?php
// Get current page for active state
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>" 
                   href="<?php echo get_url('admin/dashboard.php'); ?>">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($current_page, 'events') !== false ? 'active' : ''; ?>" 
                   href="<?php echo get_url('admin/events/dashboard.php'); ?>">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Events
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($current_page, 'venue') !== false ? 'active' : ''; ?>" 
                   href="<?php echo get_url('admin/venue/dashboard.php'); ?>">
                    <i class="fas fa-hotel me-2"></i>
                    Venues
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($current_page, 'photographers') !== false ? 'active' : ''; ?>" 
                   href="<?php echo get_url('admin/photographers/dashboard.php'); ?>">
                    <i class="fas fa-camera me-2"></i>
                    Photographers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($current_page, 'booking') !== false ? 'active' : ''; ?>" 
                   href="<?php echo get_url('admin/booking/dashboard.php'); ?>">
                    <i class="fas fa-bookmark me-2"></i>
                    Bookings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($current_page, 'user') !== false ? 'active' : ''; ?>" 
                   href="<?php echo get_url('admin/user/dashboard.php'); ?>">
                    <i class="fas fa-users me-2"></i>
                    Users
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Account</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo get_url('includes/logout.php'); ?>">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</nav> 