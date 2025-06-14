/**
 * Main JavaScript file for Xafladia
 */

// Utility functions
function smoothScrollTo(selector) {
    document.querySelectorAll(selector).forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            // Check if the link is a Bootstrap dropdown toggle
            if (this.hasAttribute('data-bs-toggle') && this.getAttribute('data-bs-toggle') === 'dropdown') {
                // If it's a dropdown toggle, do nothing and let Bootstrap handle it
                return;
            }

            const href = this.getAttribute('href');

            // Original smooth scroll logic for non-dropdown links
            if (href.startsWith('#') && href.length > 1) {
                e.preventDefault();
                const targetId = href.substring(1);
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
}

function setActiveNavigation() {
    const currentUrl = window.location.href;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        link.classList.remove('active');

        const href = link.getAttribute('href');
        if (currentUrl.includes(href) && href !== 'index.html') {
            link.classList.add('active');
        } else if (currentUrl.endsWith('/') || currentUrl.endsWith('index.html')) {
            document.querySelector('.nav-home').classList.add('active');
        }
    });
}

function equalizeHeights(selector) {
    const elements = document.querySelectorAll(selector);
    let maxHeight = 0;

    // Reset heights
    elements.forEach(el => {
        el.style.height = 'auto';
        const height = el.offsetHeight;
        if (height > maxHeight) {
            maxHeight = height;
        }
    });

    // Apply max height
    elements.forEach(el => {
        el.style.height = maxHeight + 'px';
    });
}

function debounce(func, wait = 100) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(this, args);
        }, wait);
    };
}

/**
 * Initialize all functionality when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', function () {
    // Initialize all components
    initBootstrapComponents();
    initForms();
    initGallery();
    initAnimations();
    initServiceBooking();
});

/**
 * Initialize the application
 */
function initApp() {
    // Set up smooth scrolling
    smoothScrollTo('a[href^="#"]');

    // Highlight active navigation
    setActiveNavigation();

    // Initialize forms
    initForms();

    // Equalize heights of elements
    window.addEventListener('resize', debounce(() => {
        equalizeHeights('.service-card');
        equalizeHeights('.testimonial-card');
    }, 200));

    // Trigger resize once to equalize heights initially
    setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
    }, 100);

    // Initialize Bootstrap tooltips
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Initialize page-specific functionality
    initPageSpecific();

    // Initialize special button handling for hotel bookings
    initHotelBookings();
}

/**
 * Initialize hotel booking functionality
 */
