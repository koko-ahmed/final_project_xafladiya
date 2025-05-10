<?php
// Cities Component
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';
?>

<link rel="stylesheet" href="<?php echo $base_path; ?>components/cities/css/cities.css" />

<section id="cities" class="modern-section py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="modern-title" style="color: #000000 !important">
        Featured Cities
      </h2>
      <div class="modern-divider modern-divider-center"></div>
      <p class="modern-subtitle" style="color: #000000 !important">
        Explore our services in these popular Somali cities
      </p>
    </div>
    <div class="row g-4">
      <?php
      $cities = [
        [
          'name' => 'Garowe',
          'image' => 'garowe.jpg',
          'description' => 'Discover top venues and event services in the capital of Puntland.'
        ],
        [
          'name' => 'Bosaso',
          'image' => 'bosaso.webp',
          'description' => 'Find the best event venues in this vibrant coastal city.'
        ],
        [
          'name' => 'Galkacyo',
          'image' => 'galkacyo.jpg',
          'description' => 'Explore event opportunities in central Somalia\'s commercial hub.'
        ]
      ];

      foreach ($cities as $city) {
      ?>
        <div class="col-md-4">
          <div class="modern-card h-100">
            <div class="city-image" style="height: 250px; overflow: hidden">
              <img
                src="<?php echo $base_path; ?>assets/images/<?php echo $city['image']; ?>"
                alt="<?php echo $city['name']; ?>"
                style="width: 100%; height: 100%; object-fit: cover"
                class="city-img"
              />
              <div class="city-overlay">
                <h3 class="city-name"><?php echo $city['name']; ?></h3>
              </div>
            </div>
            <div class="p-4">
              <h3 class="modern-title" style="color: #000000 !important">
                <?php echo $city['name']; ?>
              </h3>
              <p class="modern-text" style="color: #000000 !important">
                <?php echo $city['description']; ?>
              </p>
              <a href="#" class="modern-btn w-100">Explore</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

<script src="<?php echo $base_path; ?>components/cities/js/cities.js"></script> 