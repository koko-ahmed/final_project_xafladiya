<?php
// Header Template
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';

// Get current page for active state
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<!-- Header Component -->
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $base_path; ?>index.php">
                <img src="<?php echo $base_path; ?>assets/images/logo/Xafladiya Logo_1.png" alt="Xafladia Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-home <?php echo $current_page === 'index' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>index.php" data-i18n="nav_home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-events <?php echo $current_page === 'events' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>pages/events.php" data-i18n="nav_events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-services <?php echo $current_page === 'services' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>pages/services.php" data-i18n="nav_services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-about <?php echo $current_page === 'about' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>pages/about.php" data-i18n="nav_about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-gallery <?php echo $current_page === 'gallery' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>pages/gallery.php" data-i18n="nav_gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-cameraman <?php echo $current_page === 'cameraman' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>pages/cameraman.php" data-i18n="nav_cameraman">CameraMan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-hotels <?php echo $current_page === 'hotels' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>pages/hotels.php" data-i18n="nav_hotels">Hotels</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-contact <?php echo $current_page === 'contact' ? 'active' : ''; ?>" href="<?php echo $base_path; ?>pages/contact.php" data-i18n="nav_contact">Contact</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <!-- Language Switcher -->
                    <div class="language-switcher me-3">
                        <button class="btn btn-sm language-btn" data-language="en">EN</button>
                        <button class="btn btn-sm language-btn" data-language="so">SO</button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Custom CSS -->
<style>
.navbar {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.navbar-brand img {
    transition: transform 0.3s ease;
}

.navbar-brand:hover img {
    transform: scale(1.05);
}

.nav-link {
    position: relative;
    padding: 0.5rem 1rem;
    transition: color 0.3s ease;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: var(--primary-gradient);
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.nav-link:hover::after,
.nav-link.active::after {
    width: 80%;
}

.language-btn {
    background: transparent;
    border: 1px solid #ddd;
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.language-btn:hover,
.language-btn.active {
    background: var(--primary-gradient);
    color: white;
    border-color: transparent;
}

/* Dark Mode Styles */
body.dark-mode .navbar {
    background-color: #1a1a1a !important;
}

body.dark-mode .navbar-light .navbar-nav .nav-link {
    color: #ffffff;
}

body.dark-mode .navbar-light .navbar-toggler {
    border-color: rgba(255, 255, 255, 0.1);
}

body.dark-mode .navbar-light .navbar-toggler-icon {
    filter: invert(1);
}

body.dark-mode .language-btn {
    border-color: #404040;
    color: #ffffff;
}
</style> 