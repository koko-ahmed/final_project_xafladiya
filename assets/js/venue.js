/**
 * Venue Page JavaScript Functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize AOS animations
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
    }

    // Initialize lazy loading for images
    initLazyLoading();

    // Initialize venue booking functionality
    initVenueBooking();

    // Initialize venue submission form
    initVenueSubmission();

    // Initialize search functionality
    initSearch();

    // Initialize payment processing
    initPaymentProcessing();
});

/**
 * Initialize lazy loading for images
 */
function initLazyLoading() {
    const lazyImages = document.querySelectorAll('.lazy-load');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '50px 0px',
        threshold: 0.01
    });

    lazyImages.forEach(img => imageObserver.observe(img));
}

/**
 * Initialize venue booking functionality
 */
function initVenueBooking() {
    const bookButtons = document.querySelectorAll('.book-venue-btn');
    const bookingModal = new bootstrap.Modal(document.getElementById('bookingModal'));
    const bookingForm = document.getElementById('bookingForm');
    const successModal = new bootstrap.Modal(document.getElementById('paymentSuccessModal'));

    bookButtons.forEach(button => {
        button.addEventListener('click', function() {
            const venueId = this.getAttribute('data-venue-id');
            const venueCard = this.closest('.venue-card');
            const venueName = venueCard.querySelector('.venue-name').textContent;
            const venuePrice = venueCard.querySelector('.venue-price').textContent;

            // Update modal with venue details
            document.getElementById('bookingModalLabel').textContent = `Book ${venueName}`;
            
            // Show booking modal
            bookingModal.show();
        });
    });

    // Handle booking form submission
    if (bookingForm) {
        bookingForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Get payment method
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
            if (!paymentMethod) {
                alert('Please select a payment method');
                return;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Processing...`;

            try {
                // Process payment
                const paymentResult = await processPayment(paymentMethod.value);
                
                if (paymentResult.success) {
                    // Only show success modal after payment is confirmed
                    bookingModal.hide();
                    this.reset();
                    setTimeout(() => {
                        successModal.show();
                    }, 500);
                } else {
                    throw new Error(paymentResult.error || 'Payment failed. Please try again.');
                }
            } catch (error) {
                alert(error.message);
            } finally {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
}

// Simulate payment processing
async function processPayment(paymentMethod) {
    // In a real implementation, this would make API calls to a payment processor
    return new Promise((resolve) => {
        setTimeout(() => {
            // Validate payment details based on method
            const isValid = validatePaymentDetails(paymentMethod);
            
            if (isValid) {
                resolve({ success: true });
            } else {
                resolve({ 
                    success: false, 
                    error: 'Invalid payment details. Please check and try again.' 
                });
            }
        }, 2000); // Simulate network delay
    });
}

// Validate payment details based on payment method
function validatePaymentDetails(paymentMethod) {
    if (paymentMethod === 'card') {
        const cardNumber = document.getElementById('cardNumber')?.value;
        const cardHolder = document.getElementById('cardHolder')?.value;
        const expiryDate = document.getElementById('expiryDate')?.value;
        const cvv = document.getElementById('cvv')?.value;

        return (
            cardNumber?.match(/^[0-9]{16}$/) &&
            cardHolder?.trim().length > 0 &&
            expiryDate?.match(/^(0[1-9]|1[0-2])\/([0-9]{2})$/) &&
            cvv?.match(/^[0-9]{3,4}$/)
        );
    } else if (paymentMethod === 'evc') {
        const phoneNumber = document.getElementById('phoneNumber')?.value;
        return phoneNumber?.match(/^[0-9]{10}$/);
    }

    return false;
}

/**
 * Initialize venue submission functionality
 */
function initVenueSubmission() {
    const venueForm = document.getElementById('addVenueForm');
    
    if (venueForm) {
        venueForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            
            // Simulate form submission
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
            
            setTimeout(() => {
                // Reset button state
                submitButton.disabled = false;
                submitButton.textContent = originalText;
                
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('addVenueModal')).hide();
                
                // Show success message
                showNotification('Venue submitted successfully!', 'success');
                
                // Reset form
                this.reset();
            }, 2000);
        });
    }
}

/**
 * Initialize search functionality
 */
function initSearch() {
    const searchBtn = document.querySelector('.search-btn');
    const eventTypeSelect = document.getElementById('eventType');
    const locationSelect = document.getElementById('location');
    const capacitySelect = document.getElementById('capacity');
    
    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            const filters = {
                eventType: eventTypeSelect.value,
                location: locationSelect.value,
                capacity: capacitySelect.value
            };
            
            // Simulate search
            const venueCards = document.querySelectorAll('.venue-card');
            venueCards.forEach(card => {
                card.style.opacity = '0.5';
                card.style.transform = 'scale(0.95)';
            });
            
            setTimeout(() => {
                venueCards.forEach(card => {
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                });
                showNotification('Search results updated', 'info');
            }, 1000);
        });
    }
}

/**
 * Initialize payment processing
 */
function initPaymentProcessing() {
    const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            const selectedMethod = this.value;
            console.log(`Selected payment method: ${selectedMethod}`);
            
            // You can add specific logic for each payment method here
            switch(selectedMethod) {
                case 'evc':
                    // Handle EVC Plus payment
                    break;
                case 'golis':
                    // Handle Golis payment
                    break;
                case 'sahal':
                    // Handle Sahal payment
                    break;
                case 'card':
                    // Handle card payment
                    break;
            }
        });
    });
}

/**
 * Show notification message
 */
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} notification-toast`;
    notification.role = 'alert';
    notification.textContent = message;
    
    // Add to document
    document.body.appendChild(notification);
    
    // Trigger animation
    setTimeout(() => notification.classList.add('show'), 100);
    
    // Remove after delay
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add custom styles for notifications
const style = document.createElement('style');
style.textContent = `
    .notification-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
        min-width: 250px;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transform: translateX(120%);
        transition: transform 0.3s ease-in-out;
    }
    
    .notification-toast.show {
        transform: translateX(0);
    }
`;
document.head.appendChild(style); 