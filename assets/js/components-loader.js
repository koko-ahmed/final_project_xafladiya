/**
 * Components Loader Script
 * This script handles the loading of all components for the Xafladiya website
 */

document.addEventListener('DOMContentLoaded', function() {
    // Component paths
    const componentPaths = {
        navbar: "components/navbar/html/navbar.html",
        hero: "components/hero/html/hero.html",
        features: "components/features/html/features.html",
        testimonials: "components/testimonials/html/testimonials.html",
        hotels: "components/hotels/html/hotels.html",
        destinations: "components/destinations/html/destinations.html",
        footer: "components/footer/html/footer.html",
        contact: "components/contact/html/contact.html",
        modals: "components/modals/html/modals.html"
    };

    // Load components
    loadComponent("navbar-container", componentPaths.navbar, function() {
        // Mark the right nav item as active based on current page
        highlightActiveNavItem();
    });
    
    loadComponent("hero-container", componentPaths.hero);
    loadComponent("features-container", componentPaths.features);
    loadComponent("testimonials-container", componentPaths.testimonials);
    // Load hotels component if the container exists
    loadComponent("hotels-container", componentPaths.hotels);
    loadComponent("cities-container", componentPaths.destinations);
    loadComponent("footer-container", componentPaths.footer);
    loadComponent("contact-container", componentPaths.contact);
    loadComponent("modals-container", componentPaths.modals);

    // Initialize AOS animation library
    setTimeout(function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
        }
    }, 500);

    /**
     * Loads a component into a container element
     * @param {string} containerId - The ID of the container element
     * @param {string} componentPath - The path to the component HTML file
     * @param {function} callback - Optional callback to execute after loading
     */
    function loadComponent(containerId, componentPath, callback) {
        const container = document.getElementById(containerId);
        if (!container) return; // Skip if container doesn't exist on current page
        
        $.get(componentPath, function(data) {
            container.innerHTML = data;
            
            // Fix paths for components loaded in pages directory
            if (isInPagesDirectory()) {
                fixPathsForComponent(container);
            }
            
            if (callback && typeof callback === 'function') {
                callback();
            }
        }).fail(function(error) {
            console.error(`Failed to load component: ${componentPath}`, error);
        });
    }

    /**
     * Checks if current page is inside the pages directory
     * @returns {boolean}
     */
    function isInPagesDirectory() {
        return window.location.pathname.includes('/pages/');
    }

    /**
     * Fixes paths in a component for pages in the pages directory
     * @param {HTMLElement} container - The component container
     */
    function fixPathsForComponent(container) {
        // Fix image paths
        container.querySelectorAll('img[src]').forEach(img => {
            const src = img.getAttribute('src');
            if (src.startsWith('../../')) {
                // Already configured for pages directory
                return;
            }
            if (src.startsWith('/assets/')) {
                img.setAttribute('src', '..' + src);
            } else if (src.startsWith('assets/')) {
                img.setAttribute('src', '../' + src);
            }
        });

        // Fix link paths
        container.querySelectorAll('a[href]').forEach(link => {
            const href = link.getAttribute('href');
            if (href.startsWith('/pages/')) {
                link.setAttribute('href', '.' + href.substring('/pages'.length));
            } else if (href === '/' || href === 'index.html' || href === '/index.html') {
                link.setAttribute('href', '../index.html');
            }
        });
    }

    /**
     * Highlights the active navigation item based on current page
     */
    function highlightActiveNavItem() {
        const currentPath = window.location.pathname;
        
        // Default to home
        let activeNavId = 'nav-home';
        
        // Check current page and set the appropriate nav item as active
        if (currentPath.includes('events.html')) {
            activeNavId = 'nav-events';
        } else if (currentPath.includes('services.html')) {
            activeNavId = 'nav-services';
        } else if (currentPath.includes('about.html')) {
            activeNavId = 'nav-about';
        } else if (currentPath.includes('gallery.html')) {
            activeNavId = 'nav-gallery';
        } else if (currentPath.includes('cameraman.html')) {
            activeNavId = 'nav-cameraman';
        } else if (currentPath.includes('hotels.html')) {
            activeNavId = 'nav-hotels';
        } else if (currentPath.includes('destinations.html')) {
            activeNavId = 'nav-destinations';
        } else if (currentPath.includes('contact.html')) {
            activeNavId = 'nav-contact';
        }
        
        // Remove active class from all nav items
        document.querySelectorAll('.nav-link').forEach(item => {
            item.classList.remove('active');
        });
        
        // Add active class to the current page's nav item
        const activeNavItem = document.getElementById(activeNavId);
        if (activeNavItem) {
            activeNavItem.classList.add('active');
        }
    }
}); 