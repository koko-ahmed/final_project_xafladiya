<?php
require_once '../config/config.php';
$page_title = $site_name . ' - Professional Cameraman Services';
include '../includes/header.php';
?>

<!-- Breadcrumb Navigation -->
<nav aria-label="breadcrumb" class="bg-light py-2 mb-4">
  <div class="container">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="<?php echo get_url('index.php'); ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?php echo get_url('pages/services.php'); ?>">Services</a></li>
      <li class="breadcrumb-item active" aria-current="page">Cameraman</li>
    </ol>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero-section text-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 text-lg-start" data-aos="fade-right">
        <h1 class="display-4 fw-bold mb-4">Capture Your Perfect Moments</h1>
        <p class="lead mb-4">
          Professional photography and videography services for your special
          events, delivered with creativity and precision
        </p>
        <a href="#booking" class="btn btn-primary btn-lg px-4 me-md-2">Book Now</a>
        <a href="#professionals" class="btn btn-outline-secondary btn-lg px-4">Meet Our Team</a>
      </div>
      <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="200">
        <img src="<?php echo get_url('assets/images/cameraman/Professional camera equipment.jpg'); ?>" alt="Professional camera equipment" class="img-fluid rounded-4 shadow-lg" />
      </div>
    </div>
  </div>
</section>

