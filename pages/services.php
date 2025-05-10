<?php
$page_title = 'Xafladiya - Our Services';
include '../includes/header.php';
?>

<!-- Services Hero Section -->
<section class="modern-hero" style="padding-top: 100px">
  <div class="container text-center position-relative" style="z-index: 1">
    <h1 class="modern-title display-4 mb-4 text-dark" data-i18n="our_services_title">Our Services</h1>
    <div class="modern-divider modern-divider-center"></div>
    <p class="modern-text lead mb-5 text-dark" data-i18n="comprehensive_solutions">
      Comprehensive solutions for planning and managing all your special events
    </p>
    <div class="d-flex justify-content-center gap-3">
      <a href="#core-services" class="btn btn-outline-primary">Explore Services</a>
      <a href="contact.php" class="btn btn-outline-primary">Contact Us</a>
    </div>
  </div>
</section>

<!-- Core Services Section (Now with solid color) -->
<section class="modern-section py-5" id="core-services" style="background-color:rgb(104, 85, 150); color: #f8f9fa;">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="modern-title" data-i18n="core_services" style="color: #f8f9fa;">Core Services</h2>
      <div class="modern-divider modern-divider-center"></div>
      <p class="modern-subtitle" data-i18n="everything_needed" style="color: #f8f9fa;">Everything you need to have a successful event</p>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="card service-card h-100">
          <div class="service-icon-circle mb-3">
            <i class="fas fa-map-marker-alt fa-2x"></i>
          </div>
          <h3 class="card-title" data-i18n="venue_booking_service">Venue Booking</h3>
          <p class="card-text" data-i18n="venue_description_full">
            Find and book the perfect venue for your event from our curated selection across major cities in Somalia. Filter by location, capacity, facilities, and price to match your specific needs.
          </p>
          <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#venueModal" data-i18n="learn_more">Learn More</button>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card service-card h-100">
          <div class="service-icon-circle mb-3">
            <i class="fas fa-camera fa-2x"></i>
          </div>
          <h3 class="card-title" data-i18n="professional_photography">Professional Photography</h3>
          <p class="card-text" data-i18n="photography_description">
            Capture your special moments with our network of professional photographers. Browse portfolios, compare pricing, and book the perfect photographer for your event, directly through our platform.
          </p>
          <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#photographyModal" data-i18n="learn_more">Learn More</button>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card service-card h-100">
          <div class="service-icon-circle mb-3">
            <i class="fas fa-tasks fa-2x"></i>
          </div>
          <h3 class="card-title" data-i18n="event_planning">Event Planning</h3>
          <p class="card-text" data-i18n="planning_description">
            Use our comprehensive planning tools to organize every aspect of your event. Create schedules, manage guest lists, communicate with service providers, and more.
          </p>
          <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#planningModal" data-i18n="learn_more">Learn More</button>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card service-card h-100">
          <div class="service-icon-circle mb-3">
            <i class="fas fa-users fa-2x"></i>
          </div>
          <h3 class="card-title" data-i18n="guest_management_title">Guest Management</h3>
          <p class="card-text" data-i18n="guest_description">
            Simplify guest management with our digital invitation system. Create and send invitations, track RSVPs, manage seating arrangements, and communicate important details to your guests.
          </p>
          <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#guestModal" data-i18n="learn_more">Learn More</button>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card service-card h-100">
          <div class="service-icon-circle mb-3">
            <i class="fas fa-utensils fa-2x"></i>
          </div>
          <h3 class="card-title" data-i18n="catering_services">Catering Services</h3>
          <p class="card-text" data-i18n="catering_description">
            Find the perfect caterer for your event, from traditional Somali cuisine to international options. Compare menus, pricing, and reviews to make the best choice for your guests.
          </p>
          <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#cateringModal" data-i18n="learn_more">Learn More</button>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card service-card h-100">
          <div class="service-icon-circle mb-3">
            <i class="fas fa-paint-brush fa-2x"></i>
          </div>
          <h3 class="card-title" data-i18n="decoration_setup">Decoration Setup</h3>
          <p class="card-text" data-i18n="decoration_description">
            Transform your venue with our decoration services. Choose from a variety of themes and styles, and let our team create the perfect atmosphere for your event.
          </p>
          <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#decorationModal" data-i18n="learn_more">Learn More</button>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>

<!-- Venue Booking Modal -->
<div class="modal fade" id="venueModal" tabindex="-1" aria-labelledby="venueModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <div class="modal-header" style="background: linear-gradient(90deg, #684596 0%, #f58f1f 100%); color: #fff;">
        
        <h5 class="modal-title" id="venueModalLabel">Venue Booking</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 mb-4 mb-md-0">
            <img src="../assets/images/venue.jpg" alt="Venue Booking" class="img-fluid rounded shadow-sm" />
          </div>
          <div class="col-md-6">
            <h4>Find the Perfect Venue</h4>
            <p>Book from our curated selection across major cities in Somalia. Filter by location, capacity, facilities, and price to match your specific needs.</p>
            <h5>Features:</h5>
            <ul>
              <li>Wide range of venues</li>
              <li>Easy booking process</li>
              <li>Verified locations</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" style="background-color: black; color: white;" data-bs-dismiss="modal">
          Close
        </button>
        <a href="contact.php" class="btn" style="background-color: #ff6600; color: white;">
          Inquire Now
        </a>
      </div>

    </div>
  </div>
</div>

<!-- Professional Photography Modal -->
<div class="modal fade" id="photographyModal" tabindex="-1" aria-labelledby="photographyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(90deg, #684596 0%, #f58f1f 100%); color: #fff;">
        <h5 class="modal-title" id="photographyModalLabel">Professional Photography</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 mb-4 mb-md-0">
            <img src="../assets/images/photography-modal.jpg" alt="Professional Photography" class="img-fluid rounded shadow-sm" />
          </div>
          <div class="col-md-6">
            <h4>Capture Your Special Moments</h4>
            <p>Our network of professional photographers ensures every moment is beautifully preserved. Browse portfolios, compare pricing, and book the perfect photographer for your event.</p>
            <h5>Features:</h5>
            <ul>
              <li>Experienced professionals</li>
              <li>Portfolio access</li>
              <li>Flexible packages</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" style="background-color: black; color: white;" data-bs-dismiss="modal">
          Close
        </button>
        <a href="contact.php" class="btn" style="background-color: #ff6600; color: white;">
          Inquire Now
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Event Planning Modal -->
<div class="modal fade" id="planningModal" tabindex="-1" aria-labelledby="planningModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(90deg, #684596 0%, #f58f1f 100%); color: #fff;">
        <h5 class="modal-title" id="planningModalLabel">Event Planning</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 mb-4 mb-md-0">
            <img src="../assets/images/Event Planning.jpg" alt="Event Planning" class="img-fluid rounded shadow-sm" />
          </div>
          <div class="col-md-6">
            <h4>Plan Every Detail</h4>
            <p>Our comprehensive planning tools help you organize every aspect of your event. Create schedules, manage guest lists, communicate with service providers, and more.</p>
            <h5>Features:</h5>
            <ul>
              <li>Custom schedules</li>
              <li>Guest management</li>
              <li>Provider communication</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" style="background-color: black; color: white;" data-bs-dismiss="modal">
          Close
        </button>
        <a href="contact.php" class="btn" style="background-color: #ff6600; color: white;">
          Inquire Now
        </a>
      </div>
    </div>
  </div>
</div>
