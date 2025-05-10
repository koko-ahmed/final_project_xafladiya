<?php
require_once __DIR__ . '/../config/config.php';

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
    <link rel="icon" href="<?php echo get_url('assets/images/logo/logo-icon.png'); ?>" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo get_url('assets/css/style.css'); ?>" />
</head>
<body>
    <!-- Alert Container -->
    <div class="alert-container position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo get_url('index.php'); ?>">
                <img src="<?php echo get_url('assets/images/logo/logo.png'); ?>" alt="<?php echo $site_name; ?>" height="40" />
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="main-content">
        <!-- Add padding to account for fixed navbar -->
        <div style="padding-top: 76px;">
        </div>
    </main>
</body>
</html> 