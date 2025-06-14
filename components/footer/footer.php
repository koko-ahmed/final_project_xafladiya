<?php
// Footer Component
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';
?>

<!-- Footer -->
<footer class="footer-2025 py-5">
  <!-- Decorative elements -->
  <div class="footer-deco-circle orange"></div>
  <div class="footer-deco-circle blue"></div>

  <div class="container">
    <div class="row justify-content-between">
      <!-- Logo & Description Column -->
      <div class="col-lg-4 mb-5 mb-lg-0 footer-section">
        <div class="mb-4">
          <img
            src="<?php echo $base_path; ?>assets/images/logo/Xafladiya Logo_1.png"
            alt="Xafladia Logo"
            class="mb-4 footer-logo"
            style="
              max-width: 160px;
              filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.2));
            "
          />
          <p
            class="text-light mb-4 fw-normal"
            style="font-size: 0.95rem; line-height: 1.6; color: #ffffff"
            data-i18n="footer_description"
          >
            Your premier event planning platform in Somalia. Making special
            moments unforgettable since 2020.
          </p>
        </div>

        <!-- Social Media -->
        <div class="social-icons-wrapper d-flex gap-3 mt-4">
          <a href="https://www.facebook.com/xafladiya" class="social-icon">
            <i class="fab fa-facebook-f text-light"></i>
          </a>
          <a href="https://www.instagram.com/xafladiya" class="social-icon">
            <i class="fab fa-instagram text-light"></i>
          </a>
          <a href="https://www.twitter.com/xafladiya" class="social-icon">
            <i class="fab fa-twitter text-light"></i>
          </a>
          <a
            href="https://www.linkedin.com/company/xafladiya"
            class="social-icon"
          >
            <i class="fab fa-linkedin-in text-light"></i>
          </a>
        </div>
      </div>

      <!-- Links Columns -->
      <div class="col-lg-7">
        <div class="row">
          <!-- Quick Links -->
          <div class="col-md-4 mb-4 mb-md-0">
            <h6
              class="footer-title text-light mb-4 fw-semibold position-relative d-inline-block"
            >
              <span data-i18n="quick_links">Quick Links</span>
              <span
                style="
                  position: absolute;
                  bottom: -5px;
                  left: 0;
                  width: 30px;
                  height: 2px;
                  background: var(--primary-gradient);
                "
              ></span>
            </h6>
            <ul class="list-unstyled">
              <?php
              $quick_links = [
                ['title' => 'Home', 'link' => $base_path . 'index.php'],
                ['title' => 'Events', 'link' => $base_path . 'pages/events.php'],
                ['title' => 'Services', 'link' => $base_path . 'pages/services.php'],
                ['title' => 'About', 'link' => $base_path . 'pages/about.php'],
                ['title' => 'Gallery', 'link' => $base_path . 'pages/gallery.php'],
                ['title' => 'Contact', 'link' => $base_path . 'pages/contact.php']
              ];

              foreach ($quick_links as $link) {
                echo '<li class="mb-3">
                  <a
                    href="' . $link['link'] . '"
                    class="footer-link text-light text-decoration-none fw-normal d-block py-1"
                    data-i18n="nav_' . strtolower($link['title']) . '"
                    style="transition: all 0.2s ease; color: #ffffff"
                    >' . $link['title'] . '</a
                  >
                </li>';
              }
              ?>
            </ul>
          </div>

          <!-- Services -->
          <div class="col-md-4 mb-4 mb-md-0">
            <h6
              class="footer-title text-light mb-4 fw-semibold position-relative d-inline-block"
            >
              <span data-i18n="our_services">Our Services</span>
              <span
                style="
                  position: absolute;
                  bottom: -5px;
                  left: 0;
                  width: 30px;
                  height: 2px;
                  background: var(--primary-gradient);
                "
              ></span>
            </h6>
            <ul class="list-unstyled">
              <?php
              $services = [
                ['title' => 'Venue Booking', 'link' => $base_path . 'pages/services.php#venue'],
                ['title' => 'Photography', 'link' => $base_path . 'pages/services.php#photography'],
                ['title' => 'Event Planning', 'link' => $base_path . 'pages/services.php#planning'],
                ['title' => 'Catering', 'link' => $base_path . 'pages/services.php#catering'],
                ['title' => 'Decoration', 'link' => $base_path . 'pages/services.php#decoration']
              ];

              foreach ($services as $service) {
                echo '<li class="mb-3">
                  <a
                    href="' . $service['link'] . '"
                    class="footer-link text-light text-decoration-none fw-normal d-block py-1"
                    data-i18n="' . strtolower(str_replace(' ', '_', $service['title'])) . '"
                    style="transition: all 0.2s ease; color: #ffffff"
                    >' . $service['title'] . '</a
                  >
                </li>';
              }
              ?>
            </ul>
          </div>

          <!-- Contact -->
          <div class="col-md-4">
            <h6
              class="footer-title text-light mb-4 fw-semibold position-relative d-inline-block"
            >
              <span data-i18n="contact_info">Contact Info</span>
              <span
                style="
                  position: absolute;
                  bottom: -5px;
                  left: 0;
                  width: 30px;
                  height: 2px;
                  background: var(--primary-gradient);
                "
              ></span>
            </h6>
            <div class="contact-card p-3 mb-3">
              <div class="contact-info d-flex align-items-center mb-3">
                <div
                  style="min-width: 32px; display: flex; align-items: center"
                >
                  <i
                    class="fas fa-map-marker-alt"
                    style="color: var(--primary-color)"
                  ></i>
                </div>
                <span
                  class="text-light ms-2 fw-normal"
                  data-i18n="address"
                  style="font-size: 0.9rem; color: #ffffff"
                  >Garowe, Puntland</span
                >
              </div>
              <div class="contact-info d-flex align-items-center mb-3">
                <div
                  style="min-width: 32px; display: flex; align-items: center"
                >
                  <i
                    class="fas fa-phone-alt"
                    style="color: var(--primary-color)"
                  ></i>
                </div>
                <span
                  class="text-light ms-2 fw-normal"
                  style="font-size: 0.9rem; color: #ffffff"
                  >+252 61 1234567</span
                >
              </div>
              <div class="d-flex align-items-center">
                <div
                  style="min-width: 32px; display: flex; align-items: center"
                >
                  <i
                    class="fas fa-envelope"
                    style="color: var(--primary-color)"
                  ></i>
                </div>
                <span
                  class="text-light ms-2 fw-normal"
                  style="font-size: 0.9rem; color: #ffffff"
                  >info@xafladiya.com</span
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="row mt-5">
      <div class="col-12">
        <div class="copyright text-center">
          <p class="text-light mb-0" style="font-size: 0.9rem">
            &copy; <?php echo date('Y'); ?> Xafladiya. All rights reserved.
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Back to Top Button -->
<button
  id="backToTop"
  class="back-to-top-btn"
  title="Back to Top"
  style="display: none"
>
  <i class="fas fa-arrow-up"></i>
</button>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- Custom JS -->
<script src="<?php echo $base_path; ?>assets/js/main.js"></script>
<script>
  // Initialize AOS
  AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true
  });
</script>
</body>
</html> 