<?php
$page_title = 'Xafladiya - Events';
include '../includes/header.php';
?>

<!-- Events Hero Section -->
<section class="events-hero-section py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h1 class="display-4 fw-bold mb-3">Our Events</h1>
      <p class="lead mb-4">Discover and attend upcoming events or plan your own with our support</p>
      <div class="search-filters mb-4">
        <div class="row justify-content-center">
          <div class="col-md-3 mb-3 mb-md-0">
            <label for="eventTypeFilter" class="form-label text-light">Event Type</label>
            <select class="form-select" id="eventTypeFilter" aria-label="Filter by event type">
              <option selected value="">All Event Types</option>
              <option value="wedding">Wedding</option>
              <option value="graduation">Graduation</option>
              <option value="corporate">Corporate</option>
              <option value="birthday">Birthday</option>
            </select>
          </div>
          <div class="col-md-3 mb-3 mb-md-0">
            <label for="cityFilter" class="form-label text-light">City</label>
            <select class="form-select" id="cityFilter" aria-label="Filter by city">
              <option selected value="">All Cities</option>
              <option value="garowe">Garowe</option>
              <option value="bosaso">Bosaso</option>
              <option value="galkacyo">Galkacyo</option>
              <option value="mogadishu">Mogadishu</option>
            </select>
          </div>
          <div class="col-md-3">
            <label for="dateFilter" class="form-label text-light">Date</label>
            <select class="form-select" id="dateFilter" aria-label="Filter by date">
              <option selected value="">All Dates</option>
              <option value="today">Today</option>
              <option value="week">This Week</option>
              <option value="month">This Month</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured Events Section -->
<section class="featured-events-section py-5">
  <div class="container">
    <div class="section-title text-center mb-5">
      <h2>Featured Events</h2>
      <p>Explore the most popular upcoming events in your area</p>
    </div>
    <div class="row g-4">
      <!-- Event 1 -->
      <div class="col-lg-4 col-md-6" data-event="wedding" data-city="garowe">
        <div class="card event-card h-100">
          <div class="event-image">
            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=70" alt="Annual Business Conference" loading="lazy" width="400" height="250" />
            <div class="event-overlay"></div>
            <div class="event-date">Aug 15</div>
          </div>
          <div class="card-body">
            <h5 class="card-title">Annual Business Conference</h5>
            <p class="card-text mb-3">The largest business networking event in Garowe, featuring keynote speakers from major companies.</p>
            <div class="d-flex justify-content-between align-items-center">
              <span><i class="fas fa-map-marker-alt text-primary me-2"></i>Garowe Business Center</span>
              <span><i class="far fa-clock text-primary me-2"></i>9:00 AM</span>
            </div>
          </div>
          <div class="card-footer bg-transparent border-top-0">
            <button class="btn btn-outline-primary w-100 event-details-btn">More Info</button>
          </div>
        </div>
      </div>

      <!-- Event 2 -->
      <div class="col-lg-4 col-md-6" data-event="wedding" data-city="bosaso">
        <div class="card event-card h-100">
          <div class="event-image">
            <img src="https://images.unsplash.com/photo-1532712938310-34cb3982ef74?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=70" alt="Wedding Expo" loading="lazy" width="400" height="250" />
            <div class="event-overlay"></div>
            <div class="event-date">Sep 5</div>
          </div>
          <div class="card-body">
            <h5 class="card-title">Wedding Expo 2025</h5>
            <p class="card-text mb-3">Discover the latest wedding trends, meet planners, and find everything you need for your perfect day.</p>
            <div class="d-flex justify-content-between align-items-center">
              <span><i class="fas fa-map-marker-alt text-primary me-2"></i>Bosaso Grand Hotel</span>
              <span><i class="far fa-clock text-primary me-2"></i>11:00 AM</span>
            </div>
          </div>
          <div class="card-footer bg-transparent border-top-0">
            <button class="btn btn-outline-primary w-100 event-details-btn">More Info</button>
          </div>
        </div>
      </div>

      <!-- Event 3 -->
      <div class="col-lg-4 col-md-6" data-event="graduation" data-city="garowe">
        <div class="card event-card h-100">
          <div class="event-image">
            <img src="https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=70" alt="University Graduation Ceremony" loading="lazy" width="400" height="250" />
            <div class="event-overlay"></div>
            <div class="event-date">Aug 20</div>
          </div>
          <div class="card-body">
            <h5 class="card-title">University Graduation Ceremony</h5>
            <p class="card-text mb-3">Join the class of 2025 as they celebrate their academic achievements and look toward the future.</p>
            <div class="d-flex justify-content-between align-items-center">
              <span><i class="fas fa-map-marker-alt text-primary me-2"></i>Puntland State University</span>
              <span><i class="far fa-clock text-primary me-2"></i>4:00 PM</span>
            </div>
          </div>
          <div class="card-footer bg-transparent border-top-0">
            <button class="btn btn-outline-primary w-100 event-details-btn">More Info</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Event Details Modal -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 mb-4 mb-md-0">
            <img src="" alt="Event Image" class="img-fluid rounded" id="modalEventImage" />
          </div>
          <div class="col-md-6">
            <h4 id="modalEventTitle"></h4>
            <p id="modalEventDescription"></p>
            <div class="event-details">
              <p><i class="fas fa-map-marker-alt text-primary me-2"></i><span id="modalEventLocation"></span></p>
              <p><i class="far fa-clock text-primary me-2"></i><span id="modalEventTime"></span></p>
              <p><i class="far fa-calendar text-primary me-2"></i><span id="modalEventDate"></span></p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="contact.php" class="btn btn-primary">Book Now</a>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="../assets/js/script.js"></script>
