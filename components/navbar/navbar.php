<?php
// Get the current page name for active state
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="<?php echo $is_home ? 'index.php' : '../../index.php'; ?>">
      <img src="<?php echo $is_home ? 'assets/images/logo/logo.png' : '../../assets/images/logo/logo.png'; ?>" alt="Xafladiya Logo" height="40" id="navbar-logo" />
    </a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page === 'index' ? 'active' : ''; ?>" href="<?php echo $is_home ? 'index.php' : '../../index.php'; ?>" id="nav-home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page === 'about' ? 'active' : ''; ?>" href="<?php echo $is_home ? 'pages/about.php' : '../about.php'; ?>" id="nav-about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page === 'services' ? 'active' : ''; ?>" href="<?php echo $is_home ? 'pages/services.php' : '../services.php'; ?>" id="nav-services">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page === 'events' ? 'active' : ''; ?>" href="<?php echo $is_home ? 'pages/events.php' : '../events.php'; ?>" id="nav-events">Events</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page === 'hotels' ? 'active' : ''; ?>" href="<?php echo $is_home ? 'pages/hotels.php' : '../hotels.php'; ?>" id="nav-hotels">Hotels</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page === 'cameraman' ? 'active' : ''; ?>" href="<?php echo $is_home ? 'pages/cameraman.php' : '../cameraman.php'; ?>" id="nav-cameraman">Cameraman</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page === 'gallery' ? 'active' : ''; ?>" href="<?php echo $is_home ? 'pages/gallery.php' : '../gallery.php'; ?>" id="nav-gallery">Gallery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page === 'contact' ? 'active' : ''; ?>" href="<?php echo $is_home ? 'pages/contact.php' : '../contact.php'; ?>" id="nav-contact">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page === 'login' ? 'active' : ''; ?>" href="<?php echo $is_home ? 'pages/login.php' : '../login.php'; ?>" id="nav-login">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav> 