function initHotelBookings() {
    // Handle "Book Now" buttons in the hotels page
    const bookNowButtons = document.querySelectorAll('.hotel-info .btn-primary');
    bookNowButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const hotelName = this.closest('.hotel-info').querySelector('.hotel-name').textContent;
            console.log('Booking requested for:', hotelName);

            // Scroll to booking section
            const bookingSection = document.querySelector(this.getAttribute('href'));
            if (bookingSection) {
                bookingSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
}

/**
 * Initialize page-specific functionality
 */
function initPageSpecific() {
    const url = window.location.href;

    // Services page functionality
    if (url.includes('services.php')) {
        initServicesPage();
    }

    // Gallery page functionality
    if (url.includes('gallery.php')) {
        initGalleryPage();
    }

    // CameraMan page functionality
    if (url.includes('cameraman.php')) {
        initCameramanPage();
    }

    // Hotels page functionality
    if (url.includes('hotels.php')) {
        console.log('Hotels page initialized');
    }
}

/**
 * Initialize services page functionality
 */
function initServicesPage() {
    // Add any services page specific code here
    console.log('Services page initialized');
}

/**
 * Initialize gallery page functionality
 */
function initGalleryPage() {
    // Gallery filtering functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));

            // Add active class to clicked button
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');

            // Show/hide gallery items based on filter
            galleryItems.forEach(item => {
                if (filter === 'all') {
                    item.style.display = 'block';
                } else {
                    const category = item.getAttribute('data-category');
                    if (category === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
    });

    console.log('Gallery page initialized');
}

/**
 * Initialize cameraman page functionality
 */
function initCameramanPage() {
    // Filter functionality for cameraman search
    const cityFilter = document.getElementById('cityFilter');
    const specialtyFilter = document.getElementById('specialtyFilter');
    const ratingFilter = document.getElementById('ratingFilter');
    const cameramanCards = document.querySelectorAll('.cameraman-card');

    // Combined filter function
    function filterCameramen() {
        const cityValue = cityFilter ? cityFilter.value : 'all';
        const specialtyValue = specialtyFilter ? specialtyFilter.value : 'all';
        const ratingValue = ratingFilter ? parseInt(ratingFilter.value) : 0;

        cameramanCards.forEach(card => {
            const city = card.getAttribute('data-city');
            const specialty = card.getAttribute('data-specialty');
            const rating = parseInt(card.getAttribute('data-rating'));

            const cityMatch = cityValue === 'all' || city === cityValue;
            const specialtyMatch = specialtyValue === 'all' || specialty === specialtyValue;
            const ratingMatch = rating >= ratingValue;

            if (cityMatch && specialtyMatch && ratingMatch) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Add event listeners to filters
    if (cityFilter) cityFilter.addEventListener('change', filterCameramen);
    if (specialtyFilter) specialtyFilter.addEventListener('change', filterCameramen);
    if (ratingFilter) ratingFilter.addEventListener('change', filterCameramen);

    console.log('CameraMan page initialized');
}

// Dark Mode Toggle - Removed
document.addEventListener('DOMContentLoaded', function () {
    // Initialize AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            // Check if the link is a Bootstrap dropdown toggle
            if (this.hasAttribute('data-bs-toggle') && this.getAttribute('data-bs-toggle') === 'dropdown') {
                // If it's a dropdown toggle, do nothing and let Bootstrap handle it
                return;
            }

            const href = this.getAttribute('href');

            // Original smooth scroll logic for non-dropdown links
            if (href && href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            } else if (href === '#') {
                // For href="#", do not prevent default, let Bootstrap handle it.
                // No smooth scroll needed.
            }
        });
    });

    // Navbar scroll behavior
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
});

// Handler for dark mode toggle - Removed
function toggleDarkModeHandler() {
    // Function removed as dark mode is disabled
    return;
}

// Remove redundant dark mode initialization
function initDarkMode() {
    // This function is no longer needed as dark mode is disabled
    return;
}

// Main JavaScript file for Xafladia

// Initialize Bootstrap Components
function initBootstrapComponents() {
    // Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Initialize AOS animations
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    }

    // Initialize all dropdowns using Bootstrap's API
    const dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
    dropdownElementList.map(function (dropdownToggleEl) {
      return new bootstrap.Dropdown(dropdownToggleEl);
    });
}

/**
 * Initialize forms functionality
 */
function initForms() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            // Get form type from data attribute or form id
            const formType = this.getAttribute('data-form-type') || this.id;
            handleFormSubmit(this, formType);
        });
    });
}

/**
 * Handle form submission
 * @param {HTMLFormElement} form - The form element
 * @param {string} type - Form type identifier
 */
function handleFormSubmit(form, type) {
    // Basic form handling logic
    console.log(`Form submission for ${type}`);

    // Default form processing can be added here
}

// Alert System
function showAlert(type, message) {
    // Create alert container if it doesn't exist
    let alertContainer = document.querySelector('.alert-container');
    if (!alertContainer) {
        alertContainer = document.createElement('div');
        alertContainer.className = 'alert-container position-fixed top-0 end-0 p-3';
        document.body.appendChild(alertContainer);
    }

    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    // Add to container
    alertContainer.appendChild(alertDiv);

    // Auto dismiss after 5 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Gallery System
function initGallery() {
    const galleryItems = document.querySelectorAll('.gallery-item');

    galleryItems.forEach(item => {
        item.addEventListener('click', function () {
            const imgSrc = this.querySelector('img').src;
            const modal = new bootstrap.Modal(document.getElementById('galleryModal'));
            document.getElementById('modalImage').src = imgSrc;
            modal.show();
        });
    });
}

// Animations
function initAnimations() {
    // Add animation classes to elements
    document.querySelectorAll('.animate-on-scroll').forEach(element => {
        element.classList.add('fade-up');
    });

    // Intersection Observer for scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.fade-up').forEach(element => {
        observer.observe(element);
    });
}

// Service Booking
function initServiceBooking() {
    const bookButtons = document.querySelectorAll('.book-btn, .book-professional-btn');

    bookButtons.forEach(button => {
        button.addEventListener('click', function () {
            const service = this.dataset.service;
            const professional = this.dataset.professional;

            // Set values in booking form
            if (service) {
                document.getElementById('service').value = service;
            }
            if (professional) {
                document.getElementById('professional').value = professional;
            }

            // Scroll to booking section
            const bookingSection = document.getElementById('booking');
            if (bookingSection) {
                bookingSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
} 