<?php
$page_title = 'Xafladiya - Contact Us';
include '../includes/header.php';
?>

<!-- Contact Hero Section -->
<section class="contact-hero-section py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <h1 class="display-4 fw-bold mb-4">Get In Touch</h1>
        <p class="lead mb-4">
          We'd love to hear from you. Let us know how we can help with your
          event planning needs.
        </p>
        <div class="contact-info mb-4">
          <div class="d-flex align-items-center mb-3">
            <div class="contact-icon me-3">
              <i class="fas fa-map-marker-alt fa-fw"></i>
            </div>
            <div>
              <h5 class="mb-0">Visit Us</h5>
              <p class="mb-0">123 Main Street, Garowe, Puntland, Somalia</p>
            </div>
          </div>
          <div class="d-flex align-items-center mb-3">
            <div class="contact-icon me-3">
              <i class="fas fa-envelope fa-fw"></i>
            </div>
            <div>
              <h5 class="mb-0">Email Us</h5>
              <p class="mb-0">info@xafladia.com</p>
            </div>
          </div>
          <div class="d-flex align-items-center mb-3">
            <div class="contact-icon me-3">
              <i class="fas fa-phone fa-fw"></i>
            </div>
            <div>
              <h5 class="mb-0">Call Us</h5>
              <p class="mb-0">+252 907 123456</p>
            </div>
          </div>
          <div class="d-flex align-items-center">
            <div class="contact-icon me-3">
              <i class="fas fa-clock fa-fw"></i>
            </div>
            <div>
              <h5 class="mb-0">Office Hours</h5>
              <p class="mb-0">
                Monday - Friday: 9am - 5pm<br />Saturday: 10am - 3pm
              </p>
            </div>
          </div>
        </div>
        <div class="social-media mb-4">
          <h5>Connect With Us</h5>
          <div class="d-flex">
            <a href="#" class="social-link me-2">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-link me-2">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-link me-2">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="social-link me-2">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="social-link">
              <i class="fab fa-youtube"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card border-0 shadow">
          <div class="card-body p-4">
            <h3 class="card-title mb-4">Send Us a Message</h3>
            <form id="contactForm" action="../includes/db.php" method="POST">
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name" class="form-label">Your Name*</label>
                    <input
                      type="text"
                      class="form-control"
                      id="name"
                      name="name"
                      placeholder="Enter your name"
                      required
                    />
                    <div class="invalid-feedback">
                      Please enter your name
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email" class="form-label">Your Email*</label>
                    <input
                      type="email"
                      class="form-control"
                      id="email"
                      name="email"
                      placeholder="Enter your email"
                      required
                    />
                    <div class="invalid-feedback">
                      Please enter a valid email
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group mt-3">
                <label for="phone" class="form-label">Your Phone</label>
                <input
                  type="tel"
                  class="form-control"
                  id="phone"
                  name="phone"
                  placeholder="Enter your phone number"
                />
              </div>
              <div class="form-group mt-3">
                <label for="subject" class="form-label">Subject*</label>
                <input
                  type="text"
                  class="form-control"
                  id="subject"
                  name="subject"
                  placeholder="Enter message subject"
                  required
                />
                <div class="invalid-feedback">Please enter a subject</div>
              </div>
              <div class="form-group mt-3">
                <label for="message" class="form-label">Message*</label>
                <textarea
                  class="form-control"
                  id="message"
                  name="message"
                  rows="5"
                  placeholder="Enter your message"
                  required
                ></textarea>
                <div class="invalid-feedback">
                  Please enter your message
                </div>
              </div>
              <div class="form-check mt-3">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="newsletter"
                  name="newsletter"
                />
                <label class="form-check-label" for="newsletter">
                  Subscribe to our newsletter
                </label>
              </div>
              <div class="mt-4">
                <button
                  type="submit"
                  id="submitContactForm"
                  class="btn btn-primary px-4 py-2"
                >
                  Send Message
                </button>
              </div>
              <div
                class="mt-3 success-message"
                id="contactSuccess"
                style="display: none"
              >
                <div class="alert alert-success">
                  <i class="fas fa-check-circle me-2"></i> Your message has
                  been sent successfully. We'll get back to you shortly!
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Map Section -->
<section class="map-section py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold" style="color: #000000;">Find Us</h2>
      <p class="lead" style="color: #000000;">Visit our office in Garowe, Somalia</p>
    </div>
    <div class="map-container shadow rounded">
      <img
        src="<?php echo get_url('assets/images/somalia_map.png'); ?>"
        alt="Map of Somalia"
        class="img-fluid rounded"
        style="width: 100%; height: auto;"
      />
    </div>
    <div class="text-center mt-4">
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- Custom JS -->
<script src="<?php echo get_url('assets/js/main.js'); ?>"></script>

<script>
    // Initialize AOS animation library
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    // Handle contact form submission
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Add your form submission logic here
        alert('Thank you for your message! We will get back to you soon.');
        this.reset();
    });

    // Handle newsletter form submission
    document.getElementById('newsletterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Add your newsletter subscription logic here
        alert('Thank you for subscribing to our newsletter!');
        this.reset();
    });

    const videos = document.querySelectorAll('.hero-bg-video');
    let current = 0;
    function showVideo(index) {
        videos.forEach((vid, i) => {
            vid.classList.toggle('active', i === index);
            if (i === index) {
                vid.currentTime = 0;
                vid.play();
            } else {
                vid.pause();
            }
        });
    }
    showVideo(0); // Should show the first video only

    videoInterval = setInterval(nextVideo, 8000); // 8 seconds
</script>

<!-- Add hero.js before closing body tag -->
<script src="assets/js/hero.js"></script>

<!-- Custom JS -->
<script>
$(document).ready(function() {
  // Form validation
  $('#contactForm').on('submit', function(e) {
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
      // Show loading state
      $('#submitContactForm').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
      
      // Submit form via AJAX
      $.ajax({
        url: '../includes/db.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.status === 'success') {
            $('#contactSuccess').show();
            $('#contactForm')[0].reset();
          } else {
            alert('Error: ' + (response.message || 'An error occurred. Please try again later.'));
          }
        },
        error: function() {
          alert('An error occurred. Please try again later.');
        }
      });
    }
  });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fix for dropdown menus
        var dropdownTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
        dropdownTriggerList.forEach(function(element) {
            new bootstrap.Dropdown(element);
        });
    });
</script> 