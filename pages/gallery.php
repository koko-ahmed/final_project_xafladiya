<?php
$page_title = 'Xafladiya - Gallery';
include '../includes/header.php';
?>

<!-- Gallery Hero Section -->
<section class="gallery-hero-section py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h1 class="display-4 fw-bold mb-3">Our Gallery</h1>
      <p class="lead mb-4">
        A collection of beautiful moments from our events across Somalia
      </p>
      <div class="gallery-filters mb-4">
        <button class="btn btn-outline-primary active me-2 mb-2" data-filter="all">
          All
        </button>
        <button class="btn btn-outline-primary me-2 mb-2" data-filter="wedding">
          Weddings
        </button>
        <button class="btn btn-outline-primary me-2 mb-2" data-filter="corporate">
          Corporate
        </button>
        <button class="btn btn-outline-primary me-2 mb-2" data-filter="cultural">
          Cultural
        </button>
        <button class="btn btn-outline-primary me-2 mb-2" data-filter="graduation">
          Graduation
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Gallery Section -->
<section class="gallery-section py-5">
  <div class="container">
    <div class="row g-4 gallery-container">
      <!-- Wedding Images -->
      <div class="col-lg-4 col-md-6 gallery-item" data-category="wedding">
        <a href="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" data-lightbox="gallery" data-title="Elegant Wedding Ceremony in Garowe">
          <div class="gallery-image">
            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Wedding Ceremony" class="img-fluid rounded" />
            <div class="gallery-overlay">
              <div class="gallery-info">
                <h5>Elegant Wedding</h5>
                <p>Garowe, 2024</p>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-4 col-md-6 gallery-item" data-category="wedding">
        <a href="https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" data-lightbox="gallery" data-title="Beach Wedding in Bosaso">
          <div class="gallery-image">
            <img src="https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Beach Wedding" class="img-fluid rounded" />
            <div class="gallery-overlay">
              <div class="gallery-info">
                <h5>Beach Wedding</h5>
                <p>Bosaso, 2024</p>
              </div>
            </div>
          </div>
        </a>
      </div>

      <!-- Corporate Images -->
      <div class="col-lg-4 col-md-6 gallery-item" data-category="corporate">
        <a href="https://images.unsplash.com/photo-1540317580384-e5d43867caa6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" data-lightbox="gallery" data-title="Annual Business Conference in Mogadishu">
          <div class="gallery-image">
            <img src="https://images.unsplash.com/photo-1540317580384-e5d43867caa6?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Business Conference" class="img-fluid rounded" />
            <div class="gallery-overlay">
              <div class="gallery-info">
                <h5>Business Conference</h5>
                <p>Mogadishu, 2024</p>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-4 col-md-6 gallery-item" data-category="corporate">
        <a href="https://images.unsplash.com/photo-1558403194-611308249627?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" data-lightbox="gallery" data-title="Tech Startup Launch Event">
          <div class="gallery-image">
            <img src="https://images.unsplash.com/photo-1558403194-611308249627?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Tech Startup Launch" class="img-fluid rounded" />
            <div class="gallery-overlay">
              <div class="gallery-info">
                <h5>Tech Startup Launch</h5>
                <p>Garowe, 2023</p>
              </div>
            </div>
          </div>
        </a>
      </div>

      <!-- Cultural Images -->
      <div class="col-lg-4 col-md-6 gallery-item" data-category="cultural">
        <a href="https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" data-lightbox="gallery" data-title="Somali Cultural Festival">
          <div class="gallery-image">
            <img src="https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Cultural Festival" class="img-fluid rounded" />
            <div class="gallery-overlay">
              <div class="gallery-info">
                <h5>Cultural Festival</h5>
                <p>Galkacyo, 2024</p>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-4 col-md-6 gallery-item" data-category="cultural">
        <a href="https://images.unsplash.com/photo-1528605248644-14dd04022da1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" data-lightbox="gallery" data-title="Traditional Dance Performance">
          <div class="gallery-image">
            <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Traditional Dance" class="img-fluid rounded" />
            <div class="gallery-overlay">
              <div class="gallery-info">
                <h5>Traditional Dance</h5>
                <p>Bosaso, 2023</p>
              </div>
            </div>
          </div>
        </a>
      </div>

      <!-- Graduation Images -->
      <div class="col-lg-4 col-md-6 gallery-item" data-category="graduation">
        <a href="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" data-lightbox="gallery" data-title="University Graduation Ceremony">
          <div class="gallery-image">
            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Graduation Ceremony" class="img-fluid rounded" />
            <div class="gallery-overlay">
              <div class="gallery-info">
                <h5>Graduation Ceremony</h5>
                <p>Mogadishu, 2024</p>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>

<!-- Lightbox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<!-- Custom JS -->
<script>
$(document).ready(function() {
  // Gallery filter functionality
  $('.gallery-filters button').click(function() {
    $('.gallery-filters button').removeClass('active');
    $(this).addClass('active');
    
    var filter = $(this).data('filter');
    
    if (filter === 'all') {
      $('.gallery-item').show();
    } else {
      $('.gallery-item').hide();
      $('.gallery-item[data-category="' + filter + '"]').show();
    }
  });

  // Initialize lightbox
  lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true,
    'albumLabel': 'Image %1 of %2'
  });
});
</script> 