<?php
// Features Component
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';
?>

<!-- Features Component -->
<link rel="stylesheet" href="<?php echo $base_path; ?>components/features/css/features.css" />

<!-- Features Section -->
<section id="features" class="features-section py-5">
  <div class="container">
    <div class="section-title text-center" data-aos="fade-up">
      <h2>Our Services</h2>
      <p>Discover our comprehensive range of event services</p>
    </div>
    <div class="row g-4">
      <?php
      $features = [
        [
          'icon' => 'building',
          'title' => 'Venue Booking',
          'description' => 'Find and book the perfect venue for your event in just a few clicks. From intimate gatherings to grand celebrations.',
          'link' => $base_path . 'pages/services.php',
          'delay' => 100
        ],
        [
          'icon' => 'camera',
          'title' => 'Hire Photographers',
          'description' => 'Connect with professional photographers to capture your special moments with stunning visuals that will last a lifetime.',
          'link' => $base_path . 'pages/cameraman.php',
          'delay' => 200
        ],
        [
          'icon' => 'calendar-alt',
          'title' => 'Create Events',
          'description' => 'Plan and organize your events with our user-friendly management tools. Create memorable experiences with ease.',
          'link' => $base_path . 'pages/events.php',
          'delay' => 300
        ],
        [
          'icon' => 'hotel',
          'title' => 'Hotel Booking',
          'description' => 'Find and reserve comfortable accommodations for your event guests with our curated selection of partner hotels.',
          'link' => $base_path . 'pages/hotels.php',
          'delay' => 400
        ],
        [
          'icon' => 'utensils',
          'title' => 'Catering Services',
          'description' => 'Discover premium catering options for your events with customizable menus that cater to all dietary preferences and cultural requirements.',
          'link' => $base_path . 'pages/services.php#catering',
          'delay' => 500
        ],
        [
          'icon' => 'paint-brush',
          'title' => 'Decoration & Setup',
          'description' => 'Transform your venue with our professional decoration services. Create the perfect ambiance with custom themes and beautiful setups.',
          'link' => $base_path . 'pages/services.php#decoration',
          'delay' => 600
        ]
      ];

      foreach ($features as $feature) {
        echo '<div class="col-md-4" data-aos="fade-up" data-aos-delay="' . $feature['delay'] . '">
          <div class="card feature-card h-100">
            <div class="card-body">
              <div class="feature-icon">
                <i class="fas fa-' . $feature['icon'] . ' fa-2x"></i>
              </div>
              <h3 class="card-title">' . $feature['title'] . '</h3>
              <p class="card-text">' . $feature['description'] . '</p>
              <a href="' . $feature['link'] . '" class="btn btn-outline-primary mt-3">Learn More</a>
            </div>
          </div>
        </div>';
      }
      ?>
    </div>
  </div>
</section>

<script src="<?php echo $base_path; ?>components/features/js/features.js"></script> 