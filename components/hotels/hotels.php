<?php
// Hotels Component
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';
?>

<!-- Hotels Component -->
<link rel="stylesheet" href="<?php echo $base_path; ?>components/hotels/css/hotels.css" />

<!-- Hotels Section -->
<section id="hotels" class="hotels-section py-5">
  <div class="container">
    <!-- Premium Hotels Header -->
    <div class="premium-hotels-header text-center mb-5">
      <div class="logo-container mb-4" data-aos="fade-down" data-aos-duration="800">
        <img src="<?php echo $base_path; ?>assets/images/logo/logo.png" alt="Xafladiya Logo" height="60" class="mb-3" />
      </div>
      <h1 class="display-4 fw-bold mb-3" data-aos="fade-up" data-aos-duration="1000">
        Luxury Hotel Collection
      </h1>
      <div class="separator" data-aos="zoom-in" data-aos-delay="200">
        <span class="separator-line"></span>
        <span class="separator-icon"><i class="fas fa-star"></i></span>
        <span class="separator-line"></span>
      </div>
      <p class="lead mt-3" data-aos="fade-up" data-aos-delay="300">
        Experience the finest accommodations throughout Puntland, curated for
        discerning travelers and elite events
      </p>

      <!-- Quick Search Bar -->
      <div class="quick-search-container mt-4" data-aos="fade-up" data-aos-delay="400">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="search-box p-3">
              <form id="hotel-quick-search" class="d-flex flex-column flex-md-row gap-2 align-items-center" action="<?php echo $base_path; ?>pages/hotels.php" method="GET">
                <div class="input-group flex-grow-1">
                  <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
                  <input type="text" class="form-control search-input" name="search" placeholder="Search hotels by name or location..." aria-label="Search hotels" />
                </div>
                <div class="input-group dates-group">
                  <input type="date" class="form-control date-input" id="quick-check-in" name="check_in" title="Check-in date" placeholder="Check-in" aria-label="Check-in date" />
                  <span class="input-group-text bg-light border-0"><i class="fas fa-arrow-right"></i></span>
                  <input type="date" class="form-control date-input" id="quick-check-out" name="check_out" title="Check-out date" placeholder="Check-out" aria-label="Check-out date" />
                </div>
                <button type="submit" class="btn btn-primary search-btn">
                  <i class="fas fa-search me-2"></i>Search
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Hotel Stats -->
      <div class="hotel-stats mt-5" data-aos="fade-up" data-aos-delay="500">
        <div class="row justify-content-center">
          <?php
          $stats = [
            ['icon' => 'hotel', 'number' => '20+', 'text' => 'Premium Hotels'],
            ['icon' => 'map-marker-alt', 'number' => '5', 'text' => 'Major Cities'],
            ['icon' => 'star', 'number' => '4.8', 'text' => 'Average Rating'],
            ['icon' => 'users', 'number' => '5000+', 'text' => 'Happy Guests']
          ];

          foreach ($stats as $stat) {
            echo '<div class="col-md-3 col-6 mb-4 mb-md-0">
              <div class="stat-item">
                <i class="fas fa-' . $stat['icon'] . ' stat-icon"></i>
                <h3 class="stat-number">' . $stat['number'] . '</h3>
                <p class="stat-text">' . $stat['text'] . '</p>
              </div>
            </div>';
          }
          ?>
        </div>
      </div>
    </div>

    <!-- Featured Hotels Carousel -->
    <div class="featured-hotels mb-5" data-aos="fade-up">
      <div id="featuredHotelsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <?php
          $featured_hotels = [
            [
              'name' => 'New Rays Grand Hotel',
              'image' => $base_path . 'assets/images/hotels/new-rays.jpg',
              'location' => 'Central District, Garowe',
              'description' => 'Puntland\'s premier 5-star luxury hotel featuring elegant rooms, fine dining restaurants, and state-of-the-art conference facilities. Experience unparalleled hospitality with world-class amenities.',
              'rating' => 5,
              'features' => ['wifi', 'swimming-pool', 'utensils', 'car'],
              'price' => 95
            ],
            [
              'name' => 'Hotel Gacayte',
              'image' => $base_path . 'assets/images/hotels/gacayte.jpg',
              'location' => 'Bosaso City Center',
              'description' => 'A modern boutique hotel offering comfortable accommodations and excellent service in the heart of Bosaso.',
              'rating' => 4,
              'features' => ['wifi', 'utensils', 'car'],
              'price' => 75
            ],
            [
              'name' => 'Galkacyo Plaza Hotel',
              'image' => $base_path . 'assets/images/hotels/galkacyo-plaza.jpg',
              'location' => 'Downtown Galkacyo',
              'description' => 'Contemporary hotel with spacious rooms and comprehensive business facilities.',
              'rating' => 4,
              'features' => ['wifi', 'swimming-pool', 'utensils'],
              'price' => 65
            ]
          ];

          foreach ($featured_hotels as $index => $hotel) {
            echo '<button type="button" data-bs-target="#featuredHotelsCarousel" data-bs-slide-to="' . $index . '" ' . ($index === 0 ? 'class="active" aria-current="true"' : '') . ' aria-label="Slide ' . ($index + 1) . '"></button>';
          }
          ?>
        </div>
        <div class="carousel-inner">
          <?php
          foreach ($featured_hotels as $index => $hotel) {
            echo '<div class="carousel-item ' . ($index === 0 ? 'active' : '') . '">
              <div class="featured-hotel-card">
                <div class="row g-0">
                  <div class="col-md-6">
                    <img src="' . $hotel['image'] . '" class="img-fluid rounded-start h-100" alt="' . $hotel['name'] . '" style="object-fit: cover" />
                  </div>
                  <div class="col-md-6">
                    <div class="card-body d-flex flex-column h-100 justify-content-between p-4">
                      <div>
                        <div class="d-flex justify-content-between">
                          <h3 class="card-title">' . $hotel['name'] . '</h3>
                          <div class="hotel-rating">';
                          for ($i = 0; $i < $hotel['rating']; $i++) {
                            echo '<i class="fas fa-star"></i>';
                          }
                          echo '</div>
                        </div>
                        <p class="hotel-location">
                          <i class="fas fa-map-marker-alt me-2"></i>' . $hotel['location'] . '
                        </p>
                        <p class="card-text">' . $hotel['description'] . '</p>
                        <div class="hotel-features mt-3 mb-3">';
                        foreach ($hotel['features'] as $feature) {
                          echo '<span class="badge bg-light text-dark me-2"><i class="fas fa-' . $feature . ' me-1"></i> ' . ucwords(str_replace('-', ' ', $feature)) . '</span>';
                        }
                        echo '</div>
                      </div>
                      <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="price-info">
                          <span class="price-label">Price per night</span>
                          <h5 class="price-value">$' . $hotel['price'] . '</h5>
                        </div>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hotelModal">Book Now</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>';
          }
          ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#featuredHotelsCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#featuredHotelsCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Hotel Booking Modal -->
