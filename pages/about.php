<?php
$page_title = 'Xafladiya - About Us';
include '../includes/header.php';
?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll(".count");

    counters.forEach(counter => {
      const update = () => {
        const target = +counter.getAttribute("data-target");
        const current = +counter.innerText;
        const step = Math.ceil(target / 100); // feel free to adjust

        if (current < target) {
          counter.innerText = `${Math.min(current + step, target)}`;
          setTimeout(update, 20);
        } else {
          counter.innerText = target;
        }
      };

      update();
    });
  });
</script>

<!-- About Hero Section with Parallax Background -->
<section class="parallax-section" style="background-image: url('https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
  <div class="parallax-overlay"></div>
  <div class="container">
    <div class="parallax-content">
      <div class="row align-items-center">
        <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
          <h1 class="display-3 fw-bold mb-4 text-white">About Xafladiya</h1>
          <p class="lead text-white mb-4">Your Ultimate Event Management Platform in Somalia</p>
          <div class="d-inline-block bg-white p-2 rounded-pill">
  <div class="d-flex justify-content-around">
    <div class="px-3 py-1 border-end border-2">
      <h2 class="h1 fw-bold text-primary mb-0"><span class="count" data-target="500">0</span>+</h2>
      <p class="mb-0">Events</p>
    </div>
    <div class="px-3 py-1 border-end border-2">
      <h2 class="h1 fw-bold text-primary mb-0"><span class="count" data-target="100">0</span>+</h2>
      <p class="mb-0">Venues</p>
    </div>
    <div class="px-3 py-1">
      <h2 class="h1 fw-bold text-primary mb-0"><span class="count" data-target="50">0</span>+</h2>
      <p class="mb-0">Cameramen</p>
    </div>
  </div>
</div>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- Our Story Section -->
<section class="py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
        <h2 class="display-5 fw-bold mb-4">Our Story</h2>
        <p class="lead">Founded in 2023, Xafladiya was created to simplify event planning and management for the Somali community.</p>
        <p class="mb-4">We understand the importance of cultural events and celebrations, and our platform is designed to make organizing these special moments easier and more efficient.</p>
        <p class="mb-4">Our mission is to connect event organizers with venue owners and professional cameramen, creating a seamless experience from planning to execution. Whether you're organizing a wedding, graduation, or corporate event, Xafladiya provides all the tools you need in one place.</p>
      </div>
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
        <div class="about-image position-relative">
          <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=800&q=80" alt="Xafladiya Team" class="img-fluid rounded-lg shadow-lg" />
          <div class="bg-primary p-4 rounded-lg shadow-lg position-absolute" style="bottom: -30px; right: -30px; max-width: 300px">
            <h4 class="text-white mb-3">Vision</h4>
            <p class="text-white mb-0">To become the leading event management platform in East Africa, revolutionizing how events are planned and executed.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Our Team Section with Animated Cards -->
