<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/db.php';

// Get the current page name for active state, defaulting to an empty string if not set
$current_page = isset($current_page) ? $current_page : '';

if (!isset($page_title)) {
    $page_title = $site_name . ' - ' . $site_description;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_message'], $_POST['booking_id'])) {
    $booking_id = (int)$_POST['booking_id'];
    $admin_message = mysqli_real_escape_string($db, $_POST['admin_message']);
    $update_query = "UPDATE photographer_bookings SET message = '$admin_message' WHERE id = $booking_id";
    if (mysqli_query($db, $update_query)) {
        $message = 'Message updated successfully.';
        $message_type = 'success';
    } else {
        $message = 'Error updating message: ' . mysqli_error($db);
        $message_type = 'danger';
    }
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
                <!-- Close button for mobile menu -->
                <div class="d-flex justify-content-end p-3 d-lg-none">
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
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
                        <li class="nav-item ms-3">
                            <!-- Cart Icon with Badge -->
                            <a class="nav-link position-relative" href="#" id="cartIcon" data-bs-toggle="modal" data-bs-target="#cartModal">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count-badge" style="font-size:0.7rem;">
                                    <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                                </span>
                            </a>
                        </li>
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
                            <a class="nav-link btn btn-login px-3" href="<?php echo get_url('pages/login.php'); ?>">Login</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="nav-link btn btn-register px-3" href="<?php echo get_url('pages/register.php'); ?>">Register</a>
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
        var closeButton = navbarCollapse.querySelector('.btn-close');

        // Function to toggle menu and body scroll lock
        function toggleMobileMenu() {
            navbarCollapse.classList.toggle('show');
            navbarToggler.setAttribute('aria-expanded', navbarCollapse.classList.contains('show'));
            
            // Toggle body scroll lock
            if (navbarCollapse.classList.contains('show')) {
                document.body.style.overflow = 'hidden';
                // Add a small delay before showing the close button for smooth transition
                setTimeout(() => {
                    navbarToggler.style.opacity = '0';
                    setTimeout(() => {
                        navbarToggler.style.display = 'none';
                    }, 300);
                }, 100);
            } else {
                document.body.style.overflow = '';
                navbarToggler.style.display = 'block';
                setTimeout(() => {
                    navbarToggler.style.opacity = '1';
                }, 50);
            }
        }

        // Open/Close menu via hamburger toggler
        navbarToggler.addEventListener('click', function() {
            toggleMobileMenu();
        });

        // Close menu via close button
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                toggleMobileMenu();
            });
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            var isClickInsideNavbar = navbarCollapse.contains(event.target);
            var isClickOnToggler = navbarToggler.contains(event.target);
            var isClickOnCloseButton = closeButton && closeButton.contains(event.target);

            if (!isClickInsideNavbar && !isClickOnToggler && !isClickOnCloseButton && navbarCollapse.classList.contains('show')) {
                toggleMobileMenu();
            }
        });

        // Close dropdowns when mobile menu closes
        navbarCollapse.addEventListener('hide.bs.collapse', function () {
            var openDropdowns = navbarCollapse.querySelectorAll('.dropdown-menu.show');
            openDropdowns.forEach(function(dropdown) {
                var dropdownInstance = bootstrap.Dropdown.getInstance(dropdown.previousElementSibling);
                if (dropdownInstance) {
                    dropdownInstance.hide();
                }
            });
        });
    });
    </script>

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cartModalLabel">My Cart</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="cart-modal-body">
            <!-- Cart items will be loaded here dynamically -->
          </div>
          <div class="modal-footer">
            <a href="<?php echo get_url('pages/mybookings.php'); ?>" class="btn btn-outline-primary">View Full Cart</a>
            <button type="button" class="btn btn-success" id="proceed-to-confirmation">Proceed to Confirmation</button>
          </div>
        </div>
      </div>
    </div>
</body>
</html>
