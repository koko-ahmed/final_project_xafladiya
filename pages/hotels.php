<?php
require_once '../config/config.php';
$page_title = $site_name . ' - Event Venues & Halls';
$current_page = 'hotels';
include '../includes/header.php';
?>

<!-- Custom CSS for venue page -->
<link rel="stylesheet" href="<?php echo get_url('assets/css/venue-styles.css'); ?>">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Hero Section -->
<section class="venues-hero text-center">
    <div class="hero-background" style="background-image: url('https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2098&q=80')"></div>
    <div class="container">
        <h1 class="display-4 animate-on-scroll fade-up">Find Your Perfect Event Venue</h1>
        <p class="lead mx-auto animate-on-scroll fade-up">Discover and book amazing spaces for weddings, conferences, parties, and more</p>
        <div class="mt-4 animate-on-scroll fade-up d-flex justify-content-center flex-wrap gap-3">
            <a href="#venues" class="btn btn-primary cta-button">Browse Venues</a>
        </div>
    </div>
</section>

<!-- Venues Section -->
<section id="venues" style="padding: 50px 0; background: linear-gradient(135deg, #4a90e2 0%, #2c3e50 100%); margin-top: 30px; margin-bottom: 30px;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 15px;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="color: #ffffff; font-size: 36px; font-weight: bold; margin-bottom: 15px; font-family: 'Poppins', sans-serif; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">Featured Venues</h2>
            <p style="color: #ffffff; font-size: 18px; margin: 0; font-family: 'Poppins', sans-serif; opacity: 0.9;">
                Discover our collection of premium event spaces
            </p>
        </div>

        <div class="row g-4">
            

            <?php
            // Fetch venues from the database
            $venues = [];
            $query = "SELECT id, name, location, description, price, capacity, features, events, image FROM venues ORDER BY name";
            $result = mysqli_query($db, $query);

            if ($result) {
                while ($venue = mysqli_fetch_assoc($result)) {
                    $venues[] = $venue;
                }
                mysqli_free_result($result);
            } else {
                // Optional: Display an error message if fetching fails
                // echo '<div class="col-12 text-center">Error loading additional venues.</div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Display Dynamically Loaded Venues -->
<section id="dynamic-venues" style="padding: 30px 0; background: #f8f9fa;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 15px;">
        <div class="row g-4">
            <?php if (empty($venues)): ?>
                <div class="col-12 text-center">
                    <p>No venues found.</p>
                </div>
            <?php else: ?>
                <?php foreach ($venues as $venue): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-once="true">
                        <div class="venue-card">
                            <div class="venue-img-wrapper">
                                <?php if (!empty($venue['image'])): ?>
                                    <img src="<?php echo get_url($venue['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($venue['name']); ?>" 
                                         class="img-fluid lazy-load"
                                         loading="lazy" />
                                <?php else: ?>
                                    <img src="<?php echo get_url('assets/images/placeholder.jpg'); ?>" 
                                         alt="No Image Available" 
                                         class="img-fluid lazy-load"
                                         loading="lazy" />
                                <?php endif; ?>

                                <?php if (!empty($venue['price'])): ?>
                                    <div class="venue-price"><?php echo htmlspecialchars($venue['price']); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="venue-info">
                                <h4 class="venue-name"><?php echo htmlspecialchars($venue['name']); ?></h4>
                                <p class="venue-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($venue['location']); ?></p>
                                 <div class="venue-capacity">
                                    <i class="fas fa-users"></i> Up to <?php echo htmlspecialchars($venue['capacity']); ?> guests
                                </div>
                                    <div class="venue-features">
                                        <?php 
                                        $features = explode(', ', $venue['features']);
                                        $feature_icons = [
                                            'AC' => 'snowflake',
                                            'Parking' => 'parking',
                                            'WiFi' => 'wifi',
                                            'Sound System' => 'music',
                                            'Catering' => 'utensils',
                                            'Projector' => 'tv',
                                            'Decoration' => 'paint-brush',
                                            'Outdoor Space' => 'tree',
                                            'Photography' => 'camera',
                                            'Bar Service' => 'glass-martini-alt',
                                            'Weather Protection' => 'umbrella',
                                            'Exhibition Space' => 'booth-curtain',
                                            'AV Equipment' => 'tv'
                                        ];
                                        foreach($features as $feature): 
                                            $feature = trim($feature);
                                        if (!empty($feature)) { // Prevent empty features from creating blank spans
                                            $icon = $feature_icons[$feature] ?? 'check';
                                        ?>
                                            <span class="feature-tooltip" data-bs-toggle="tooltip" title="<?php echo htmlspecialchars($feature); ?>">
                                                <i class="fas fa-<?php echo $icon; ?>"></i>
                                            </span>
                                    <?php 
                                        }
                                    endforeach; 
                                    ?>
                                    </div>
                                    <div class="venue-events">
                                        <?php foreach(explode(', ', $venue['events']) as $event): ?>
                                        <?php if (!empty(trim($event))): ?>
                                            <span class="event-tag"><?php echo htmlspecialchars(trim($event)); ?></span>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <button class="btn btn-primary w-100 mt-3 book-venue-btn" data-venue-id="<?php echo $venue['id']; ?>">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Add Venue Modal -->
<div class="modal fade" id="addVenueModal" tabindex="-1" aria-labelledby="addVenueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVenueModalLabel">Add Your Venue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addVenueForm" class="needs-validation" novalidate>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Venue Name</label>
                            <input type="text" class="form-control" name="venueName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Location</label>
                            <select class="form-select" name="location" required>
                                <option value="">Select Location</option>
                                <option value="mogadishu">Mogadishu</option>
                                <option value="hargeisa">Hargeisa</option>
                                <option value="bosaso">Bosaso</option>
                                <option value="kismayo">Kismayo</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Capacity</label>
                            <input type="number" class="form-control" name="capacity" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price per Day ($)</label>
                            <input type="number" class="form-control" name="price" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Supported Event Types</label>
                            <div class="event-type-checkboxes">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="eventTypes[]" value="wedding">
                                    <label class="form-check-label">Weddings</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="eventTypes[]" value="conference">
                                    <label class="form-check-label">Conferences</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="eventTypes[]" value="party">
                                    <label class="form-check-label">Parties</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="eventTypes[]" value="corporate">
                                    <label class="form-check-label">Corporate Events</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Facilities Available</label>
                            <div class="facilities-checkboxes">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="facilities[]" value="ac">
                                    <label class="form-check-label">Air Conditioning</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="facilities[]" value="sound">
                                    <label class="form-check-label">Sound System</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="facilities[]" value="parking">
                                    <label class="form-check-label">Parking</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="facilities[]" value="catering">
                                    <label class="form-check-label">Catering</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="facilities[]" value="wifi">
                                    <label class="form-check-label">WiFi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Venue Images</label>
                            <input type="file" class="form-control" name="venueImages[]" multiple accept="image/*" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Name</label>
                            <input type="text" class="form-control" name="contactName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Phone</label>
                            <input type="tel" class="form-control" name="contactPhone" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="addVenueForm" class="btn btn-primary">Submit Venue</button>
            </div>
        </div>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> 
        <div class="modal-content">
            <div class="modal-header border-0 bg-gradient">
                <h5 class="modal-title fw-bold" id="bookingModalLabel">Complete Your Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="bookingForm" class="needs-validation" novalidate>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="eventDate" name="eventDate" required>
                                <label for="eventDate">
                                    <i class="fas fa-calendar me-2"></i>Event Date
                                </label>
                                <div class="invalid-feedback">Please select your event date</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="eventType" name="eventType" required>
                                    <option value="">Select Event Type</option>
                                    <option value="wedding">Wedding</option>
                                    <option value="conference">Conference</option>
                                    <option value="party">Party</option>
                                    <option value="corporate">Corporate Event</option>
                                </select>
                                <label for="eventType">
                                    <i class="fas fa-glass-cheers me-2"></i>Event Type
                                </label>
                                <div class="invalid-feedback">Please select your event type</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="guestCount" name="guestCount" min="1" required>
                                <label for="guestCount">
                                    <i class="fas fa-users me-2"></i>Number of Guests
                                </label>
                                <div class="invalid-feedback">Please enter the number of guests</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="duration" name="duration" min="1" required>
                                <label for="duration">
                                    <i class="fas fa-clock me-2"></i>Duration (Hours)
                                </label>
                                <div class="invalid-feedback">Please specify the duration</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="requirements" name="requirements" style="height: 100px"></textarea>
                                <label for="requirements">
                                    <i class="fas fa-comment-alt me-2"></i>Special Requirements
                                </label>
                            </div>
                        </div>

                        <!-- Payment Section -->
                        <div class="col-12 mt-4">
                            <h6 class="section-title">
                                <i class="fas fa-credit-card me-2"></i>Select Payment Method
                            </h6>
                            <div class="payment-methods">
                                <!-- Credit Cards -->
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="paymentMethod" id="cardPayment" value="card" required>
                                    <label class="payment-label" for="cardPayment">
                                        <div class="payment-icons">
                                            <img src="https://img.icons8.com/color/96/000000/visa.png" alt="Visa" class="payment-icon">
                                            <img src="https://img.icons8.com/color/96/000000/mastercard.png" alt="MasterCard" class="payment-icon">
                                            <img src="https://img.icons8.com/color/96/000000/amex.png" alt="American Express" class="payment-icon">
                                        </div>
                                        <span>Credit/Debit Card</span>
                                    </label>
                                    <div class="payment-details-container" id="card-details"></div>
                                </div>

                                <!-- PayPal -->
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="paymentMethod" id="paypalPayment" value="paypal" required>
                                    <label class="payment-label" for="paypalPayment">
                                        <div class="payment-icons">
                                            <img src="https://img.icons8.com/color/96/000000/paypal.png" alt="PayPal" class="payment-icon">
                                        </div>
                                        <span>PayPal</span>
                                    </label>
                                </div>

                                <!-- Mobile Money -->
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="paymentMethod" id="evcPayment" value="evc" required>
                                    <label class="payment-label" for="evcPayment">
                                        <div class="payment-icons">
                                            <img src="https://img.icons8.com/color/96/000000/mobile-payment.png" alt="EVC Plus" class="payment-icon">
                                        </div>
                                        <span>EVC Plus</span>
                                    </label>
                                    <div class="payment-details-container" id="evc-details"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-lock me-2"></i>Complete Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Payment Success Modal -->
<div class="modal fade" id="paymentSuccessModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <div class="success-animation mb-4">
                    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                        <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                    </svg>
                </div>
                <h3 class="mb-3">Payment Successful!</h3>
                <p class="text-muted mb-4">Your booking has been confirmed. Check your email for details.</p>
                <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Payment Section in Booking Modal -->
<script type="text/template" id="cardPaymentTemplate">
    <div class="payment-details card-details">
        <div class="row g-3">
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="cardNumber" placeholder="Card Number" required pattern="[0-9]{16}">
                    <label for="cardNumber"><i class="fas fa-credit-card me-2"></i>Card Number</label>
                    <div class="invalid-feedback">Please enter a valid 16-digit card number</div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="cardHolder" placeholder="Card Holder Name" required>
                    <label for="cardHolder"><i class="fas fa-user me-2"></i>Card Holder Name</label>
                    <div class="invalid-feedback">Please enter the card holder name</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required pattern="(0[1-9]|1[0-2])\/([0-9]{2})">
                    <label for="expiryDate"><i class="fas fa-calendar-alt me-2"></i>Expiry Date</label>
                    <div class="invalid-feedback">Please enter a valid expiry date (MM/YY)</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="cvv" placeholder="CVV" required pattern="[0-9]{3,4}">
                    <label for="cvv"><i class="fas fa-lock me-2"></i>CVV</label>
                    <div class="invalid-feedback">Please enter a valid CVV</div>
                </div>
            </div>
        </div>
    </div>
</script>

<script type="text/template" id="mobilePaymentTemplate">
    <div class="payment-details mobile-details">
        <div class="row g-3">
            <div class="col-12">
                <div class="form-floating">
                    <input type="tel" class="form-control" id="phoneNumber" placeholder="Phone Number" required pattern="[0-9]{10}">
                    <label for="phoneNumber"><i class="fas fa-phone me-2"></i>Phone Number</label>
                    <div class="invalid-feedback">Please enter a valid phone number</div>
                </div>
            </div>
        </div>
    </div>
</script>
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

<!-- Add hero.js before closing body tag -->
<script src="assets/js/hero.js"></script>

<!-- Custom JS for venue page -->
<script src="<?php echo get_url('assets/js/venue.js'); ?>"></script>

<!-- Add this before the closing body tag -->
<script src="<?php echo get_url('assets/js/payment-validation.js'); ?>"></script>

<style>
/* Modern Card Styles */
.venue-card {
    background: linear-gradient(to bottom, #ffffff, #f8f9fa);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-bottom: 30px;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 
                0 2px 4px -1px rgba(0,0,0,0.06);
}

.venue-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 
                0 10px 10px -5px rgba(0,0,0,0.04);
}

.venue-img-wrapper {
    position: relative;
    height: 240px;
    overflow: hidden;
}

.venue-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.venue-card:hover .venue-img-wrapper img {
    transform: scale(1.05);
}

/* Modal Styles */
.modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    overflow: hidden;
}

