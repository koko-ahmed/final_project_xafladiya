<?php
// Contact Component
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';
?>

<!-- Contact Section -->
<section id="contact" class="contact-section py-5 bg-light">
  <div class="contact-background"></div>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
        <h2 class="contact-title mb-4">Contact Us</h2>
        <p class="contact-desc mb-4">
          Need help planning your event? Our support team is here to assist you.
        </p>
        <div class="d-flex align-items-center mb-4">
          <div class="contact-icon me-3">
            <i class="fas fa-envelope"></i>
          </div>
          <div>
            <h5 class="mb-1">Email</h5>
            <p class="mb-0">support@xafladiya.com</p>
          </div>
        </div>
        <div class="d-flex align-items-center mb-5">
          <div class="contact-icon me-3">
            <i class="fas fa-phone-alt"></i>
          </div>
          <div>
            <h5 class="mb-1">Phone</h5>
            <p class="mb-0">+252 907 569 914</p>
          </div>
        </div>
        <a
          href="<?php echo $base_path; ?>pages/contact.php"
          class="btn btn-primary btn-lg px-4 py-2 contact-us-btn"
          >Contact Us</a
        >
      </div>
      <div
        class="col-lg-6 text-center"
        data-aos="fade-left"
        data-aos-delay="200"
      >
        <div class="support-image">
          <img
            src="<?php echo $base_path; ?>assets/images/support2.jpg"
            alt="Support Team"
            class="img-fluid rounded shadow"
          />
        </div>
      </div>
    </div>
    <div class="text-center mb-5" style="color: #000; position: relative; z-index: 10;">
  <h2 class="fw-bold" style="color: #000;">Find Us</h2>
  <p class="lead" style="color: #000;">Visit our office in Garowe, Somalia</p>
</div>

<button style="background: #e2b53e; color: #000; padding: 10px 20px; border: none; z-index: 10; position: relative;">
  Contact Us
</button>


  </div>
</section> 