// Testimonials Section functionality
document.addEventListener('DOMContentLoaded', function() {
  // Initialize AOS animations for testimonials section
  AOS.init({
    duration: 1000,
    once: true,
    offset: 100
  });

  // Add hover effect to testimonial cards
  const testimonialCards = document.querySelectorAll('.testimonial-card');
  testimonialCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-5px)';
      this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.15)';
    });
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
      this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
    });
  });

  // Add animation to star ratings
  const starRatings = document.querySelectorAll('.testimonial-rating');
  starRatings.forEach(rating => {
    const stars = rating.querySelectorAll('i');
    stars.forEach((star, index) => {
      star.style.animationDelay = `${index * 0.1}s`;
      star.classList.add('animate__animated', 'animate__fadeIn');
    });
  });
}); 