$(document).ready(function () {
    // ======== INITIAL SETUP ========
    // Set English as the default language and disable language switching
    $('html').attr('lang', 'en');

    // ======== DARK MODE TOGGLE ========
    // Check for saved dark mode preference
    if (localStorage.getItem('darkMode') === 'enabled') {
        enableDarkMode();
    }

    // Dark Mode Toggle
    $('#darkModeToggle').click(function () {
        if (localStorage.getItem('darkMode') !== 'enabled') {
            enableDarkMode();
        } else {
            disableDarkMode();
        }
    });

    function enableDarkMode() {
        $('body').addClass('dark-mode');
        $('#darkModeToggle').html('<i class="fas fa-sun"></i>');
        localStorage.setItem('darkMode', 'enabled');
    }

    function disableDarkMode() {
        $('body').removeClass('dark-mode');
        $('#darkModeToggle').html('<i class="fas fa-moon"></i>');
        localStorage.setItem('darkMode', 'disabled');
    }

    // ======== NAVBAR SMOOTH SCROLL ========
    // Smooth scrolling for internal links in navbar
    $('.navbar-nav .nav-link').on('click', function (e) {
        const targetSection = $(this).attr('href');

        // If it's an actual section on the page (not external link)
        if (targetSection && targetSection.startsWith('#') && $(targetSection).length) {
            e.preventDefault();

            const offset = $(targetSection).offset().top - 70; // Account for fixed navbar

            $('html, body').animate({
                scrollTop: offset
            }, 800, 'easeInOutQuad');

            // Close mobile menu
            $('.navbar-collapse').collapse('hide');

            // Update active state
            $('.navbar-nav .nav-link').removeClass('active');
            $(this).addClass('active');
        }
        // If it's an external HTML page, just close the menu and let default behavior happen
        else if (targetSection && targetSection.endsWith('.html')) {
            $('.navbar-collapse').collapse('hide');
        }
    });

    // ======== BUTTON FUNCTIONALITY ========
    // "Learn More" buttons in feature cards
    $('.learn-more-btn').on('click', function (e) {
        e.preventDefault();

        // Get the feature type from the parent card
        const featureTitle = $(this).closest('.card').find('.card-title').text();

        // Show different message based on feature
        $('#comingSoonModalLabel').text(featureTitle);
        $('#comingSoonModal').modal('show');
    });

    // "Explore" buttons in city cards
    $('.explore-btn').on('click', function (e) {
        e.preventDefault();

        // Get the city name from the parent card
        const cityName = $(this).closest('.card').find('.card-title').text();

        // Show city-specific message
        $('#comingSoonModalLabel').text(cityName);
        $('#comingSoonModal .modal-body p').html('Explore events, venues and cameramen in <strong>' + cityName + '</strong>. This feature is coming soon!');
        $('#comingSoonModal').modal('show');
    });

    // Contact Us button
    $('.contact-us-btn').on('click', function (e) {
        e.preventDefault();
        $('#contactModal').modal('show');
    });

    // ======== ANIMATIONS AND EFFECTS ========
    // Button hover animation
    $('.btn').hover(
        function () {
            $(this).addClass('btn-hover-effect');
        },
        function () {
            $(this).removeClass('btn-hover-effect');
        }
    );

    // Card hover animation
    $('.card').hover(
        function () {
            $(this).addClass('card-hover-effect');
        },
        function () {
            $(this).removeClass('card-hover-effect');
        }
    );

    // Custom easing function
    $.easing.easeInOutQuad = function (x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t + b;
        return -c / 2 * ((--t) * (t - 2) - 1) + b;
    };

    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Parallax effect for background images - removed to prevent page jumping
    /* $(window).scroll(function() {
        var scrolled = $(window).scrollTop();
        $('.parallax-section').css('background-position', 'center ' + (scrolled * 0.4) + 'px');
    }); */

    // Add animation for scrolling - simplified to prevent page jumping
    $(window).scroll(function () {
        var scrollTop = $(this).scrollTop();

        // Fade in elements as they come into view
        $('.fadeIn-scroll').each(function () {
            var topDistance = $(this).offset().top;

            if (topDistance < scrollTop + $(window).height() - 100) {
                $(this).addClass('fadeIn');
            }
        });
    });

    // Ensure all images are loaded before calculating heights
    $(window).on('load', function () {
        // Set uniform height for city cards and cameraman images
        equalizeImageHeights('.city-image img');
        equalizeImageHeights('.cameraman-image img');
    });

    // Function to equalize image heights
    function equalizeImageHeights(selector) {
        const images = $(selector);
        if (images.length < 2) return;

        let maxHeight = 0;

        // Reset heights first
        images.css('height', 'auto');

        // Find the max height
        images.each(function () {
            const height = $(this).height();
            maxHeight = Math.max(maxHeight, height);
        });

        // Apply the same height to all images
        if (maxHeight > 0) {
            images.css('height', maxHeight + 'px');
            images.css('object-fit', 'cover');
        }
    }

    // Contact form functionality
    $('#sendMessageBtn').on('click', function () {
        // Get form values
        const name = $('#name').val();
        const email = $('#email').val();
        const subject = $('#subject').val();
        const message = $('#message').val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Validate inputs
        let hasError = false;

        if (!name) {
            $('#name').addClass('is-invalid');
            $('#name').after('<div class="invalid-feedback">Please enter your name.</div>');
            hasError = true;
        }

        if (!email) {
            $('#email').addClass('is-invalid');
            $('#email').after('<div class="invalid-feedback">Please enter your email address.</div>');
            hasError = true;
        } else if (!emailRegex.test(email)) {
            $('#email').addClass('is-invalid');
            $('#email').after('<div class="invalid-feedback">Please enter a valid email address.</div>');
            hasError = true;
        }

        if (!subject) {
            $('#subject').addClass('is-invalid');
            $('#subject').after('<div class="invalid-feedback">Please enter a subject.</div>');
            hasError = true;
        }

        if (!message) {
            $('#message').addClass('is-invalid');
            $('#message').after('<div class="invalid-feedback">Please enter your message.</div>');
            hasError = true;
        }

        if (!hasError) {
            // Show loader
            $('#sendMessageBtn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
            $('#sendMessageBtn').prop('disabled', true);

            // Simulate form submission (in real app, this would be an API call)
            setTimeout(function () {
                $('#contactForm').trigger('reset');
                $('#sendMessageBtn').html('Send Message');
                $('#sendMessageBtn').prop('disabled', false);
                $('#contactModal').modal('hide');
                $('#thankYouModal').modal('show');
            }, 1500);
        }
    });

    // Handle resize events
    $(window).resize(function () {
        // Re-equalize heights on resize
        equalizeImageHeights('.city-image img');
        equalizeImageHeights('.cameraman-image img');
    });
}); 