<!-- Services Section -->
<section id="services" class="services-section py-5">
  <div class="container">
    <div class="section-header text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold mb-3">Our Premium Services</h2>
      <p class="lead text-muted">
        We offer top-quality photography and videography services tailored to your needs
      </p>
    </div>

    <div class="row g-4">
      <!-- Photography Service -->
      <div class="col-md-6" data-aos="fade-up">
        <div class="service-card h-100">
          <div class="service-icon mb-4">
            <i class="fas fa-camera"></i>
          </div>
          <h3 class="service-title">Photography</h3>
          <ul class="service-features">
            <li><i class="fas fa-check-circle"></i> Wedding Photography</li>
            <li><i class="fas fa-check-circle"></i> Portrait Sessions</li>
            <li><i class="fas fa-check-circle"></i> Commercial Photography</li>
            <li><i class="fas fa-check-circle"></i> Product Photography</li>
            <li><i class="fas fa-check-circle"></i> Event Coverage</li>
          </ul>
          <p class="service-description">
            Our expert photographers capture your special moments with attention to detail, creative composition, and professional editing.
          </p>
          <button class="btn btn-primary book-btn" data-service="photography">
            Book Photography
          </button>
        </div>
      </div>

      <!-- Videography Service -->
      <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-card h-100">
          <div class="service-icon mb-4">
            <i class="fas fa-video"></i>
          </div>
          <h3 class="service-title">Videography</h3>
          <ul class="service-features">
            <li><i class="fas fa-check-circle"></i> Wedding Films</li>
            <li><i class="fas fa-check-circle"></i> Corporate Videos</li>
            <li><i class="fas fa-check-circle"></i> Event Documentation</li>
            <li><i class="fas fa-check-circle"></i> Music Videos</li>
            <li><i class="fas fa-check-circle"></i> Promotional Content</li>
          </ul>
          <p class="service-description">
            Our videography team creates cinematic experiences with professional equipment, creative direction, and polished editing.
          </p>
          <button class="btn btn-primary book-btn" data-service="videography">
            Book Videography
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Our Professionals Section -->
<section id="professionals" class="professionals-section py-5">
  <div class="container">
    <div class="section-header text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold mb-3">Meet Our Professionals</h2>
      <p class="lead text-muted">
        Our talented team of photographers and videographers bring your vision to life
      </p>
    </div>

    <div class="row g-4">
      <!-- Professional 1 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <div class="professional-card">
          <div class="professional-img-wrapper">
            <img src="<?php echo get_url('assets/images/team/ahmed2.jpg'); ?>" alt="Ahmed Hassan" class="img-fluid" />
          </div>
          <div class="professional-info">
            <h4 class="professional-name">Ahmed Hassan</h4>
            <p class="professional-specialty">Wedding Photography Specialist</p>
            <div class="professional-meta">
              <div class="professional-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>Mogadishu</span>
              </div>
              <div class="professional-experience">
                <i class="fas fa-clock"></i>
                <span>8 years experience</span>
              </div>
            </div>
            <div class="professional-rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
              <span>(4.5/5)</span>
            </div>
            <a href="#booking" class="btn btn-outline-primary w-100 mt-3 book-professional-btn" data-professional="ahmed" data-service="photography">
              Book Ahmed
            </a>
          </div>
        </div>
      </div>

      <!-- Professional 2 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="professional-card">
          <div class="professional-img-wrapper">
            <img src="<?php echo get_url('assets/images/team/hawa.jpg'); ?>" alt="Hawa Abdi" class="img-fluid" />
          </div>
          <div class="professional-info">
            <h4 class="professional-name">Hawa Abdi</h4>
            <p class="professional-specialty">Portrait & Fashion Photography</p>
            <div class="professional-meta">
              <div class="professional-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>Mogadishu</span>
              </div>
              <div class="professional-experience">
                <i class="fas fa-clock"></i>
                <span>7 years experience</span>
              </div>
            </div>
            <div class="professional-rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
              <span>(4.7/5)</span>
            </div>
            <a href="#booking" class="btn btn-outline-primary w-100 mt-3 book-professional-btn" data-professional="hawa" data-service="photography">
              Book Hawa
            </a>
          </div>
        </div>
      </div>

      <!-- Professional 3 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="professional-card">
          <div class="professional-img-wrapper">
            <img src="<?php echo get_url('assets/images/team/mohamed.jpg'); ?>" alt="Mohamed Omar" class="img-fluid" />
          </div>
          <div class="professional-info">
            <h4 class="professional-name">Mohamed Omar</h4>
            <p class="professional-specialty">Videography & Film Production</p>
            <div class="professional-meta">
              <div class="professional-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>Garowe</span>
              </div>
              <div class="professional-experience">
                <i class="fas fa-clock"></i>
                <span>10 years experience</span>
              </div>
            </div>
            <div class="professional-rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <span>(5.0/5)</span>
            </div>
            <a href="#booking" class="btn btn-outline-primary w-100 mt-3 book-professional-btn" data-professional="mohamed" data-service="videography">
              Book Mohamed
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Booking Section -->
<section id="booking" class="booking-section py-5">
  <div class="container">
    <div class="section-header text-center mb-5" data-aos="fade-up">
      <h2 class="display-5 fw-bold mb-3">Book Your Session</h2>
      <p class="lead text-muted">Schedule your photography or videography session with our professionals</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card border-0 shadow" data-aos="fade-up">
          <div class="card-body p-4">
            <form id="bookingForm" action="process_booking.php" method="POST">
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name" class="form-label">Your Name*</label>
                    <input type="text" class="form-control" id="name" name="name" required />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email" class="form-label">Your Email*</label>
                    <input type="email" class="form-control" id="email" name="email" required />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="phone" class="form-label">Phone Number*</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="service" class="form-label">Service Type*</label>
                    <select class="form-select" id="service" name="service" required>
                      <option value="">Select a service</option>
                      <option value="photography">Photography</option>
                      <option value="videography">Videography</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="professional" class="form-label">Preferred Professional</label>
                    <select class="form-select" id="professional" name="professional">
                      <option value="">Select a professional</option>
                      <option value="ahmed">Ahmed Hassan</option>
                      <option value="hawa">Hawa Abdi</option>
                      <option value="mohamed">Mohamed Omar</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="date" class="form-label">Preferred Date*</label>
                    <input type="date" class="form-control" id="date" name="date" required />
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="message" class="form-label">Additional Details</label>
                    <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                  </div>
                </div>
              </div>
              <div class="mt-4">
                <button type="submit" class="btn btn-primary px-4 py-2">Submit Booking</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- Custom JS -->
<script src="<?php echo get_url('assets/js/main.js'); ?>"></script>

<script>
  // Initialize AOS
  AOS.init({
    duration: 1000,
    once: true
  });

  // Handle service booking buttons
  $('.book-btn').click(function() {
    var service = $(this).data('service');
    $('#service').val(service);
    $('html, body').animate({
      scrollTop: $('#booking').offset().top - 100
    }, 500);
  });

  // Handle professional booking buttons
  $('.book-professional-btn').click(function() {
    var professional = $(this).data('professional');
    var service = $(this).data('service');
    $('#professional').val(professional);
    $('#service').val(service);
    $('html, body').animate({
      scrollTop: $('#booking').offset().top - 100
    }, 500);
  });

  // Form validation
  $('#bookingForm').on('submit', function(e) {
    e.preventDefault();
    
    // Basic form validation
    var isValid = true;
    $(this).find('[required]').each(function() {
      if (!$(this).val()) {
        isValid = false;
        $(this).addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    
    if (isValid) {
      // Submit form via AJAX
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          alert('Booking submitted successfully! We will contact you shortly.');
          $('#bookingForm')[0].reset();
        },
        error: function() {
          alert('An error occurred. Please try again later.');
        }
      });
    }
  });
</script>

</body>
</html> 