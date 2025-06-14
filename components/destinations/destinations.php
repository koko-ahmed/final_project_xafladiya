<?php
// Destinations Component
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';
?>

<!-- Destinations Component -->
<link rel="stylesheet" href="<?php echo $base_path; ?>components/destinations/css/destinations.css" />

<section id="destinations" class="destinations-section py-5">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="section-title">Popular Event Destinations</h2>
      <div class="section-divider"></div>
      <p class="section-subtitle">
        Discover perfect locations for your next unforgettable event
      </p>
    </div>

    <div class="destination-showcase" data-aos="fade-up">
      <div class="row g-4">
        <?php
        $destinations = [
          [
            'name' => 'Garowe',
            'image' => $base_path . 'assets/images/garowe.jpg',
            'description' => 'Discover Garowe\'s premium event venues with modern facilities and breathtaking views. Perfect for weddings, conferences, and corporate gatherings.',
            'features' => [
              ['icon' => 'hotel', 'text' => '12 Venues'],
              ['icon' => 'user-tie', 'text' => '8 Event Planners'],
              ['icon' => 'camera', 'text' => '15 Photographers']
            ],
            'link' => $base_path . 'pages/destinations/garowe.php',
            'is_primary' => true,
            'label' => 'Most Popular'
          ],
          [
            'name' => 'Bosaso',
            'image' => $base_path . 'assets/images/bosaso.webp',
            'description' => 'Scenic coastal venues with beautiful ocean views. Perfect for memorable beach weddings and outdoor celebrations.',
            'features' => [
              ['icon' => 'hotel', 'text' => '9 Venues'],
              ['icon' => 'camera', 'text' => '11 Photographers']
            ],
            'link' => $base_path . 'pages/destinations/bosaso.php',
            'is_primary' => false
          ],
          [
            'name' => 'Galkacyo',
            'image' => $base_path . 'assets/images/galkacyo.jpg',
            'description' => 'Central Somalia\'s commercial hub with diverse venue options for all types of gatherings and celebrations.',
            'features' => [
              ['icon' => 'hotel', 'text' => '7 Venues'],
              ['icon' => 'camera', 'text' => '9 Photographers']
            ],
            'link' => $base_path . 'pages/destinations/galkacyo.php',
            'is_primary' => false
          ]
        ];

        // Primary destination (Garowe)
        $primary = $destinations[0];
        echo '<div class="col-lg-6">
          <div class="destination-card primary-destination">
            <div class="destination-img-container">
              <img src="' . $primary['image'] . '" alt="' . $primary['name'] . '" class="destination-img" />
              <div class="destination-overlay">
                <span class="destination-label">' . $primary['label'] . '</span>
              </div>
            </div>
            <div class="destination-content">
              <h3>' . $primary['name'] . '</h3>
              <p>' . $primary['description'] . '</p>
              <div class="destination-features">';
              foreach ($primary['features'] as $feature) {
                echo '<span><i class="fas fa-' . $feature['icon'] . '"></i> ' . $feature['text'] . '</span>';
              }
              echo '</div>
              <a href="' . $primary['link'] . '" class="btn btn-primary">Explore ' . $primary['name'] . '</a>
            </div>
          </div>
        </div>';

        // Secondary destinations (Bosaso and Galkacyo)
        echo '<div class="col-lg-6">
          <div class="row g-4">';
          for ($i = 1; $i < count($destinations); $i++) {
            $dest = $destinations[$i];
            echo '<div class="col-md-12">
              <div class="destination-card secondary-destination">
                <div class="row g-0">
                  <div class="col-md-5">
                    <div class="destination-img-container h-100">
                      <img src="' . $dest['image'] . '" alt="' . $dest['name'] . '" class="destination-img" />
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="destination-content">
                      <h3>' . $dest['name'] . '</h3>
                      <p>' . $dest['description'] . '</p>
                      <div class="destination-features">';
                      foreach ($dest['features'] as $feature) {
                        echo '<span><i class="fas fa-' . $feature['icon'] . '"></i> ' . $feature['text'] . '</span>';
                      }
                      echo '</div>
                      <a href="' . $dest['link'] . '" class="btn btn-outline-primary">Explore ' . $dest['name'] . '</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>';
          }
          echo '</div>
        </div>';
        ?>
      </div>
    </div>

    <div class="text-center mt-5" data-aos="fade-up">
      <a href="<?php echo $base_path; ?>pages/destinations.php" class="btn btn-lg btn-primary">View All Destinations</a>
    </div>
  </div>
</section>

<script src="<?php echo $base_path; ?>components/destinations/js/destinations.js"></script> 