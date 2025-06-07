<?php
require_once 'config/config.php';
$page_title = $site_name . ' - ' . $site_description;
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Xafladia</title>
    <link rel="stylesheet" href="assets/css/hero.css">
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add your other CSS files -->
</head>
<style>
        /* Carousel base styles */
        #cityCarousel {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            background: #f8f9fa;
            margin: 0;
            position: relative;
        }
        .carousel-inner {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            height: auto !important;
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        .carousel-item {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: auto !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            transition: transform .6s ease-in-out;
            transform: translateX(100%);
        }
        .carousel-item.active {
            position: relative;
            transform: translateX(0);
        }
        .carousel-item-next:not(.carousel-item-start),
        .active.carousel-item-end {
            transform: translateX(100%);
        }
        .carousel-item-prev:not(.carousel-item-end),
        .active.carousel-item-start {
            transform: translateX(-100%);
        }
        .city-card {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            height: 100%;
            background: white;
            margin: 10px 10px 0 10px;
            margin-bottom: 0 !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        .city-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(25, 118, 210, 0.3);
            cursor: pointer;
        }
        .city-card img {
            transition: transform 0.3s ease;
        }
        .city-card:hover img {
            transform: scale(1.1);
        }
        .rating {
            font-size: 1.2rem;
            color: #fbbf24;
            letter-spacing: 2px;
        }
        .star-muted {
            color: #ddd;
        }
        .carousel-control-prev,
        .carousel-control-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background-color: rgba(25, 118, 210, 0.9);
            border-radius: 50%;
            opacity: 1;
            z-index: 10;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background-color: rgba(25, 118, 210, 1);
            transform: translateY(-50%) scale(1.1);
        }
        .carousel-control-prev {
            left: 10px;
        }
        .carousel-control-next {
            right: 10px;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 24px;
            height: 24px;
            color: white;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .carousel-control-prev-icon i,
        .carousel-control-next-icon i {
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }
        .carousel-item .row {
            margin-bottom: 0 !important;
            padding: 0 !important; /* Force no padding on rows within carousel items */
        }
    </style>

<body>
    <div class="hero-section">
        <!-- Video Slider -->
        <div class="video-slider">
            <video class="hero-bg-video active" autoplay loop muted playsinline>
                <source src="assets/videos/sliderVideo.mp4" type="video/mp4">
            </video>
            <video class="hero-bg-video" autoplay loop muted playsinline>
                <source src="assets/videos/sliderVideo2.mp4" type="video/mp4">
            </video>
            <video class="hero-bg-video" autoplay loop muted playsinline>
                <source src="assets/videos/sliderVideo3.mp4" type="video/mp4">
            </video>
            <video class="hero-bg-video" autoplay loop muted playsinline>
                <source src="assets/videos/sliderVideo4.mp4" type="video/mp4">
            </video>
        </div>
        <div class="content-overlay"></div>

        <!-- Hero Content -->
        <div class="hero-content text-center text-white" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2;">
            <h1 class="display-4 fw-bold mb-4">Welcome to Xafladia</h1>
            <p class="lead mb-4">Discover top events, premium services, and beautiful venues</p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="<?php echo get_url('pages/events.php'); ?>" class="btn btn-outline-light btn-lg">
                    Explore Events
                </a>
                <a href="<?php echo get_url('pages/contact.php'); ?>" class="btn btn-outline-light btn-lg">
                    Contact Us
                </a>
            </div>
        </div>
        <div class="slider-nav">
            <button class="nav-button prev-button">&#10094;</button>
            <button class="nav-button next-button">&#10095;</button>
        </div>
    </div>

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

    <!-- About Us Section (Brief) -->
    <section class="about-us-brief-section py-5" data-aos="fade-up" style="background-color: #eef7ff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-3">About Xafladia</h2>
                    <p class="lead mb-4">Xafladia is your premier partner for unforgettable events in Somalia. From elegant weddings to successful corporate gatherings, we provide comprehensive event planning, top-tier photography, and access to the finest venues across the country.</p>
                    <p>Our dedicated team works tirelessly to bring your vision to life, ensuring every detail is meticulously handled for a seamless and memorable experience. Discover the ease of planning with Xafladia.</p>
                    <a href="<?php echo get_url('pages/about.php'); ?>" 
   class="btn mt-3" 
   style="background-color: blue; color: white; padding: 10px 20px; border-radius: 5px; display: inline-block; text-decoration: none;" id="aboutUsBtn">
  Learn More About Us
</a>

                </div>
                <div class="col-lg-6">
                    <img src="<?php echo get_url('assets/images/event-planning.jpg'); ?>" alt="About Us Image" class="img-fluid rounded-4 shadow-lg" />
                </div>
            </div>
        </div>
    </section>

    <!-- Top Cities Section -->
    <section class="top-cities-section py-0" data-aos="fade-up" style="background: #f9fafb; margin-bottom: 0 !important;">
    <div class="container pb-0">
        <h2 class="text-center fw-bold" style="color: #1976d2; margin-bottom: 0 !important;">Top Cities</h2>

        <div id="cityCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- City Slide 1 -->
                <div class="carousel-item active">
                    <div class="row justify-content-center">
                        <div class="col-md-4 py-0">
                            <div class="city-card shadow-sm rounded-4 px-4 py-0 text-center bg-white">
                                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=600&auto=format&fit=crop&q=60" alt="Mogadishu" class="img-fluid rounded-3 mb-0" style="height:200px; object-fit:cover; border-radius: 12px;">
                                <h5 class="fw-bold mb-0">Mogadishu</h5>
                                <div class="rating mb-0">
                                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                                </div>
                                <p class="text-muted small mb-0">The vibrant capital city with a rich history and beautiful coastline.</p>
                            </div>
                        </div>
                        <div class="col-md-4 py-0">
                            <div class="city-card shadow-sm rounded-4 px-4 py-0 text-center bg-white">
                                <img src="https://images.unsplash.com/photo-1494526585095-c41746248156?w=600&auto=format&fit=crop&q=60" alt="Hargeisa" class="img-fluid rounded-3 mb-0" style="height:200px; object-fit:cover; border-radius: 12px;">
                                <h5 class="fw-bold mb-0">Hargeisa</h5>
                                <div class="rating mb-0">
                                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star star-muted">☆</span>
                                </div>
                                <p class="text-muted small mb-0">A bustling city known for its lively markets and surrounding natural beauty.</p>
                            </div>
                        </div>
                        <div class="col-md-4 py-0">
                            <div class="city-card shadow-sm rounded-4 px-4 py-0 text-center bg-white">
                                <img src="https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=600&auto=format&fit=crop&q=60" alt="Bosaso" class="img-fluid rounded-3 mb-0" style="height:200px; object-fit:cover; border-radius: 12px;">
                                <h5 class="fw-bold mb-0">Bosaso</h5>
                                <div class="rating mb-0">
                                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star star-muted">☆</span><span class="star star-muted">☆</span>
                                </div>
                                <p class="text-muted small mb-0">A key port city in the north, known for its trade and coastal views.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- City Slide 2 -->
                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <div class="col-md-4 py-0">
                            <div class="city-card shadow-sm rounded-4 px-4 py-0 text-center bg-white">
                                <img src="https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?w=600&auto=format&fit=crop&q=60" alt="Kismayo" class="img-fluid rounded-3 mb-0" style="height:200px; object-fit:cover; border-radius: 12px;">
                                <h5 class="fw-bold mb-0">Kismayo</h5>
                                <div class="rating mb-0">
                                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star star-muted">☆</span>
                                </div>
                                <p class="text-muted small mb-0">A southern port city with beautiful beaches and historical significance.</p>
                            </div>
                        </div>
                        <div class="col-md-4 py-0">
                            <div class="city-card shadow-sm rounded-4 px-4 py-0 text-center bg-white">
                                <img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=600&auto=format&fit=crop&q=60" alt="Garowe" class="img-fluid rounded-3 mb-0" style="height:200px; object-fit:cover; border-radius: 12px;">
                                <h5 class="fw-bold mb-0">Garowe</h5>
                                <div class="rating mb-0">
                                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star star-muted">☆</span>
                                </div>
                                <p class="text-muted small mb-0">The administrative capital of Puntland, known for its development.</p>
                            </div>
                        </div>
                        <div class="col-md-4 py-0">
                            <div class="city-card shadow-sm rounded-4 px-4 py-0 text-center bg-white">
                                <img src="https://images.unsplash.com/photo-1561488111-5d800fd56b8a?w=600&auto=format&fit=crop&q=60" alt="Burao" class="img-fluid rounded-3 mb-0" style="height:200px; object-fit:cover; border-radius: 12px;">
                                <h5 class="fw-bold mb-0">Burao</h5>
                                <div class="rating mb-0">
                                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                                </div>
                                <p class="text-muted small mb-0">A major city in Somaliland, famous for its livestock market.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#cityCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true">
                    <i class="fas fa-chevron-left"></i>
                </span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#cityCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true">
                    <i class="fas fa-chevron-right"></i>
                </span>
                
            </button>
        </div>
    </div>
</section>

    
    <!-- Testimonials Section -->
    <section class="testimonials-section py-0" data-aos="fade-up" style="background-color: #ffffff">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="text-primary" style="margin-bottom: 0 !important;">What Our Clients Say</h2>
                <p class="text-muted" style="margin-bottom: 0 !important;">Real experiences from our satisfied customers</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="testimonial-card shadow-sm rounded-4 p-4 bg-white">
                        <div class="testimonial-content">
                            <i class="fas fa-quote-left text-primary"></i>
                            <p class="text-muted">"Amazing service! The team made our wedding day truly special. Professional and attentive throughout."</p>
                        </div>
                        <div class="testimonial-author d-flex align-items-center mt-4">
                            <img src="<?php echo get_url('assets/images/cbdqani.jpg'); ?>" alt="Client 1" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="author-info ms-3">
                                <h4 class="mb-0 text-primary">AbdiQani Ahmed</h4>
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
                            <img src="<?php echo get_url('assets/images/naima.jpg'); ?>" alt="Client 2" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="author-info ms-3">
                                <h4 class="mb-0 text-primary">Naima Aadam</h4>
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
                            <img src="<?php echo get_url('assets/images/shakir.jpg'); ?>" alt="Client 3" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="author-info ms-3">
                                <h4 class="mb-0 text-primary">Shakir Shube</h4>
                                <p class="text-muted mb-0">Birthday Celebration</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section py-5" data-aos="fade-up" style="background-color: #f0f8ff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="newsletter-card p-4 text-center rounded-4 shadow-sm">
                        <h2 class="fw-bold mb-3" style="color: #1976d2;">Subscribe to Our Newsletter</h2>
                        <p class="lead mb-4">Get the latest news, updates, and special offers directly to your inbox!</p>
                        <form id="newsletterForm" class="d-flex justify-content-center flex-column flex-md-row">
                            <input type="email" class="form-control form-control-lg me-md-2 mb-2 mb-md-0" placeholder="Enter your email address" required style="max-width: 350px;">
                            <button type="submit" class="btn btn-lg px-4" style="background-color: blue; color: white;" id="subscribeBtn">
  Subscribe
</button>
                        </form>
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

<?php include 'includes/footer.php'; ?>

<!-- Move Bootstrap JS to just before closing body tag -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize carousel with proper options
        const carousel = document.getElementById('cityCarousel');
        if (carousel) {
            var myCarousel = new bootstrap.Carousel(carousel, {
                interval: 5000,
                wrap: true,
                touch: true,
                keyboard: true,
                pause: 'hover'
            });

            // Add event listeners for smooth transitions
            carousel.addEventListener('slide.bs.carousel', function (e) {
                const activeItem = carousel.querySelector('.carousel-item.active');
                const nextItem = carousel.querySelector('.carousel-item:nth-child(' + (e.to + 1) + ')');
                
                if (activeItem && nextItem) {
                    activeItem.style.transition = 'transform .6s ease-in-out';
                    nextItem.style.transition = 'transform .6s ease-in-out';
                }
            });
        }

        // Handle newsletter form submission
        document.getElementById('newsletterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your newsletter subscription logic here
            alert('Thank you for subscribing to our newsletter!');
            this.reset();
        });
    });

    const videos = document.querySelectorAll('.hero-bg-video');
    let current = 0;
    
    function nextVideo() {
        current = (current + 1) % videos.length;
        showVideo(current);
    }

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

    let videoInterval = setInterval(nextVideo, 8000); // 8 seconds
</script>

<!-- Add hero.js before closing body tag -->
<script src="assets/js/hero.js"></script>

<style>
    #aboutUsBtn, #subscribeBtn {
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: none; /* Ensure no default border */
    }

    #aboutUsBtn:hover, #subscribeBtn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        background-color: blue !important; /* Ensure blue color on hover */
        filter: brightness(110%); /* Slightly brighten on hover */
    }

    #aboutUsBtn:active, #subscribeBtn:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        filter: brightness(90%); /* Slightly darken on click */
    }

    .top-cities-section {
        margin-bottom: 0 !important;
    }

    .testimonials-section {
        margin-top: 0 !important;
    }

    .carousel-item .row {
        margin-bottom: 0 !important;
        padding: 0 !important; /* Force no padding on rows within carousel items */
    }
</style>
</body>
</html> 