// Cities Section functionality
document.addEventListener('DOMContentLoaded', function() {
  // Initialize AOS animations for cities section
  AOS.init({
    duration: 1000,
    once: true,
    offset: 100
  });

  // Add hover effect to city cards
  const cityCards = document.querySelectorAll('.modern-card');
  cityCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-5px)';
      this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.15)';
    });
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
      this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
    });
  });

  // Add click event to city cards
  cityCards.forEach(card => {
    card.addEventListener('click', function() {
      const link = this.querySelector('a');
      if (link) {
        link.click();
      }
    });
  });

  // Image hover effect
  const cityImages = document.querySelectorAll('.city-image img');
  cityImages.forEach(img => {
    img.addEventListener('mouseenter', function() {
      this.style.transform = 'scale(1.1)';
    });
    img.addEventListener('mouseleave', function() {
      this.style.transform = 'scale(1)';
    });
  });
}); 