.modal-header.bg-gradient {
    background: linear-gradient(135deg, #4f46e5, #0ea5e9);
    color: white;
    padding: 1.5rem;
}

.section-title {
    color: #1f2937;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

/* Payment Methods Styles */
.payment-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.payment-option {
    position: relative;
}

.payment-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: white;
}

.payment-icons {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 1rem;
    height: 40px;
    align-items: center;
}

.payment-icon {
    height: 100%;
    width: auto;
    object-fit: contain;
    transition: transform 0.2s ease;
}

.btn-check:checked + .payment-label {
    border-color: #4f46e5;
    background-color: #f5f3ff;
}

.payment-label:hover {
    border-color: #4f46e5;
    transform: translateY(-2px);
}

.payment-label:hover .payment-icon {
    transform: scale(1.1);
}

/* Payment Details Styles */
.payment-details {
    margin-top: 1rem;
    padding: 1.5rem;
    border-radius: 12px;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
}

.payment-details-container {
    display: none;
    margin-top: 1rem;
}

.payment-details-container.active {
    display: block;
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Form Control Styles */
.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
    color: #4f46e5;
    transform: scale(.85) translateY(-0.75rem) translateX(0.15rem);
}

.form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.1);
}

/* Responsive Styles */
@media (max-width: 768px) {
    .payment-methods {
        grid-template-columns: 1fr;
    }

    .payment-icons {
        height: 32px;
    }

    .payment-details {
        padding: 1rem;
    }
}

