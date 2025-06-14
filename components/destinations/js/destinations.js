/**
 * Destinations Component JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
  // Add hover effects for destination cards
  const destinationCards = document.querySelectorAll('.destination-card');
  
  destinationCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.querySelector('.destination-img')?.classList.add('hover-effect');
    });
    
    card.addEventListener('mouseleave', function() {
      this.querySelector('.destination-img')?.classList.remove('hover-effect');
    });
  });
  
  // Function to check if element is in viewport for animations
  function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }
  
  // Add entry animations when scrolling
  function handleScrollAnimations() {
    const elements = document.querySelectorAll('.destination-card');
    
    elements.forEach(element => {
      if (isInViewport(element)) {
        element.classList.add('animate__animated', 'animate__fadeIn');
      }
    });
  }
  
  // Initial check for elements in viewport
  handleScrollAnimations();
  
  // Check on scroll
  window.addEventListener('scroll', handleScrollAnimations);
}); 