<section class="team-section py-5 bg-light">
  <div class="container">
    <div class="section-title text-center mb-5" data-aos="fade-up">
      <h2>Our Team</h2>
      <p>Meet the dedicated professionals behind Xafladiya</p>
    </div>
    <div class="row g-4">
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
        <div class="card team-card h-100">
          <div class="team-image overflow-hidden text-center">
            <img src="<?php echo get_url('assets/images/Mohamed Hassan-CEO.jpg'); ?>" alt="Mohamed Hassan - CEO" style="width: 260px; height: 260px; object-fit: cover; border-radius: 12px; margin: 0 auto;" />
            <div class="team-overlay">
              <div class="social-links">
                <a href="#" class="text-white me-2"><i class="fab fa-linkedin fa-lg"></i></a>
                <a href="#" class="text-white me-2"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-white"><i class="fas fa-envelope fa-lg"></i></a>
              </div>
            </div>
          </div>
          <div class="card-body text-center">
            <h5 class="card-title mb-1">Mohamed Hassan</h5>
            <p class="text-muted mb-0">Founder & CEO</p>
          </div>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
        <div class="card team-card h-100">
          <div class="team-image overflow-hidden text-center">
            <img src="<?php echo get_url('assets/images/Amina Ali-CTO.jpg'); ?>" alt="Amina Ali - CTO" style="width: 260px; height: 260px; object-fit: cover; border-radius: 12px; margin: 0 auto;" />
            <div class="team-overlay">
              <div class="social-links">
                <a href="#" class="text-white me-2"><i class="fab fa-linkedin fa-lg"></i></a>
                <a href="#" class="text-white me-2"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-white"><i class="fas fa-envelope fa-lg"></i></a>
              </div>
            </div>
          </div>
          <div class="card-body text-center">
            <h5 class="card-title mb-1">Amina Ali</h5>
            <p class="text-muted mb-0">CTO</p>
          </div>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
        <div class="card team-card h-100">
          <div class="team-image overflow-hidden text-center">
            <img src="<?php echo get_url('assets/images/Ahmed-Omar-Marketing-Director.jpg'); ?>" alt="Ahmed Omar - Marketing Director" style="width: 260px; height: 260px; object-fit: cover; border-radius: 12px; margin: 0 auto;" />
            <div class="team-overlay">
              <div class="social-links">
                <a href="#" class="text-white me-2"><i class="fab fa-linkedin fa-lg"></i></a>
                <a href="#" class="text-white me-2"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-white"><i class="fas fa-envelope fa-lg"></i></a>
              </div>
            </div>
          </div>
          <div class="card-body text-center">
            <h5 class="card-title mb-1">Ahmed Omar</h5>
            <p class="text-muted mb-0">Marketing Director</p>
          </div>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
        <div class="card team-card h-100">
          <div class="team-image overflow-hidden text-center">
            <img src="<?php echo get_url('assets/images/Fatima-Mohamed-Customer-Support Manager.jpg'); ?>" alt="Fatima Mohamed - Customer Support Manager" style="width: 260px; height: 260px; object-fit: cover; border-radius: 12px; margin: 0 auto;" />
            <div class="team-overlay">
              <div class="social-links">
                <a href="#" class="text-white me-2"><i class="fab fa-linkedin fa-lg"></i></a>
                <a href="#" class="text-white me-2"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-white"><i class="fas fa-envelope fa-lg"></i></a>
              </div>
            </div>
          </div>
          <div class="card-body text-center">
            <h5 class="card-title mb-1">Fatima Mohamed</h5>
            <p class="text-muted mb-0">Customer Support Manager</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Our Values Section with Animated Cards -->
<section class="modern-section-alt py-5" style="background-color: var(--card-bg-2); color: var(--light-color)">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="modern-title text-white">Our Values</h2>
      <div class="modern-divider modern-divider-center"></div>
      <p class="text-white mb-4">The principles that guide our work</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="modern-card h-100">
          <div class="text-center mb-4">
            <i class="fas fa-handshake fa-3x modern-icon"></i>
          </div>
          <h3 class="modern-title text-center mb-3">Trust & Reliability</h3>
          <p class="modern-text text-center">We believe in building trust through reliability and consistency in our services. Our customers can always count on us to deliver excellence.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="modern-card h-100">
          <div class="text-center mb-4">
            <i class="fas fa-star fa-3x modern-icon"></i>
          </div>
          <h3 class="modern-title text-center mb-3">Excellence</h3>
          <p class="modern-text text-center">We strive for excellence in every aspect of our platform and customer service. We're constantly innovating to provide the best experience possible.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="modern-card h-100">
          <div class="text-center mb-4">
            <i class="fas fa-users fa-3x modern-icon"></i>
          </div>
          <h3 class="modern-title text-center mb-3">Community</h3>
          <p class="modern-text text-center">We're deeply committed to the Somali community and understand the cultural significance of the events we help organize.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- AOS Animation Library -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- Custom JS -->
<script src="../assets/js/script.js"></script>
<script>
  $(document).ready(function () {
    // Initialize AOS animation library
    AOS.init({
      duration: 800,
      once: true,
      offset: 100,
    });
  });
</script>

</body>
</html> 