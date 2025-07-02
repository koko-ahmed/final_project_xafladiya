// Hotels Section functionality
document.addEventListener('DOMContentLoaded', function() {
  // Initialize date fields immediately for quick search
  initializeQuickSearchDates();

  // Initialize AOS animations for hotels section
  AOS.init({
    duration: 1000,
    once: true,
    offset: 100
  });

  // Add hover effect to hotel cards
  const hotelCards = document.querySelectorAll('.hotel-card');
  hotelCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-8px)';
      this.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.15)';
    });
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
      this.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.08)';
    });
  });

  // Add click event to hotel cards
  hotelCards.forEach(card => {
    card.addEventListener('click', function() {
      const link = this.querySelector('a');
      if (link) {
        link.click();
      }
    });
  });

  // Quick Filter functionality
  const filterButtons = document.querySelectorAll('.btn-filter');
  filterButtons.forEach(button => {
    button.addEventListener('click', function() {
      // Remove active class from all buttons
      filterButtons.forEach(btn => btn.classList.remove('active'));
      
      // Add active class to clicked button
      this.classList.add('active');
      
      const filter = this.getAttribute('data-filter');
      filterHotels(filter);
    });
  });
  
  // Function to filter hotels
  function filterHotels(filter) {
    const hotels = document.querySelectorAll('#hotel-listings > div');
    
    // Tag all hotels with appropriate data attributes for filtering
    tagHotelsForFiltering();
    
    hotels.forEach(hotel => {
      // Default - hide all hotels first
      hotel.style.display = 'none';
      
      if (filter === 'all') {
        // Show hotels on current page
        if (hotel.getAttribute('data-page') === currentPage.toString()) {
          hotel.style.display = 'block';
        }
      } else if (filter === 'luxury') {
        // Check if hotel has 5 stars
        if (hotel.querySelector('.hotel-rating i:nth-child(5).fas') || 
            hotel.querySelector('.card-badges .badge').textContent.includes('5★')) {
          hotel.style.display = 'block';
        }
      } else if (filter === 'pool') {
        // Check if hotel has pool amenity
        if (hotel.querySelector('.hotel-features .badge i.fa-swimming-pool')) {
          hotel.style.display = 'block';
        }
      } else {
        // Check city match
        const locationText = hotel.querySelector('.hotel-location').textContent.toLowerCase();
        if (locationText.includes(filter.toLowerCase())) {
          hotel.style.display = 'block';
        }
      }
    });
    
    // Show no results message if needed
    const visibleHotels = document.querySelectorAll('#hotel-listings > div[style="display: block"]');
    if (visibleHotels.length === 0) {
      showAlert('info', 'No hotels found matching your filter criteria.');
    }
    
    // Reset pagination when filtering
    resetPagination();
  }
  
  // Function to tag hotels with data attributes based on their content
  function tagHotelsForFiltering() {
    const hotels = document.querySelectorAll('#hotel-listings > div');
    
    hotels.forEach(hotel => {
      // Get location text
      const locationText = hotel.querySelector('.hotel-location').textContent.toLowerCase();
      
      // Set city attribute
      if (locationText.includes('garowe')) {
        hotel.setAttribute('data-city', 'garowe');
      } else if (locationText.includes('bosaso')) {
        hotel.setAttribute('data-city', 'bosaso');
      } else if (locationText.includes('galkacyo')) {
        hotel.setAttribute('data-city', 'galkacyo');
      }
      
      // Set amenities attribute
      let amenities = [];
      const amenityBadges = hotel.querySelectorAll('.hotel-features .badge');
      amenityBadges.forEach(badge => {
        const text = badge.textContent.toLowerCase();
        if (text.includes('wifi')) amenities.push('wifi');
        if (text.includes('pool')) amenities.push('pool');
        if (text.includes('restaurant')) amenities.push('restaurant');
        if (text.includes('conference')) amenities.push('conference');
        if (text.includes('breakfast')) amenities.push('breakfast');
      });
      
      hotel.setAttribute('data-amenities', amenities.join(','));
    });
  }

  // Back to top button functionality
  const backToTopBtn = document.getElementById('backToTop');
  
  if (backToTopBtn) {
    window.addEventListener('scroll', function() {
      if (window.pageYOffset > 300) {
        backToTopBtn.classList.add('visible');
      } else {
        backToTopBtn.classList.remove('visible');
      }
    });
    
    backToTopBtn.addEventListener('click', function() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
  
  // Quick search functionality
  const searchForm = document.getElementById('hotel-quick-search');
  
  if (searchForm) {
    const searchInput = searchForm.querySelector('.search-input');
    
    searchForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const searchTerm = searchInput.value.toLowerCase().trim();
      
      if (searchTerm.length > 0) {
        searchHotels(searchTerm);
      } else {
        // If search is empty, show all hotels on current page
        filterButtons.forEach(btn => btn.classList.remove('active'));
        document.querySelector('.btn-filter[data-filter="all"]').classList.add('active');
        resetToAllHotels();
      }
    });
  }
  
  function searchHotels(term) {
    const hotels = document.querySelectorAll('#hotel-listings > div');
    
    // Hide all hotels first
    hotels.forEach(hotel => {
      hotel.style.display = 'none';
    });
    
    // Show hotels that match the search term
    hotels.forEach(hotel => {
      const hotelName = hotel.querySelector('.card-title').textContent.toLowerCase();
      const hotelLocation = hotel.querySelector('.hotel-location').textContent.toLowerCase();
      const hotelDesc = hotel.querySelector('.card-text').textContent.toLowerCase();
      const hotelFeatures = Array.from(hotel.querySelectorAll('.hotel-features .badge'))
        .map(badge => badge.textContent.toLowerCase())
        .join(' ');
      
      if (hotelName.includes(term) || 
          hotelLocation.includes(term) || 
          hotelDesc.includes(term) ||
          hotelFeatures.includes(term)) {
        hotel.style.display = 'block';
      }
    });
    
    // Show "no results" message if needed
    const visibleHotels = document.querySelectorAll('#hotel-listings > div[style="display: block"]');
    if (visibleHotels.length === 0) {
      showAlert('info', 'No hotels found matching your search criteria. Please try a different search term.');
    } else {
      // Reset any existing alerts
      const alertContainer = document.getElementById('hotels-alert-container');
      if (alertContainer) {
        alertContainer.innerHTML = '';
      }
    }
    
    // Reset pagination when searching
    resetPagination();
  }
  
  function resetToAllHotels() {
    const hotels = document.querySelectorAll('#hotel-listings > div');
    
    // Hide all hotels first
    hotels.forEach(hotel => {
      hotel.style.display = 'none';
    });
    
    // Show hotels for current page
    hotels.forEach(hotel => {
      if (hotel.getAttribute('data-page') === currentPage.toString()) {
        hotel.style.display = 'block';
      }
    });
    
    // Reset pagination
    resetPagination();
  }
  
  function resetPagination() {
    // Ensure pagination buttons are properly set
    updatePagination(currentPage);
    
    // Clear any alerts
    const alertContainer = document.getElementById('hotels-alert-container');
    if (alertContainer && !alertContainer.querySelector('.alert-info')) {
      alertContainer.innerHTML = '';
    }
  }

  // Image hover effect
  const hotelImages = document.querySelectorAll('.hotel-card .card-img-top');
  hotelImages.forEach(img => {
    img.addEventListener('mouseenter', function() {
      this.style.transform = 'scale(1.1)';
    });
    img.addEventListener('mouseleave', function() {
      this.style.transform = 'scale(1)';
    });
  });
  
  // Track current page for pagination
  let currentPage = 1;
  const totalPages = 2; // Update this if more pages are added
  
  // Initialize pagination functionality
  initializePagination();
  
  function initializePagination() {
    const paginationItems = document.querySelectorAll('.pagination li[data-page]');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    
    if (paginationItems.length) {
      paginationItems.forEach(item => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          const pageNum = parseInt(this.getAttribute('data-page'));
          goToPage(pageNum);
        });
      });
    }
    
    if (prevPageBtn) {
      prevPageBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (currentPage > 1) {
          goToPage(currentPage - 1);
        }
      });
    }
    
    if (nextPageBtn) {
      nextPageBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (currentPage < totalPages) {
          goToPage(currentPage + 1);
        }
      });
    }
    
    // Initialize to page 1
    goToPage(1);
  }
  
  function goToPage(pageNumber) {
    const hotels = document.querySelectorAll('#hotel-listings > div');
    
    // Hide all hotels
    hotels.forEach(hotel => {
      hotel.style.display = 'none';
    });
    
    // Show only hotels for the current page
    hotels.forEach(hotel => {
      if (hotel.getAttribute('data-page') === pageNumber.toString()) {
        hotel.style.display = 'block';
      }
    });
    
    // Update pagination UI
    updatePagination(pageNumber);
    
    // Update current page
    currentPage = pageNumber;
    
    // Smooth scroll to top of hotel listings
    const hotelListings = document.getElementById('hotel-listings');
    if (hotelListings) {
      window.scrollTo({
        top: hotelListings.offsetTop - 100,
        behavior: 'smooth'
      });
    }
    
    // Refresh AOS animations
    AOS.refresh();
  }
  
  function updatePagination(pageNumber) {
    const paginationItems = document.querySelectorAll('.pagination li[data-page]');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    
    // Update active page
    paginationItems.forEach(item => {
      if (parseInt(item.getAttribute('data-page')) === pageNumber) {
        item.classList.add('active');
      } else {
        item.classList.remove('active');
      }
    });
    
    // Enable/disable prev/next buttons
    if (prevPageBtn) {
      if (pageNumber === 1) {
        prevPageBtn.classList.add('disabled');
      } else {
        prevPageBtn.classList.remove('disabled');
      }
    }
    
    if (nextPageBtn) {
      if (pageNumber === totalPages) {
        nextPageBtn.classList.add('disabled');
      } else {
        nextPageBtn.classList.remove('disabled');
      }
    }
  }
  
  // Function to show alerts
  function showAlert(type, message) {
    // Create alert container if it doesn't exist
    let alertContainer = document.getElementById('hotels-alert-container');
    if (!alertContainer) {
      alertContainer = document.createElement('div');
      alertContainer.id = 'hotels-alert-container';
      alertContainer.className = 'mt-3 mb-3';
      
      // Insert before hotel listings
      const hotelListings = document.getElementById('hotel-listings');
      if (hotelListings && hotelListings.parentNode) {
        hotelListings.parentNode.insertBefore(alertContainer, hotelListings);
      }
    }
    
    // Create the alert
    const alertEl = document.createElement('div');
    alertEl.className = `alert alert-${type} alert-dismissible fade show`;
    alertEl.role = 'alert';
    alertEl.innerHTML = `
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    // Add to container
    alertContainer.innerHTML = '';
    alertContainer.appendChild(alertEl);
    
    // Auto-dismiss after 5 seconds
    setTimeout(function() {
      alertEl.classList.remove('show');
      setTimeout(() => alertEl.remove(), 150);
    }, 5000);
  }
  
  // Make functions globally available
  window.showAlert = showAlert;
  window.filterHotels = filterHotels;
  window.searchHotels = searchHotels;
  window.goToPage = goToPage;
  window.currentPage = currentPage;

  // Run this on initial load to tag hotels with data attributes
  tagHotelsForFiltering();

  // Handle Book Now button in carousel to set hotel name in modal
  const bookNowBtns = document.querySelectorAll('.book-now-btn');
  const selectedHotelNameSpan = document.getElementById('selectedHotelName');
  const hotelNameInput = document.getElementById('hotelNameInput');

  bookNowBtns.forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const hotelName = this.getAttribute('data-hotel-name') || '';
      if (selectedHotelNameSpan) selectedHotelNameSpan.textContent = hotelName;
      if (hotelNameInput) hotelNameInput.value = hotelName;
      // Open the modal using Bootstrap 5 vanilla JS
      var modal = new bootstrap.Modal(document.getElementById('hotelModal'));
      modal.show();
    });
  });
});

// Hotels Component JavaScript
$(document).ready(function() {
  // Initialize date pickers with default values
  const today = new Date();
  const tomorrow = new Date(today);
  tomorrow.setDate(tomorrow.getDate() + 1);
  
  // Format dates for input elements
  const formatDate = (date) => {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  };
  
  // Set default dates for booking modal
  $('#hotelModal').on('show.bs.modal', function() {
    $('#booking-check-in').val(formatDate(today));
    $('#booking-check-out').val(formatDate(tomorrow));
  });
  
  // Handle hotel booking form submission
  $('#hotel-booking-form').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = form.serialize();
    var submitBtn = form.find('button[type="submit"]');
    var originalText = submitBtn.html();
    submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Processing...');

    // Debug: log form data
    console.log('Submitting booking form data:', formData);

    $.ajax({
      url: 'pages/process_venue_booking.php',
      method: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response) {
        // Debug: log server response
        console.log('Server response:', response);
        if (response.status === 'success') {
          // Refresh the cart modal contents
          $('#cart-modal-body').load('includes/fetch_cart.php');
          // Hide any lingering alerts or toasts
          $('.alert, .notification-toast').remove();
          if (window.showAlert) {
            window.showAlert('success', 'Your booking request has been received and added to your cart. We will contact you shortly to confirm your reservation.');
          }
          $('#hotelModal').modal('hide');
          form[0].reset();
        } else {
          if (window.showAlert) {
            window.showAlert('danger', response.message || 'Booking failed. Please try again.');
          }
          // Debug: show alert if not success
          alert('Booking failed: ' + (response.message || 'Unknown error'));
        }
      },
      error: function(xhr, status, error) {
        if (window.showAlert) {
          window.showAlert('danger', 'An error occurred. Please try again.');
        }
        // Debug: log AJAX error
        console.error('AJAX error:', status, error);
        alert('AJAX error: ' + error);
      },
      complete: function() {
        submitBtn.prop('disabled', false).html(originalText);
      }
    });
  });
  
  // Featured hotels carousel enhancements
  $('.carousel').carousel({
    interval: 5000
  });
  
  // Handle quick filter button clicks from jQuery
  $('.btn-filter').on('click', function() {
    $('.btn-filter').removeClass('active');
    $(this).addClass('active');
    const filter = $(this).data('filter');
    
    if (window.filterHotels) {
      window.filterHotels(filter);
    }
  });
  
  // Handle search form submission from jQuery
  $('#hotel-quick-search').on('submit', function(e) {
    e.preventDefault();
    const searchTerm = $('.search-input').val().toLowerCase().trim();
    
    if (searchTerm.length > 0 && window.searchHotels) {
      window.searchHotels(searchTerm);
    }
  });
});

// Set default dates for quick search
function initializeQuickSearchDates() {
  const today = new Date();
  const tomorrow = new Date(today);
  tomorrow.setDate(tomorrow.getDate() + 1);
  
  // Format dates for input elements
  const formatDate = (date) => {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  };
  
  // Set default dates for quick search
  const quickCheckIn = document.getElementById('quick-check-in');
  const quickCheckOut = document.getElementById('quick-check-out');
  
  if (quickCheckIn && quickCheckOut) {
    quickCheckIn.value = formatDate(today);
    quickCheckOut.value = formatDate(tomorrow);
  }
} 