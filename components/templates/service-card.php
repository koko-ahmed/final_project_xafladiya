<?php
// Service Card Template
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';

// Function to generate service card
function generateServiceCard($icon, $title, $title_key, $description, $description_key, $modal_id) {
    ?>
    <div class="card service-card h-100">
        <div class="service-icon">
            <i class="fas <?php echo $icon; ?> fa-2x"></i>
        </div>
        <h3 class="card-title" data-i18n="<?php echo $title_key; ?>"><?php echo $title; ?></h3>
        <p class="card-text" data-i18n="<?php echo $description_key; ?>"><?php echo $description; ?></p>
        <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#<?php echo $modal_id; ?>" data-i18n="learn_more">Learn More</button>
    </div>
    <?php
}
?>

<!-- Custom CSS -->
<style>
.service-card {
    padding: 2rem;
    text-align: center;
    border: none;
    border-radius: 15px;
    background: white;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
}

.service-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.service-card:hover::before {
    transform: scaleX(1);
}

.service-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-gradient);
    border-radius: 50%;
    color: white;
    transition: transform 0.3s ease;
}

.service-card:hover .service-icon {
    transform: scale(1.1);
}

.card-title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: #333;
}

.card-text {
    color: #666;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
    line-height: 1.6;
}

.btn-outline-primary {
    border-width: 2px;
    font-weight: 500;
    padding: 0.5rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

/* Dark Mode Styles */
body.dark-mode .service-card {
    background: #1a1a1a;
}

body.dark-mode .card-title {
    color: #ffffff;
}

body.dark-mode .card-text {
    color: #999;
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.service-card {
    animation: fadeInUp 0.6s ease forwards;
}
</style> 