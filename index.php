<?php
require_once 'config/config.php';
$page_title = $site_name . ' - ' . $site_description;
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section py-5" data-aos="fade-up" style="background-color:rgb(226, 231, 235);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content text-center text-lg-start mb-4">
                    <h1 class="hero-title">Welcome to <?php echo $site_name; ?></h1>
                    <p class="hero-description">Discover top events, premium services, talented cameramen, beautiful hotels, and more — all in one place!</p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                        <a href="<?php echo get_url('pages/events.php'); ?>" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-calendar-check me-2"></i>Explore Events
                        </a>
                        <a href="#contact" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-phone-alt me-2"></i>Contact Us
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-img-container text-center text-lg-end">
                    <img src="<?php echo get_url('assets/images/event-planning.jpg'); ?>" alt="Event Planning" class="img-fluid hero-img" style="max-width: 100%; border-radius: 2rem; box-shadow: 0 8px 32px rgba(80,64,135,0.10), 0 1.5px 8px rgba(0,0,0,0.08); border: 6px solid #fff;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section py-5" data-aos="fade-up" style="background-color: #fff6f0;">
    <div class="container">
        <div class="section-title text-center">
            <h2>Our Services</h2>
            <p>Discover what makes us your perfect event partner</p>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="feature-title">Event Planning</h3>
                    <p class="feature-description">Professional event planning services for weddings, corporate events, and special occasions.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                    <h3 class="feature-title">Photography</h3>
                    <p class="feature-description">Expert photographers to capture your special moments with style and precision.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hotel"></i>
                    </div>
                    <h3 class="feature-title">Venue Selection</h3>
                    <p class="feature-description">Access to the best venues and hotels for your events at competitive prices.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Destinations Section -->
<section class="destinations-section py-5" data-aos="fade-up" style="background-color: #f8f9fa">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="text-primary">Popular Destinations</h2>
            <p class="text-muted">Explore our most sought-after event locations</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="destination-card shadow-sm rounded-4 overflow-hidden">
                    <img src="<?php echo get_url('assets/images/asia.jpg'); ?>" alt="Mogadishu" class="img-fluid">
                    <div class="destination-content p-4 bg-white">
                        <h3 class="text-primary">Mogadishu</h3>
                        <p class="text-muted">The vibrant capital city with modern venues and rich cultural heritage</p>
                        <a href="<?php echo get_url('pages/destinations.php?city=mogadishu'); ?>" class="btn btn-outline-primary">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="destination-card shadow-sm rounded-4 overflow-hidden">
                    <img src="<?php echo get_url('assets/images/cbdqani.jpg'); ?>" alt="Hargeisa" class="img-fluid">
                    <div class="destination-content p-4 bg-white">
                        <h3 class="text-primary">Hargeisa</h3>
                        <p class="text-muted">Known for its beautiful landscapes and traditional venues</p>
                        <a href="<?php echo get_url('pages/destinations.php?city=hargeisa'); ?>" class="btn btn-outline-primary">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="destination-card shadow-sm rounded-4 overflow-hidden">
                    <img src="<?php echo get_url('assets/images/garowe.jpg'); ?>" alt="Garowe" class="img-fluid">
                    <div class="destination-content p-4 bg-white">
                        <h3 class="text-primary">Garowe</h3>
                        <p class="text-muted">Perfect blend of modern facilities and natural beauty</p>
                        <a href="<?php echo get_url('pages/destinations.php?city=garowe'); ?>" class="btn btn-outline-primary">Explore</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Professional Cameraman Promo Section -->
