<?php
// Hero Component
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';
?>

<link rel="stylesheet" href="<?php echo $base_path; ?>components/hero/css/hero.css" />

<section class="hero-section">
  <div class="container">
    <!-- Main Hero Content -->
    <div class="row align-items-center mb-5">
      <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
        <h1 class="hero-title fw-bold mb-4 text-dark">Welcome to Xafladiya</h1>
        <p class="hero-description mb-4 text-dark">
          Discover top events, premium services, talented cameramen, beautiful
          hotels, and more — all in one place!
        </p>
        <div class="d-flex gap-3">
          <a href="<?php echo $base_path; ?>pages/events.php" class="btn btn-primary btn-lg">
            <i class="fas fa-calendar-check me-2"></i>Explore Events
          </a>
          <a href="#contact-container" class="btn btn-outline-primary btn-lg">
            <i class="fas fa-phone-alt me-2"></i>Contact Us
          </a>
        </div>
      </div>
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
        <div class="hero-img-container position-relative overflow-hidden">
          <img
            src="<?php echo $base_path; ?>assets/images/event-planning.jpg"
            alt="Xafladiya - Premier Event Planning"
            class="hero-img w-100 h-auto rounded-4 shadow-lg"
            loading="lazy"
            width="600"
            height="400"
          />
          <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>
        </div>
      </div>
    </div>

    <!-- Quick Access Cards -->
    <div class="quick-access-section">
      <h2 class="text-center mb-4 text-dark" data-aos="fade-up">
        Our Platform Features
      </h2>
      <div class="row g-4">
        <?php
        $quick_links = [
          [
            'icon' => 'fa-home',
            'title' => 'Home',
            'description' => 'Main page with all features',
            'link' => $base_path . 'index.php'
          ],
          [
            'icon' => 'fa-calendar-day',
            'title' => 'Events',
            'description' => 'Find exciting events',
            'link' => $base_path . 'pages/events.php'
          ],
          [
            'icon' => 'fa-concierge-bell',
            'title' => 'Services',
            'description' => 'Premium event services',
            'link' => $base_path . 'pages/services.php'
          ],
          [
            'icon' => 'fa-video',
            'title' => 'Cameraman',
            'description' => 'Professional photography',
            'link' => $base_path . 'pages/cameraman.php'
          ],
          [
            'icon' => 'fa-hotel',
            'title' => 'Hotels',
            'description' => 'Find perfect venues',
            'link' => $base_path . 'pages/hotels.php'
          ],
          [
            'icon' => 'fa-images',
            'title' => 'Gallery',
            'description' => 'View our portfolio',
            'link' => $base_path . 'pages/gallery.php'
          ],
          [
            'icon' => 'fa-info-circle',
            'title' => 'About',
            'description' => 'Learn about us',
            'link' => $base_path . 'pages/about.php'
          ],
          [
            'icon' => 'fa-envelope',
            'title' => 'Contact',
            'description' => 'Get in touch with us',
            'link' => $base_path . 'pages/contact.php'
          ]
        ];

        $delay = 100;
        foreach ($quick_links as $link) {
        ?>
          <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
            <a href="<?php echo $link['link']; ?>" class="quick-access-card">
              <div class="card h-100 text-center border-0 shadow-sm">
                <div class="card-body">
                  <div class="quick-access-icon mb-3">
                    <i class="fas <?php echo $link['icon']; ?>"></i>
                  </div>
                  <h5 class="card-title"><?php echo $link['title']; ?></h5>
                  <p class="card-text small"><?php echo $link['description']; ?></p>
                </div>
              </div>
            </a>
          </div>
        <?php
          $delay += 100;
        }
        ?>
      </div>
    </div>
  </div>
</section>

<script src="<?php echo $base_path; ?>components/hero/js/hero.js"></script> 