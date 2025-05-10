/**
 * Main JavaScript file for Xafladia
 */

import { applyDarkMode, toggleDarkMode, smoothScrollTo, setActiveNavigation, equalizeHeights, debounce } from './utils.js';
import { initializeLanguage } from './i18n.js';
import { initForms } from './forms.js';
import { loadCommonComponents } from './template-loader.js';

/**
 * Initialize all functionality when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', function () {
    // Load common components
    loadCommonComponents()
        .then(() => {
            // Initialize app after components are loaded
            initApp();
        })
        .catch(error => {
            console.error('Error loading components:', error);
        });
});

/**
 * Initialize the application
 */
function initApp() {
    // Initialize language support
    initializeLanguage();

    // Set up smooth scrolling
    smoothScrollTo('a[href^="#"]');

    // Highlight active navigation
    setActiveNavigation();

    // Initialize all forms
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
}

/**
 * Initialize page-specific functionality
 */
function initPageSpecific() {
    const url = window.location.href;

    // Services page functionality
    if (url.includes('services.html')) {
        initServicesPage();
    }

    // Gallery page functionality
    if (url.includes('gallery.html')) {
        initGalleryPage();
    }

    // CameraMan page functionality
    if (url.includes('cameraman.html')) {
        initCameramanPage();
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
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
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

// Initialize all functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    // Initialize all components
    initBootstrapComponents();
    initForms();
    initGallery();
    initSmoothScroll();
    initAnimations();
});

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
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
}

// Form Handling
function initForms() {
    // Contact Form
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            handleFormSubmit(this, 'contact');
        });
    }

    // Newsletter Form
    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            handleFormSubmit(this, 'newsletter');
        });
    }

    // Booking Form
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function (e) {
            e.preventDefault();
            handleFormSubmit(this, 'booking');
        });
    }
}

// Form Submission Handler
function handleFormSubmit(form, type) {
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';
    submitBtn.disabled = true;

    // Collect form data
    const formData = new FormData(form);

    // Add form type
    formData.append('form_type', type);

    // Send form data
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message || 'Form submitted successfully!');
                form.reset();
            } else {
                showAlert('danger', data.message || 'Error submitting form. Please try again.');
            }
        })
        .catch(error => {
            showAlert('danger', 'An error occurred. Please try again later.');
            console.error('Form submission error:', error);
        })
        .finally(() => {
            // Reset button state
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        });
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

// Smooth Scroll
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
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

// Initialize service booking
initServiceBooking(); 