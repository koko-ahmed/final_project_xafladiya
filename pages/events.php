<?php
require_once '../config/config.php';
require_once '../includes/db.php';
$page_title = $site_name . ' - Events';
$current_page = 'events';

// Debug: Print base URL
echo "<!-- Debug: Base URL = " . $base_url . " -->\n";

// Debug: Check database connection
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Debug: Print events query
$query = "SELECT * FROM events WHERE status = 'active' ORDER BY event_date ASC";
$result = mysqli_query($db, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($db));
}

// Debug: Print events data
$events = [];
while ($event = mysqli_fetch_assoc($result)) {
    $events[] = $event;
    echo "<!-- Debug: Event found - ID: " . $event['id'] . ", Title: " . $event['title'] . ", Image path from DB: " . $event['image_path'] . " -->\n";
}

mysqli_free_result($result);

include '../includes/header.php';
?>

<!-- Custom CSS for events page -->
<link rel="stylesheet" href="<?php echo get_url('assets/css/venue-styles.css'); ?>">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Hero Section -->
<section class="venues-hero text-center">
    <div class="hero-background" style="background-image: url('https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80')"></div>
    <div class="container">
        <h1 class="display-4 animate-on-scroll fade-up">Discover Amazing Events</h1>
        <p class="lead mx-auto animate-on-scroll fade-up">Find and book tickets for the best events in Somalia</p>
        <div class="mt-4 animate-on-scroll fade-up d-flex justify-content-center flex-wrap gap-3">
            <a href="#events" class="btn btn-primary cta-button">Browse Events</a>
        </div>
    </div>
</section>

<!-- Events Section -->
<section id="events" style="padding: 50px 0; background: linear-gradient(135deg, #4a90e2 0%, #2c3e50 100%); margin-top: 30px; margin-bottom: 30px;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 15px;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="color: #ffffff; font-size: 36px; font-weight: bold; margin-bottom: 15px; font-family: 'Poppins', sans-serif; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">Featured Events</h2>
            <p style="color: #ffffff; font-size: 18px; margin: 0; font-family: 'Poppins', sans-serif; opacity: 0.9;">
                Discover our upcoming events
            </p>
        </div>

        <div class="row g-4">
            <?php
            // Fetch events from the database
            $events = [];
            $query = "SELECT * FROM events WHERE status = 'active' ORDER BY event_date ASC";
            $result = mysqli_query($db, $query);

            if ($result) {
                while ($event = mysqli_fetch_assoc($result)) {
                    $events[] = $event;
                }
                mysqli_free_result($result);
            }
            ?>
        </div>
    </div>
</section>

