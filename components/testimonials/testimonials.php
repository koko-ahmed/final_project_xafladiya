<?php
// Testimonials Component
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';
?>

<!-- Testimonials Section -->
<section id="testimonials" class="testimonials-section py-5">
  <div class="container">
    <div class="section-title text-center" data-aos="fade-up">
      <h2 style="color: #000000 !important">What Our Clients Say</h2>
      <p style="color: #000000 !important">
        Hear from those who have experienced our services
      </p>
    </div>
    <div class="row g-4">
      <?php
      $testimonials = [
        [
          'name' => 'Shakir Shube',
          'role' => 'Wedding Organizer',
          'image' => $base_path . 'assets/images/shakir.jpg',
          'quote' => 'Xafladia made planning our wedding reception so much easier. We found the perfect venue and hired an excellent cameraman through the platform.',
          'rating' => 5,
          'delay' => 100
        ],
        [
          'name' => 'Naima Aadam',
          'role' => 'Corporate Event Manager',
          'image' => $base_path . 'assets/images/naima.jpg',
          'quote' => 'As a corporate event planner, I rely on Xafladia for all my bookings in Puntland. The platform is user-friendly and reliable.',
          'rating' => 4.5,
          'delay' => 200
        ],
        [
          'name' => 'C/qani Ahmed',
          'role' => 'Graduation Ceremony Planner',
          'image' => $base_path . 'assets/images/cbdqani.jpg',
          'quote' => 'Thanks to Xafladia, our university graduation ceremony was a huge success. The venue recommendations were excellent.',
          'rating' => 5,
          'delay' => 300
        ]
      ];

      foreach ($testimonials as $testimonial) {
        echo '<div class="col-md-4" data-aos="fade-up" data-aos-delay="' . $testimonial['delay'] . '">
          <div class="card testimonial-card h-100 position-relative">
            <div class="card-body">
              <div class="testimonial-quote-icon">
                <i class="fas fa-quote-left"></i>
              </div>
              <div class="d-flex align-items-center mb-3">
                <div class="testimonial-avatar me-3">
                  <img src="' . $testimonial['image'] . '" alt="' . $testimonial['name'] . '" />
                </div>
                <div>
                  <h5 class="mb-0" style="color: #000000 !important">' . $testimonial['name'] . '</h5>
                  <p class="text-muted mb-0">' . $testimonial['role'] . '</p>
                </div>
              </div>
              <p class="card-text" style="color: #000000 !important">"' . $testimonial['quote'] . '"</p>
              <div class="testimonial-rating">';
              
              // Generate star rating
              $fullStars = floor($testimonial['rating']);
              $hasHalfStar = $testimonial['rating'] - $fullStars >= 0.5;
              
              for ($i = 0; $i < $fullStars; $i++) {
                echo '<i class="fas fa-star"></i>';
              }
              if ($hasHalfStar) {
                echo '<i class="fas fa-star-half-alt"></i>';
              }
              $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
              for ($i = 0; $i < $emptyStars; $i++) {
                echo '<i class="far fa-star"></i>';
              }
              
              echo '</div>
            </div>
          </div>
        </div>';
      }
      ?>
    </div>
  </div>
</section>

<script src="<?php echo $base_path; ?>components/testimonials/js/testimonials.js"></script> 