/* Payment Success Animation */
.success-animation {
    position: relative;
    width: 100px;
    height: 100px;
    margin: 0 auto;
}

.checkmark {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: block;
    stroke-width: 2;
    stroke: #4BB543;
    stroke-miterlimit: 10;
    box-shadow: inset 0px 0px 0px #4BB543;
    animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
}

.checkmark__circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 2;
    stroke-miterlimit: 10;
    stroke: #4BB543;
    fill: none;
    animation: stroke .6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark__check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: stroke .3s cubic-bezier(0.65, 0, 0.45, 1) .8s forwards;
}

@keyframes stroke {
    100% { stroke-dashoffset: 0; }
}

@keyframes scale {
    0%, 100% { transform: none; }
    50% { transform: scale3d(1.1, 1.1, 1); }
}

@keyframes fill {
    100% { box-shadow: inset 0px 0px 0px 30px #4BB543; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cardTemplate = document.getElementById('cardPaymentTemplate').innerHTML;
    const mobileTemplate = document.getElementById('mobilePaymentTemplate').innerHTML;
    const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
    const detailsContainers = document.querySelectorAll('.payment-details-container');

    function showPaymentDetails(methodId) {
        detailsContainers.forEach(container => {
            container.classList.remove('active');
            container.innerHTML = '';
        });

        const container = document.getElementById(`${methodId}-details`);
        if (container) {
            if (methodId === 'card') {
                container.innerHTML = cardTemplate;
            } else if (['evc', 'golis', 'sahal'].includes(methodId)) {
                container.innerHTML = mobileTemplate;
            }
            container.classList.add('active');
        }
    }

    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            showPaymentDetails(this.value);
        });
    });
});
</script>

<!-- Update Peace Conference Center image -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update Peace Conference Center image
    const peaceConferenceImg = document.querySelector('.venue-card:nth-child(2) .venue-img-wrapper img');
    if (peaceConferenceImg) {
        peaceConferenceImg.src = 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80';
    }
});
</script> 