<!-- Display Dynamically Loaded Events -->
<section id="dynamic-events" style="padding: 30px 0; background: #f8f9fa;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 15px;">
        <div class="row g-4">
            <?php if (empty($events)): ?>
                <div class="col-12 text-center">
                    <p>No events found.</p>
                </div>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-once="true">
                        <div class="venue-card">
                            <div class="venue-img-wrapper">
                                <?php if (!empty($event['image_path'])): ?>
                                    <?php 
                                    $image_url = get_url($event['image_path']);
                                    echo "<!-- Debug: Image URL (generated by get_url) = " . $image_url . " -->\n";
                                    ?>
                                    <img src="<?php echo $image_url; ?>" 
                                         alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                         class="img-fluid"
                                         loading="eager" />
                                <?php else: ?>
                                    <img src="<?php echo get_url('assets/images/event-planning.jpg'); ?>" 
                                         alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                         class="img-fluid"
                                         loading="eager" />
                                <?php endif; ?>

                                <?php if (!empty($event['price'])): ?>
                                    <div class="venue-price">$<?php echo number_format($event['price'], 2); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="venue-info">
                                <h4 class="venue-name"><?php echo htmlspecialchars($event['title']); ?></h4>
                                <p class="venue-location">
                                    <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($event['location']); ?>
                                </p>
                                <p class="venue-date">
                                    <i class="fas fa-calendar"></i> <?php echo date('F j, Y', strtotime($event['event_date'])); ?>
                                    <?php if (!empty($event['event_time'])): ?>
                                        at <?php echo date('g:i A', strtotime($event['event_time'])); ?>
                                    <?php endif; ?>
                                </p>
                                <div class="venue-category">
                                    <span class="category-tag"><?php echo htmlspecialchars($event['type']); ?></span>
                                </div>
                                <?php if (!empty($event['capacity'])): ?>
                                    <p class="venue-capacity">
                                        <i class="fas fa-users"></i> Capacity: <?php echo htmlspecialchars($event['capacity']); ?> guests
                                    </p>
                                <?php endif; ?>
                                <button class="btn btn-primary w-100 mt-3 book-event-btn" data-event-id="<?php echo $event['id']; ?>">
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

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 bg-gradient">
                <h5 class="modal-title fw-bold" id="bookingModalLabel">Complete Your Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="bookingForm" action="process_event_booking.php" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" id="eventId" name="event_id" value="">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="ticketQuantity" name="ticketQuantity" min="1" required>
                                <label for="ticketQuantity">
                                    <i class="fas fa-ticket-alt me-2"></i>Number of Tickets
                                </label>
                                <div class="invalid-feedback">Please enter the number of tickets</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="fullName" name="fullName" required>
                                <label for="fullName">
                                    <i class="fas fa-user me-2"></i>Full Name
                                </label>
                                <div class="invalid-feedback">Please enter your full name</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" required>
                                <label for="email">
                                    <i class="fas fa-envelope me-2"></i>Email Address
                                </label>
                                <div class="invalid-feedback">Please enter a valid email address</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                                <label for="phone">
                                    <i class="fas fa-phone me-2"></i>Phone Number
                                </label>
                                <div class="invalid-feedback">Please enter your phone number</div>
                            </div>
                        </div>

                        <!-- Payment Section -->
                        <div class="col-12 mt-4">
                            <h6 class="section-title">
                                <i class="fas fa-credit-card me-2"></i>Select Payment Method
                            </h6>
                            <div class="payment-methods">
                                <!-- Credit/Debit Card -->
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
                                <!-- EVC Plus -->
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
                                <!-- Golis -->
                                <div class="payment-option">
                                    <input type="radio" class="btn-check" name="paymentMethod" id="golisPayment" value="golis" required>
                                    <label class="payment-label" for="golisPayment">
                                        <div class="payment-icons">
                                            <img src="https://seeklogo.com/images/G/golis-telecom-logo-6B1B1B1B1B-seeklogo.com.png" alt="Golis" class="payment-icon" style="height:32px;">
                                        </div>
                                        <span>Golis</span>
                                    </label>
                                    <div class="payment-details-container" id="golis-details"></div>
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

<!-- Payment Details Templates -->
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
<!-- Payment Method Interactivity Script -->
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

  // Add Bootstrap 5 vanilla JS code:
  document.querySelectorAll('.book-event-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var eventId = this.getAttribute('data-event-id');
      var eventIdInput = document.getElementById('eventId');
      if (eventIdInput) eventIdInput.value = eventId;
      var modal = new bootstrap.Modal(document.getElementById('bookingModal'));
      modal.show();
    });
  });
</script>
<style>
/* Event Card Styles */
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

.venue-price {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: 600;
}

.venue-info {
    padding: 20px;
}

.venue-name {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #1f2937;
}

.venue-location, .venue-date {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.venue-category {
    margin-top: 10px;
}

.category-tag {
    display: inline-block;
    padding: 4px 12px;
    background: #e5e7eb;
    color: #4b5563;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 500;
}

/* Modal Styles */
.modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
}

.modal-header.bg-gradient {
    background: linear-gradient(135deg, #4f46e5, #0ea5e9);
    color: white;
    padding: 1.5rem;
}

/* Payment Methods Styles (copied from hotels.php) */
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
</style> 