<div class="modal fade" id="hotelModal" tabindex="-1" aria-labelledby="hotelModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="hotelModalLabel">Book Your Stay</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="hotelBookingForm" action="<?php echo $base_path; ?>pages/process_booking.php" method="POST">
          <div class="mb-3">
            <label for="guestName" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="guestName" name="guest_name" required>
          </div>
          <div class="mb-3">
            <label for="guestEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="guestEmail" name="guest_email" required>
          </div>
          <div class="mb-3">
            <label for="guestPhone" class="form-label">Phone</label>
            <input type="tel" class="form-control" id="guestPhone" name="guest_phone" required>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label for="checkIn" class="form-label">Check-in Date</label>
              <input type="date" class="form-control" id="checkIn" name="check_in" required>
            </div>
            <div class="col">
              <label for="checkOut" class="form-label">Check-out Date</label>
              <input type="date" class="form-control" id="checkOut" name="check_out" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="guests" class="form-label">Number of Guests</label>
            <select class="form-select" id="guests" name="guests" required>
              <option value="1">1 Guest</option>
              <option value="2">2 Guests</option>
              <option value="3">3 Guests</option>
              <option value="4">4 Guests</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="specialRequests" class="form-label">Special Requests</label>
            <textarea class="form-control" id="specialRequests" name="special_requests" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-primary w-100">Confirm Booking</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo $base_path; ?>components/hotels/js/hotels.js"></script> 