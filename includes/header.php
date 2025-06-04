<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/db.php';

// Get the current page name for active state, defaulting to an empty string if not set
$current_page = isset($current_page) ? $current_page : '';

if (!isset($page_title)) {
    $page_title = $site_name . ' - ' . $site_description;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($page_title) ? $page_title : $site_name . ' - ' . $site_description; ?></title>
    <link rel="icon" href="<?php echo get_url('assets/images/logo/Xafladiya Logo_10.png'); ?>" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo get_url('assets/css/style.css'); ?>" />
</head>
<body>
    <!-- Alert Container -->
    <div class="alert-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <?php
        if(isset($_SESSION['message'])) {
            echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
            echo $_SESSION['message'];
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
            unset($_SESSION['message']);
        }
        ?>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo get_url('index.php'); ?>">
                <img src="<?php echo get_url('assets/images/logo/Xafladiya Logo_1.png'); ?>" alt="<?php echo $site_name; ?>" height="40" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo get_url('index.php'); ?>">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php if (in_array($current_page, ['services', 'events', 'hotels', 'cameraman'])) echo 'active'; ?>" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">All Services</a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item<?php if ($current_page === 'services') echo ' active'; ?>" href="<?php echo get_url('pages/services.php'); ?>">Services</a></li>
                            <li><a class="dropdown-item<?php if ($current_page === 'events') echo ' active'; ?>" href="<?php echo get_url('pages/events.php'); ?>">Events</a></li>
                            <li><a class="dropdown-item<?php if ($current_page === 'hotels') echo ' active'; ?>" href="<?php echo get_url('pages/hotels.php'); ?>">Hotels</a></li>
                            <li><a class="dropdown-item<?php if ($current_page === 'cameraman') echo ' active'; ?>" href="<?php echo get_url('pages/cameraman.php'); ?>">Cameraman</a></li>
                        </ul>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="nav-link custom-navbar-link<?php if ($current_page === 'about') echo ' active'; ?>" href="<?php echo get_url('pages/about.php'); ?>">About</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="nav-link custom-navbar-link<?php if ($current_page === 'contact') echo ' active'; ?>" href="<?php echo get_url('pages/contact.php'); ?>">Contact</a>
                    </li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i><?php echo htmlspecialchars($_SESSION['username'] ?? $_SESSION['email']); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?php echo get_url('pages/profile.php'); ?>"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="<?php echo get_url('pages/mybookings.php'); ?>"><i class="fas fa-calendar-alt me-2"></i>My Bookings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?php echo get_url('includes/logout.php'); ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-3">
                            <a class="nav-link btn btn-outline-primary px-3" href="<?php echo get_url('pages/login.php'); ?>">Login</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="nav-link btn btn-primary px-3" href="<?php echo get_url('pages/register.php'); ?>">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS (required for dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS for dropdown functionality -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all dropdowns
        var dropdownTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
        var dropdownList = dropdownTriggerList.map(function(dropdownTriggerEl) {
            return new bootstrap.Dropdown(dropdownTriggerEl);
        });

        // Handle dropdown item clicks
        document.querySelectorAll('.dropdown-item').forEach(function(item) {
            item.addEventListener('click', function(e) {
                var dropdown = bootstrap.Dropdown.getInstance(this.closest('.dropdown').querySelector('.dropdown-toggle'));
                if (dropdown) {
                    dropdown.hide();
                }
            });
        });

        // Handle mobile menu
        var navbarCollapse = document.querySelector('.navbar-collapse');
        var navbarToggler = document.querySelector('.navbar-toggler');

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            var isClickInside = navbarCollapse.contains(event.target) || navbarToggler.contains(event.target);
            if (!isClickInside && navbarCollapse.classList.contains('show')) {
                navbarCollapse.classList.remove('show');
            }
        });
    });
    </script>
</body>
</html>
