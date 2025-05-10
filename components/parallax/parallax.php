<?php
// Parallax Component
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';
?>

<link rel="stylesheet" href="<?php echo $base_path; ?>components/parallax/css/parallax.css" />

<section
  class="parallax-section"
  style="
    background-image: url('https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
  "
>
  <div class="parallax-overlay"></div>
  <div class="container">
    <div class="parallax-content text-center" data-aos="zoom-in">
      <h2 class="display-4 mb-4">Create Unforgettable Memories</h2>
      <p class="lead mb-5">
        Let us handle the details while you focus on enjoying your special
        moments
      </p>
      <a href="<?php echo $base_path; ?>pages/contact.php" class="btn btn-primary btn-lg">Contact Us Today</a>
    </div>
  </div>
</section>

<script src="<?php echo $base_path; ?>components/parallax/js/parallax.js"></script> 