<?php
require_once '../config/config.php';
$page_title = $site_name . ' - Hotels';
include '../includes/header.php';
?>

<!-- Hotels Section -->
<section class="hotels-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h2 class="display-5 fw-bold mb-3">Featured Hotels</h2>
            <p class="lead text-muted">Discover our selection of premium hotels for your events</p>
        </div>

        <div class="row g-4">
            <!-- Hotel 1 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="hotel-card">
                    <div class="hotel-img-wrapper">
                        <img src="<?php echo get_url('assets/images/hotels/hotel1.jpg'); ?>" alt="Luxury Hotel" class="img-fluid" />
                    </div>
                    <div class="hotel-info">
                        <h4 class="hotel-name">Luxury Resort & Spa</h4>
                        <p class="hotel-location"><i class="fas fa-map-marker-alt"></i> Mogadishu</p>
                        <div class="hotel-features">
                            <span><i class="fas fa-wifi"></i> Free WiFi</span>
                            <span><i class="fas fa-swimming-pool"></i> Pool</span>
                            <span><i class="fas fa-utensils"></i> Restaurant</span>
                        </div>
                        <div class="hotel-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>(5.0/5)</span>
                        </div>
                        <a href="#booking" class="btn btn-primary w-100 mt-3">Book Now</a>
                    </div>
                </div>
            </div>

            <!-- Hotel 2 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="hotel-card">
                    <div class="hotel-img-wrapper">
                        <img src="<?php echo get_url('assets/images/hotels/hotel2.jpg'); ?>" alt="Business Hotel" class="img-fluid" />
                    </div>
                    <div class="hotel-info">
                        <h4 class="hotel-name">Business Center Hotel</h4>
                        <p class="hotel-location"><i class="fas fa-map-marker-alt"></i> Hargeisa</p>
                        <div class="hotel-features">
                            <span><i class="fas fa-wifi"></i> Free WiFi</span>
                            <span><i class="fas fa-dumbbell"></i> Gym</span>
                            <span><i class="fas fa-coffee"></i> Cafe</span>
                        </div>
                        <div class="hotel-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span>(4.5/5)</span>
                        </div>
                        <a href="#booking" class="btn btn-primary w-100 mt-3">Book Now</a>
                    </div>
                </div>
            </div>

            <!-- Hotel 3 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="hotel-card">
                    <div class="hotel-img-wrapper">
                        <img src="<?php echo get_url('assets/images/hotels/hotel3.jpg'); ?>" alt="Boutique Hotel" class="img-fluid" />
                    </div>
                    <div class="hotel-info">
                        <h4 class="hotel-name">Boutique Beach Resort</h4>
                        <p class="hotel-location"><i class="fas fa-map-marker-alt"></i> Kismayo</p>
                        <div class="hotel-features">
                            <span><i class="fas fa-wifi"></i> Free WiFi</span>
                            <span><i class="fas fa-umbrella-beach"></i> Beach</span>
                            <span><i class="fas fa-spa"></i> Spa</span>
                        </div>
                        <div class="hotel-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>(4.8/5)</span>
                        </div>
                        <a href="#booking" class="btn btn-primary w-100 mt-3">Book Now</a>
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
</script>

</body>
</html> 