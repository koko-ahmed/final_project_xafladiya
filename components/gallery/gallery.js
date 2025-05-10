// Gallery page specific scripts
$(document).ready(function() {
    // Initialize Lightbox
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': "Image %1 of %2"
    });
    
    // Gallery filtering
    $('.gallery-filters button').on('click', function() {
        const filter = $(this).data('filter');
        
        // Update active button
        $('.gallery-filters button').removeClass('active');
        $(this).addClass('active');
        
        // Filter items
        if (filter === 'all') {
            $('.gallery-item').fadeIn(300);
        } else {
            $('.gallery-item').hide();
            $('.gallery-item[data-category="' + filter + '"]').fadeIn(300);
        }
        
        // Button feedback animation
        $(this).addClass('btn-pulse');
        setTimeout(() => {
            $(this).removeClass('btn-pulse');
        }, 300);
    });
    
    // Load more button with proper functionality
    $('.load-more-btn').on('click', function() {
        const comingSoonModal = new bootstrap.Modal(document.getElementById('comingSoonModal'));
        $('#comingSoonModalLabel').text('More Images');
        $('#comingSoonModal .modal-body p').text('More images will be available soon as we continue to update our gallery!');
        comingSoonModal.show();
    });
    
    // Only handle special links like footer city links
    $('.footer-links a[href="#"]').on('click', function(e) {
        e.preventDefault();
        const city = $(this).text();
        const comingSoonModal = new bootstrap.Modal(document.getElementById('comingSoonModal'));
        $('#comingSoonModalLabel').text(city + ' Events');
        $('#comingSoonModal .modal-body p').text('We\'re expanding our services in ' + city + '! More event information for this location will be available soon.');
        comingSoonModal.show();
    });
    
    // Handle social media links
    $('.social-icons a').on('click', function(e) {
        e.preventDefault();
        const platform = $(this).find('i').attr('class').split(' ')[1].replace('fa-', '');
        const platformName = platform.charAt(0).toUpperCase() + platform.slice(1);
        const comingSoonModal = new bootstrap.Modal(document.getElementById('comingSoonModal'));
        $('#comingSoonModalLabel').text(platformName);
        $('#comingSoonModal .modal-body p').text('Follow us on ' + platformName + ' for updates, event announcements, and more! Our social media accounts will be active soon.');
        comingSoonModal.show();
    });
    
    // Make sure all navigation links to HTML pages work correctly
    $('a[href$=".html"]').each(function() {
        // Remove any click events that might be interfering
        $(this).off('click');
    });
    
    // Add custom CSS for gallery items and buttons
    const style = document.createElement('style');
    style.textContent = `
        .gallery-image {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .gallery-image:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .gallery-info {
            text-align: center;
            color: #fff;
            transform: translateY(20px);
            transition: transform 0.3s ease;
            padding: 0 15px;
        }
        
        .gallery-image:hover .gallery-overlay {
            opacity: 1;
        }
        
        .gallery-image:hover .gallery-info {
            transform: translateY(0);
        }
        
        .color-transition {
            transition: background-color 0.5s ease, color 0.5s ease;
        }
        
        .gallery-filters .active {
            background-color: #3498db !important;
            color: white !important;
            border-color: #3498db !important;
        }
        
        .btn-pulse {
            animation: pulse 0.3s ease-in-out;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        /* Make gallery filter buttons more interactive */
        .gallery-filters .btn {
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .gallery-filters .btn:hover:not(.active) {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    `;
    document.head.appendChild(style);
}); 