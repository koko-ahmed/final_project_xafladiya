<?php
// Partials Component
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
            src="<?php echo $base_path; ?>LOGO/Xafladiya Logo_10.png"
            alt="Xafladia Logo"
            class="mb-4"
            style="
              max-width: 160px;
              filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.2));
            "
          />
          <p
            class="text-light mb-4 opacity-75 fw-light"
            style="font-size: 0.95rem; line-height: 1.6"
            data-i18n="footer_description"
          >
            Your premier event planning platform in Somalia. Making special
            moments unforgettable since 2020.
          </p>
        </div>

        <!-- Newsletter Signup -->
        <div class="newsletter-wrapper mt-4 mb-4 p-3 contact-card">
          <h6 class="text-light mb-3 fw-bold">Subscribe to Updates</h6>
          <form action="<?php echo $base_path; ?>pages/process_newsletter.php" method="POST" class="d-flex">
            <input
              type="email"
              name="email"
              placeholder="Your email"
              class="newsletter-input form-control me-2"
              required
            />
            <button
              type="submit"
              class="btn px-3"
              style="
                background: var(--primary-gradient);
                color: white;
                border: none;
                border-radius: 8px;
              "
              title="Subscribe to newsletter"
            >
              <i class="fas fa-paper-plane"></i>
            </button>
          </form>
        </div>

        <!-- Social Media -->
        <div class="social-icons-wrapper d-flex gap-3 mt-4">
          <a href="#" class="social-icon">
            <i class="fab fa-facebook-f text-light"></i>
          </a>
          <a href="#" class="social-icon">
            <i class="fab fa-instagram text-light"></i>
          </a>
          <a href="#" class="social-icon">
            <i class="fab fa-twitter text-light"></i>
          </a>
          <a href="#" class="social-icon">
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
              <li class="mb-3">
                <a
                  href="<?php echo $base_path; ?>index.php"
                  class="footer-link text-light text-decoration-none opacity-75 fw-light d-block py-1"
                  data-i18n="nav_home"
                  style="transition: all 0.2s ease"
                  >Home</a
                >
              </li>
              <li class="mb-3">
                <a
                  href="<?php echo $base_path; ?>pages/events.php"
                  class="footer-link text-light text-decoration-none opacity-75 fw-light d-block py-1"
                  data-i18n="nav_events"
                  style="transition: all 0.2s ease"
                  >Events</a
                >
              </li>
              <li class="mb-3">
                <a
                  href="<?php echo $base_path; ?>pages/services.php"
                  class="footer-link text-light text-decoration-none opacity-75 fw-light d-block py-1"
                  data-i18n="nav_services"
                  style="transition: all 0.2s ease"
                  >Services</a
                >
              </li>
              <li class="mb-3">
                <a
                  href="<?php echo $base_path; ?>pages/about.php"
                  class="footer-link text-light text-decoration-none opacity-75 fw-light d-block py-1"
                  data-i18n="nav_about"
                  style="transition: all 0.2s ease"
                  >About</a
                >
              </li>
              <li class="mb-3">
                <a
                  href="<?php echo $base_path; ?>pages/gallery.php"
                  class="footer-link text-light text-decoration-none opacity-75 fw-light d-block py-1"
                  data-i18n="nav_gallery"
                  style="transition: all 0.2s ease"
                  >Gallery</a
                >
              </li>
              <li class="mb-3">
                <a
                  href="<?php echo $base_path; ?>pages/contact.php"
                  class="footer-link text-light text-decoration-none opacity-75 fw-light d-block py-1"
                  data-i18n="nav_contact"
                  style="transition: all 0.2s ease"
                  >Contact</a
                >
              </li>
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
              <li class="mb-3">
                <a
                  href="<?php echo $base_path; ?>pages/services.php#venue"
                  class="footer-link text-light text-decoration-none opacity-75 fw-light d-block py-1"
                  data-i18n="venue_booking"
                  style="transition: all 0.2s ease"
                  >Venue Booking</a
                >
              </li>
              <li class="mb-3">
                <a
                  href="<?php echo $base_path; ?>pages/services.php#photography"
                  class="footer-link text-light text-decoration-none opacity-75 fw-light d-block py-1"
                  data-i18n="professional_photography"
                  style="transition: all 0.2s ease"
                  >Photography</a
                >
              </li>
              <li class="mb-3">
                <a
                  href="<?php echo $base_path; ?>pages/services.php#planning"
                  class="footer-link text-light text-decoration-none opacity-75 fw-light d-block py-1"
                  data-i18n="event_planning"
                  style="transition: all 0.2s ease"
                  >Event Planning</a
                >
              </li>
              <li class="mb-3">
                <a
                  href="<?php echo $base_path; ?>pages/services.php#catering"
                  class="footer-link text-light text-decoration-none opacity-75 fw-light d-block py-1"
                  data-i18n="catering_services"
                  style="transition: all 0.2s ease"
                  >Catering</a
                >
              </li>
              <li class="mb-3">
                <a
                  href="<?php echo $base_path; ?>pages/services.php#decoration"
                  class="footer-link text-light text-decoration-none opacity-75 fw-light d-block py-1"
                  data-i18n="decoration_setup"
                  style="transition: all 0.2s ease"
                  >Decoration</a
                >
              </li>
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
                  class="text-light opacity-75 ms-2 fw-light"
                  data-i18n="address"
                  style="font-size: 0.9rem"
                  >Mogadishu, Somalia</span
                >
              </div>
              <div class="contact-info d-flex align-items-center mb-3">
                <div
                  style="min-width: 32px; display: flex; align-items: center"
                >
                  <i
                    class="fas fa-phone"
                    style="color: var(--primary-color)"
                  ></i>
                </div>
                <span
                  class="text-light opacity-75 ms-2 fw-light"
                  data-i18n="phone"
                  style="font-size: 0.9rem"
                  >+252 615 123 456</span
                >
              </div>
              <div class="contact-info d-flex align-items-center">
                <div
                  style="min-width: 32px; display: flex; align-items: center"
                >
                  <i
                    class="fas fa-envelope"
                    style="color: var(--primary-color)"
                  ></i>
                </div>
                <span
                  class="text-light opacity-75 ms-2 fw-light"
                  data-i18n="email"
                  style="font-size: 0.9rem"
                  >info@xafladia.com</span
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
        <div class="text-center text-light opacity-75 fw-light" style="font-size: 0.9rem">
          <p class="mb-0">
            &copy; <?php echo date('Y'); ?> Xafladia. All rights reserved.
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Required Scripts -->
<script src="<?php echo $base_path; ?>components/partials/partials.js"></script>

<!-- Custom CSS -->
<style>
  .footer-2025 {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    position: relative;
    overflow: hidden;
  }

  .footer-deco-circle {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
  }

  .footer-deco-circle.orange {
    width: 300px;
    height: 300px;
    background: var(--primary-color);
    top: -150px;
    right: -150px;
  }

  .footer-deco-circle.blue {
    width: 200px;
    height: 200px;
    background: var(--secondary-color);
    bottom: -100px;
    left: -100px;
  }

  .footer-section {
    position: relative;
    z-index: 1;
  }

  .footer-title {
    font-size: 1.1rem;
  }

  .footer-link:hover {
    opacity: 1 !important;
    transform: translateX(5px);
  }

  .social-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
  }

  .social-icon:hover {
    background: var(--primary-color);
    transform: translateY(-3px);
  }

  .contact-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    backdrop-filter: blur(10px);
  }

  .newsletter-input {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: white;
    border-radius: 8px;
  }

  .newsletter-input::placeholder {
    color: rgba(255, 255, 255, 0.5);
  }

  .newsletter-input:focus {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    box-shadow: none;
  }
</style> 