// Navbar component JavaScript
document.addEventListener('DOMContentLoaded', function () {
    // Active link highlighting
    const currentPath = window.location.pathname;

    // Set active state based on current page
    let activeSet = false;

    // Mark active link based on current page
    if (currentPath.endsWith('index.html') || currentPath === '/' || currentPath.endsWith('/')) {
        document.getElementById('nav-home')?.classList.add('active');
        activeSet = true;
    } else if (currentPath.includes('events.html')) {
        document.getElementById('nav-events')?.classList.add('active');
        activeSet = true;
    } else if (currentPath.includes('services.html')) {
        document.getElementById('nav-services')?.classList.add('active');
        activeSet = true;
    } else if (currentPath.includes('about.html')) {
        document.getElementById('nav-about')?.classList.add('active');
        activeSet = true;
    } else if (currentPath.includes('gallery.html')) {
        document.getElementById('nav-gallery')?.classList.add('active');
        activeSet = true;
    } else if (currentPath.includes('cameraman.html')) {
        document.getElementById('nav-cameraman')?.classList.add('active');
        activeSet = true;
    } else if (currentPath.includes('contact.html')) {
        document.getElementById('nav-contact')?.classList.add('active');
        activeSet = true;
    }

    // Fallback to match by path component
    if (!activeSet) {
        document.querySelectorAll('.nav-link').forEach(link => {
            const href = link.getAttribute('href');
            const pageName = href.split('/').pop(); // Get the filename.html part

            if (currentPath.includes(pageName) && pageName !== 'index.html') {
                link.classList.add('active');
            }
        });
    }
}); 