// Parallax Section functionality
document.addEventListener('DOMContentLoaded', function() {
  // Initialize AOS animations for parallax section
  AOS.init({
    duration: 1000,
    once: true
  });

  // Parallax effect
  window.addEventListener('scroll', function() {
    const parallaxSection = document.querySelector('.parallax-section');
    if (parallaxSection) {
      const scrolled = window.pageYOffset;
      parallaxSection.style.backgroundPositionY = scrolled * 0.5 + 'px';
    }
  });

  // Add hover effect to button
  const parallaxButton = document.querySelector('.parallax-content .btn-primary');
  if (parallaxButton) {
    parallaxButton.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-2px)';
      this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.3)';
    });
    parallaxButton.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
      this.style.boxShadow = 'none';
    });
  }
}); 