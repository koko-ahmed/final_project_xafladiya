/**
 * Hotel Page JavaScript Functionality
 */

document.addEventListener('DOMContentLoaded', function () {
    // Initialize AOS with proper settings
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            easing: 'ease-in-out',
            once: true,
            mirror: false,
            offset: 50,
            delay: 0
        });
    }

    // Make sure all sections are fully visible
    ensureSectionsVisibility();

    // Initialize animations
    initAnimations();

    // Initialize room description expanders
    initRoomExpanders();

    // Initialize review filters
    initReviewFilters();

    // Initialize room image carousels
    initRoomCarousels();

    // Initialize amenity tooltips hover effects
    initAmenityTooltips();

    // Initialize smooth scrolling for anchor links
    initSmoothScroll();

    // Add hover effects to buttons
    initButtonHoverEffects();
});

/**
 * Ensure all sections are fully visible
 */
function ensureSectionsVisibility() {
    // Make sure the hotels section is fully visible
    const hotelsSection = document.getElementById('hotels');
    if (hotelsSection) {
        hotelsSection.style.display = 'block';
        hotelsSection.style.visibility = 'visible';
        hotelsSection.style.opacity = '1';

        // Force redraw
        hotelsSection.offsetHeight;

        console.log('Hotels section initialized and visible');
    }

    // Make sure all hotel cards are visible
    const hotelCards = document.querySelectorAll('.hotel-card');
    hotelCards.forEach(card => {
        card.style.display = 'block';
        card.style.visibility = 'visible';
        card.style.opacity = '1';
    });
}

/**
 * Initialize scroll animations
 */
function initAnimations() {
    const animatedElements = document.querySelectorAll('.animate-on-scroll, [data-aos]');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, {
        threshold: 0.1
    });

    animatedElements.forEach(element => {
        observer.observe(element);
    });
}

/**
 * Initialize room description expanders
 */
function initRoomExpanders() {
    const seeMoreButtons = document.querySelectorAll('.see-more-btn');

    seeMoreButtons.forEach(button => {
        button.addEventListener('click', function () {
            const description = this.previousElementSibling;
            description.classList.toggle('room-expanded');
            this.textContent = description.classList.contains('room-expanded') ? 'See Less' : 'See More';
        });
    });
}

/**
 * Initialize review filters
 */
function initReviewFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const reviewCards = document.querySelectorAll('.review-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Update active state
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const rating = this.getAttribute('data-rating');

            reviewCards.forEach(card => {
                if (rating === 'all' || card.getAttribute('data-rating') === rating ||
                    (rating === '3' && parseInt(card.getAttribute('data-rating')) <= 3)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}

/**
 * Initialize room image carousels
 */
function initRoomCarousels() {
    // Room image data (in a real application, this would come from the server)
    const roomImages = {
        'deluxe': [
            'assets/images/hotels/rooms/deluxe1.jpg',
            'assets/images/hotels/rooms/deluxe2.jpg',
            'assets/images/hotels/rooms/deluxe3.jpg'
        ],
        'suite': [
            'assets/images/hotels/rooms/suite1.jpg',
            'assets/images/hotels/rooms/suite2.jpg',
            'assets/images/hotels/rooms/suite3.jpg'
        ],
        'family': [
            'assets/images/hotels/rooms/family1.jpg',
            'assets/images/hotels/rooms/family2.jpg',
            'assets/images/hotels/rooms/family3.jpg'
        ]
    };

    // Initialize room carousels
    const roomCards = document.querySelectorAll('.room-card');

    roomCards.forEach((card, index) => {
        const prevButton = card.querySelector('.carousel-control.prev');
        const nextButton = card.querySelector('.carousel-control.next');
        const image = card.querySelector('.room-img-carousel img');

        // Determine which room type this is based on index or other attributes
        let roomType;
        if (card.querySelector('.room-name').textContent.includes('Deluxe')) {
            roomType = 'deluxe';
        } else if (card.querySelector('.room-name').textContent.includes('Executive')) {
            roomType = 'suite';
        } else {
            roomType = 'family';
        }

        // Set the room's images array and current index
        const images = roomImages[roomType] || [];
        let currentImageIndex = 0;

        // Add click handlers for previous/next buttons
        if (prevButton && images.length > 1) {
            prevButton.addEventListener('click', function (e) {
                e.preventDefault();
                currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
                fadeImageTransition(image, images[currentImageIndex]);
            });
        }

        if (nextButton && images.length > 1) {
            nextButton.addEventListener('click', function (e) {
                e.preventDefault();
                currentImageIndex = (currentImageIndex + 1) % images.length;
                fadeImageTransition(image, images[currentImageIndex]);
            });
        }
    });
}

/**
 * Fade transition for image changes
 */
function fadeImageTransition(imgElement, newSrc) {
    imgElement.style.opacity = '0';
    setTimeout(() => {
        imgElement.src = newSrc;
        imgElement.style.opacity = '1';
    }, 300);
}

/**
 * Initialize amenity tooltips
 */
function initAmenityTooltips() {
    const amenitySpans = document.querySelectorAll('.amenity-tooltip');

    amenitySpans.forEach(span => {
        // Add hover effects if not already handled by CSS
        span.addEventListener('mouseenter', function () {
            const tooltip = this.querySelector('.tooltip-content');
            if (tooltip) {
                tooltip.style.visibility = 'visible';
                tooltip.style.opacity = '1';
            }
        });

        span.addEventListener('mouseleave', function () {
            const tooltip = this.querySelector('.tooltip-content');
            if (tooltip) {
                tooltip.style.visibility = 'hidden';
                tooltip.style.opacity = '0';
            }
        });
    });
}

/**
 * Initialize smooth scrolling for anchor links
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
}

/**
 * Initialize button hover effects
 */
function initButtonHoverEffects() {
    const buttons = document.querySelectorAll('.btn-primary, .btn-outline-light, .cta-button');

    buttons.forEach(button => {
        button.classList.add('hover-effect');
    });
}

// Pre-load room images
function preloadRoomImages() {
    const imagesToPreload = [
        'assets/images/hotels/rooms/deluxe1.jpg',
        'assets/images/hotels/rooms/deluxe2.jpg',
        'assets/images/hotels/rooms/deluxe3.jpg',
        'assets/images/hotels/rooms/suite1.jpg',
        'assets/images/hotels/rooms/suite2.jpg',
        'assets/images/hotels/rooms/suite3.jpg',
        'assets/images/hotels/rooms/family1.jpg',
        'assets/images/hotels/rooms/family2.jpg',
        'assets/images/hotels/rooms/family3.jpg'
    ];

    imagesToPreload.forEach(src => {
        const img = new Image();
        img.src = src;
    });
} 