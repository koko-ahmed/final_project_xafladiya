// Hero component JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS animations
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    }

    // Check if this is a specific page type
    const heroContainer = document.getElementById('hero-container');
    if (heroContainer) {
        const pageType = heroContainer.getAttribute('data-page');
        
        // If this is a specific page type, customize the hero
        if (pageType) {
            customizeHeroForPage(pageType);
        }
    }

    // Add hover effect to buttons
    const heroButtons = document.querySelectorAll('.hero-section .btn');
    heroButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Add parallax effect to hero image
    const heroImage = document.querySelector('.hero-section img');
    if (heroImage) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            heroImage.style.transform = `translateY(${scrolled * 0.1}px)`;
        });
    }

    // Video modal functionality
    const videoModal = document.getElementById('videoModal');
    if (videoModal) {
        videoModal.addEventListener('hidden.bs.modal', function () {
            const iframe = this.querySelector('iframe');
            if (iframe) {
                iframe.src = iframe.src; // Reset video when modal is closed
            }
        });
    }

    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const hero = document.querySelector('.hero');
        if (hero) {
            const scrolled = window.pageYOffset;
            hero.style.backgroundPositionY = scrolled * 0.5 + 'px';
        }
    });
    
    // Customize hero section based on page type
    function customizeHeroForPage(pageType) {
        const heroSection = document.querySelector('.hero-section');
        const heroTitle = heroSection.querySelector('h1');
        const heroDescription = heroSection.querySelector('p.lead');
        const heroButtons = heroSection.querySelector('.d-flex.gap-3');
        const heroImage = heroSection.querySelector('.hero-img');
        
        // Default paths for buttons
        let servicesPath = "pages/services.html";
        let contactPath = "pages/contact.html";
        
        // If we're already in the pages directory, adjust paths
        if (window.location.pathname.includes('/pages/')) {
            servicesPath = "services.html";
            contactPath = "contact.html";
        }
        
        // Customize based on page type
        switch(pageType) {
            case 'hotels':
                heroTitle.textContent = "Luxury Hotel Accommodations";
                heroDescription.textContent = "Find and book the perfect hotels in Puntland for your event guests, with comfortable rooms and exceptional amenities.";
                
                // Update hero image if available
                if (heroImage) {
                    // Check if we're in pages directory
                    const imgPrefix = window.location.pathname.includes('/pages/') ? '../' : '';
                    heroImage.src = `${imgPrefix}assets/images/blue-sun-loungers-swimming-pool_198523-20.jpg`;
                    heroImage.alt = "Luxury Hotel";
                }
                
                // Update buttons
                if (heroButtons) {
                    heroButtons.innerHTML = `
                        <a href="#hotels-container" class="btn btn-primary btn-lg">View Hotels</a>
                        <a href="${contactPath}" class="btn btn-primary btn-lg">Contact Us</a>
                    `;
                }
                break;
                
            // Add more page types as needed
            case 'events':
                heroTitle.textContent = "Create Memorable Events";
                heroDescription.textContent = "Plan and organize your special events with our comprehensive management tools and services.";
                
                // Update hero image if available
                if (heroImage) {
                    const imgPrefix = window.location.pathname.includes('/pages/') ? '../' : '';
                    heroImage.src = `${imgPrefix}assets/images/event-planning.jpg`;
                    heroImage.alt = "Event Planning";
                }
                break;
                
            case 'cameraman':
                heroTitle.textContent = "Professional Photography & Videography";
                heroDescription.textContent = "Capture your special moments with our skilled photographers and videographers.";
                
                // Update hero image if available
                if (heroImage) {
                    const imgPrefix = window.location.pathname.includes('/pages/') ? '../' : '';
                    heroImage.src = `${imgPrefix}assets/images/Professional camera equipment.jpg`;
                    heroImage.alt = "Professional Photography";
                }
                break;
        }
    }

    // Fix image paths if in pages directory
    if (window.location.pathname.includes('/pages/')) {
        document.querySelectorAll('#hero-container img').forEach(img => {
            const src = img.getAttribute('src');
            if (src && src.startsWith('../../')) {
                // Already configured for pages directory
                return;
            }
            if (src && src.startsWith('assets/')) {
                img.setAttribute('src', '../' + src);
            }
        });

        // Fix href paths
        document.querySelectorAll('#hero-container a').forEach(link => {
            const href = link.getAttribute('href');
            if (href && href.startsWith('pages/')) {
                link.setAttribute('href', href.replace('pages/', ''));
            }
        });
    }

    // Add tilt effect to quick access cards
    const cards = document.querySelectorAll('.quick-access-card');
    
    cards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const cardRect = this.getBoundingClientRect();
            const x = e.clientX - cardRect.left;
            const y = e.clientY - cardRect.top;
            
            const centerX = cardRect.width / 2;
            const centerY = cardRect.height / 2;
            
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;
            
            this.querySelector('.card').style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });
        
        card.addEventListener('mouseleave', function() {
            this.querySelector('.card').style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
        });
    });
    
    // Add subtle parallax effect to hero image
    const heroImg = document.querySelector('.hero-img-container');
    if (heroImg) {
        window.addEventListener('scroll', function() {
            const scrollPosition = window.scrollY;
            if (scrollPosition < 500) {
                heroImg.style.transform = `translateY(${scrollPosition * 0.1}px)`;
            }
        });
    }
}); 