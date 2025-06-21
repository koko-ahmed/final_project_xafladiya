<?php
// Debug: Show session info
echo '<pre style="position:absolute;z-index:9999;background:#fff;color:#000;">';
print_r($_SESSION);
echo '</pre>';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="<?php echo $is_home ? 'index.php' : '../../index.php'; ?>">
      <img src="<?php echo $is_home ? 'assets/images/logo/Xafladiya Logo_1.png' : '../../assets/images/logo/Xafladiya Logo_1.png'; ?>" alt="Xafladiya Logo" height="40" id="navbar-logo" />
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
        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item dropdown ms-3">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle me-1"></i><?php echo htmlspecialchars($_SESSION['username'] ?? $_SESSION['email']); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="<?php echo $is_home ? 'pages/profile.php' : '../profile.php'; ?>"><i class="fas fa-user me-2"></i>Profile</a></li>
              <li><a class="dropdown-item" href="<?php echo $is_home ? 'pages/mybookings.php' : '../mybookings.php'; ?>"><i class="fas fa-calendar-alt me-2"></i>My Bookings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="<?php echo $is_home ? 'includes/logout.php' : '../includes/logout.php'; ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item ms-3">
            <a class="nav-link btn btn-outline-primary px-3" href="<?php echo $is_home ? 'pages/login.php' : '../login.php'; ?>">Login</a>
          </li>
          <li class="nav-item ms-2">
            <a class="nav-link btn btn-primary px-3" href="<?php echo $is_home ? 'pages/register.php' : '../register.php'; ?>">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav> 