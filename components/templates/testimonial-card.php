<?php
// Testimonial Card Template
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';

// Function to generate testimonial card
function generateTestimonialCard($avatar_src, $name, $name_key, $info, $info_key, $stars, $testimonial, $testimonial_key) {
    global $base_path;
    ?>
    <div class="card testimonial-card h-100 border-0 shadow-sm w-100">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <div class="testimonial-avatar me-3">
                    <img src="<?php echo $base_path . $avatar_src; ?>" alt="<?php echo $name; ?>" class="rounded-circle">
                </div>
                <div>
                    <h5 class="mb-0" data-i18n="<?php echo $name_key; ?>"><?php echo $name; ?></h5>
                    <p class="text-muted small mb-0" data-i18n="<?php echo $info_key; ?>"><?php echo $info; ?></p>
                </div>
            </div>
            <div class="rating mb-2">
                <?php echo $stars; ?>
            </div>
            <p class="testimonial-text" data-i18n="<?php echo $testimonial_key; ?>"><?php echo $testimonial; ?></p>
        </div>
    </div>
    <?php
}

// Function to generate star rating
function generateStarRating($rating) {
    $stars = '';
    $full_stars = floor($rating);
    $half_star = $rating - $full_stars >= 0.5;
    
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $full_stars) {
            $stars .= '<i class="fas fa-star text-warning"></i>';
        } elseif ($i == $full_stars + 1 && $half_star) {
            $stars .= '<i class="fas fa-star-half-alt text-warning"></i>';
        } else {
            $stars .= '<i class="far fa-star text-warning"></i>';
        }
    }
    
    return $stars;
}
?>

<!-- Custom CSS -->
<style>
.testimonial-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background: white;
}

.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

.testimonial-avatar {
    width: 60px;
    height: 60px;
    overflow: hidden;
    border: 3px solid var(--primary-color);
    border-radius: 50%;
}

.testimonial-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.testimonial-text {
    font-size: 0.95rem;
    line-height: 1.6;
    color: #666;
    position: relative;
    padding-left: 1.5rem;
}

.testimonial-text::before {
    content: '"';
    position: absolute;
    left: 0;
    top: -10px;
    font-size: 2rem;
    color: var(--primary-color);
    opacity: 0.3;
    font-family: serif;
}

.rating {
    color: #ffc107;
}

/* Dark Mode Styles */
body.dark-mode .testimonial-card {
    background: #1a1a1a;
}

body.dark-mode .testimonial-text {
    color: #999;
}

body.dark-mode .text-muted {
    color: #666 !important;
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.testimonial-card {
    animation: fadeIn 0.6s ease forwards;
}
</style> 