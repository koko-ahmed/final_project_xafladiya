// Features Section functionality
document.addEventListener('DOMContentLoaded', function() {
  // Initialize AOS animations for features section
  AOS.init({
    duration: 1000,
    once: true,
    offset: 100
  });

  // Add hover effects to feature cards
  const featureCards = document.querySelectorAll('.feature-card');
  featureCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-10px)';
      this.style.boxShadow = '0 15px 30px rgba(0, 0, 0, 0.1)';
    });

    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
      this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.05)';
    });
  });

  // Add click event for feature links
  const featureLinks = document.querySelectorAll('.feature-card .btn');
  featureLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      // Add smooth transition before navigation
      e.preventDefault();
      const href = this.getAttribute('href');
      setTimeout(() => {
        window.location.href = href;
      }, 300);
    });
  });
}); 