<script>
  // Event filtering functionality
  document.addEventListener('DOMContentLoaded', function() {
    const eventTypeFilter = document.getElementById('eventTypeFilter');
    const cityFilter = document.getElementById('cityFilter');
    const dateFilter = document.getElementById('dateFilter');
    const eventCards = document.querySelectorAll('.event-card');

    function filterEvents() {
      const selectedType = eventTypeFilter.value;
      const selectedCity = cityFilter.value;
      const selectedDate = dateFilter.value;

      eventCards.forEach(card => {
        const eventType = card.closest('[data-event]').dataset.event;
        const eventCity = card.closest('[data-city]').dataset.city;
        const eventDate = card.querySelector('.event-date').textContent;

        const typeMatch = !selectedType || eventType === selectedType;
        const cityMatch = !selectedCity || eventCity === selectedCity;
        const dateMatch = !selectedDate || isDateMatch(eventDate, selectedDate);

        card.closest('.col-lg-4').style.display = typeMatch && cityMatch && dateMatch ? 'block' : 'none';
      });
    }

    function isDateMatch(eventDate, filter) {
      // Add date matching logic here
      return true; // Placeholder
    }

    eventTypeFilter.addEventListener('change', filterEvents);
    cityFilter.addEventListener('change', filterEvents);
    dateFilter.addEventListener('change', filterEvents);

    // Event details modal functionality
    const eventDetailsModal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
    const eventDetailsBtns = document.querySelectorAll('.event-details-btn');

    eventDetailsBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        const card = this.closest('.event-card');
        const title = card.querySelector('.card-title').textContent;
        const description = card.querySelector('.card-text').textContent;
        const location = card.querySelector('.fa-map-marker-alt').nextSibling.textContent;
        const time = card.querySelector('.fa-clock').nextSibling.textContent;
        const date = card.querySelector('.event-date').textContent;
        const image = card.querySelector('img').src;

        document.getElementById('modalEventTitle').textContent = title;
        document.getElementById('modalEventDescription').textContent = description;
        document.getElementById('modalEventLocation').textContent = location;
        document.getElementById('modalEventTime').textContent = time;
        document.getElementById('modalEventDate').textContent = date;
        document.getElementById('modalEventImage').src = image;

        eventDetailsModal.show();
      });
    });
  });
</script>

</body>
</html> 