<section class="promo-cameraman-section py-5" data-aos="fade-up" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%)">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-10">
                <div class="promo-cameraman-card shadow-lg p-5 rounded-4 position-relative d-flex flex-column flex-lg-row align-items-center justify-content-between" style="background: rgba(255, 255, 255, 0.95)">
          <div class="promo-cameraman-text text-center text-lg-start flex-fill pe-lg-5">
                        <h2 class="fw-bold mb-3" style="font-size: 2.5rem; letter-spacing: 1px; color: #1976d2">Professional Cameraman</h2>
                        <div class="display-3 fw-bold mb-2" style="color: #2196f3">20% <span style="font-size: 1.5rem; color: #374151">OFF</span></div>
            <p class="lead mb-4 text-muted">Book now and let our experienced professionals capture your special moments with style and precision. Limited time offer!</p>
                        <a href="#contact" class="btn btn-primary btn-lg px-5 fw-bold">Book Now</a>
          </div>
          <div class="promo-cameraman-img text-center mt-4 mt-lg-0 ms-lg-4">
                        <img src="<?php echo get_url('assets/images/proff_cameraman.jpg'); ?>" alt="Professional Cameraman" class="img-fluid rounded-4 shadow" style="max-width: 320px; border: 6px solid #fff" />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section py-5" data-aos="fade-up" style="background-color: #ffffff">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="text-primary">What Our Clients Say</h2>
            <p class="text-muted">Real experiences from our satisfied customers</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="testimonial-card shadow-sm rounded-4 p-4 bg-white">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left text-primary"></i>
                        <p class="text-muted">"Amazing service! The team made our wedding day truly special. Professional and attentive throughout."</p>
                    </div>
                    <div class="testimonial-author d-flex align-items-center mt-4">
                        <img src="<?php echo get_url('assets/images/ahmed2.jpg'); ?>" alt="Client 1" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="author-info ms-3">
                            <h4 class="mb-0 text-primary">Ahmed Mohamed</h4>
                            <p class="text-muted mb-0">Wedding Event</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card shadow-sm rounded-4 p-4 bg-white">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left text-primary"></i>
                        <p class="text-muted">"The photography team captured every important moment perfectly. Highly recommended!"</p>
                    </div>
                    <div class="testimonial-author d-flex align-items-center mt-4">
                        <img src="<?php echo get_url('assets/images/farah.jpg'); ?>" alt="Client 2" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="author-info ms-3">
                            <h4 class="mb-0 text-primary">Fatima Hassan</h4>
                            <p class="text-muted mb-0">Corporate Event</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card shadow-sm rounded-4 p-4 bg-white">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left text-primary"></i>
                        <p class="text-muted">"Excellent venue selection and event planning. Everything was perfect!"</p>
                    </div>
                    <div class="testimonial-author d-flex align-items-center mt-4">
                        <img src="<?php echo get_url('assets/images/salma.jpg'); ?>" alt="Client 3" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="author-info ms-3">
                            <h4 class="mb-0 text-primary">Omar Ali</h4>
                            <p class="text-muted mb-0">Birthday Celebration</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5" data-aos="fade-up" style="background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%)">
    <div class="container">
        <div class="cta-content text-center text-white">
            <h2 class="mb-4">Ready to Plan Your Perfect Event?</h2>
            <p class="lead mb-4">Let us help you create unforgettable memories</p>
            <a href="<?php echo get_url('pages/contact.php'); ?>" class="btn btn-light btn-lg px-5">Get Started</a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section py-5" data-aos="fade-up" style="background-color: #f8f9fa">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="contact-info">
                    <h2 class="text-primary mb-4">Get in Touch</h2>
                    <p class="text-muted mb-4">Have questions about our services? We're here to help!</p>
                    <div class="contact-details">
                        <div class="contact-item mb-3">
                            <i class="fas fa-phone me-2 text-primary"></i>
                            <span>+123 456 7890</span>
                        </div>
                        <div class="contact-item mb-3">
                            <i class="fas fa-envelope me-2 text-primary"></i>
                            <span>info@xafladia.com</span>
                        </div>
                        <div class="contact-item mb-3">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                            <span>123 Event Street, City</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-form bg-white p-4 rounded-4 shadow-sm">
                    <form id="contactForm">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" placeholder="Your Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="tel" class="form-control" id="phone" placeholder="Your Phone">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" id="message" rows="4" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn" style="background-color: #ff6600; color: #fff; padding: 0.75rem 2rem; font-weight: 600;">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section py-5" data-aos="fade-up" style="background-color: #ffffff">
    <div class="container">
        <div class="newsletter-content text-center">
            <h2 class="text-primary mb-4">Subscribe to Our Newsletter</h2>
            <p class="text-muted lead mb-4">Stay updated with our latest events and offers</p>
            <form id="newsletterForm" class="newsletter-form">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Enter your email" required>
                            <button type="submit" class="btn btn-primary">Subscribe</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Social Media Section -->
<section class="social-media-section py-5" data-aos="fade-up" style="background-color: #f8f9fa">
    <div class="container">
        <div class="social-media-content text-center">
            <h2 class="text-primary mb-4">Follow Us</h2>
            <div class="social-links">
                <a href="#" class="social-link btn btn-outline-primary mx-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link btn btn-outline-primary mx-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-link btn btn-outline-primary mx-2"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-link btn btn-outline-primary mx-2"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- Bootstrap JS Bundle with Popper -->
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
</script>

</body>
</html> 