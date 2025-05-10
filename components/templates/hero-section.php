<?php
// Hero Section Template
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';

// Function to generate hero section
function generateHeroSection($title, $title_key, $subtitle, $subtitle_key, $buttons) {
    ?>
    <section class="modern-hero">
        <div class="container text-center position-relative" style="z-index: 1;">
            <h1 class="modern-title display-4 mb-4" data-i18n="<?php echo $title_key; ?>"><?php echo $title; ?></h1>
            <div class="modern-divider modern-divider-center"></div>
            <p class="modern-text lead mb-5" data-i18n="<?php echo $subtitle_key; ?>"><?php echo $subtitle; ?></p>
            <div class="d-flex justify-content-center gap-3">
                <?php echo $buttons; ?>
            </div>
        </div>
    </section>
    <?php
}
?>

<!-- Custom CSS -->
<style>
.modern-hero {
    position: relative;
    padding: 6rem 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    overflow: hidden;
}

.modern-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('<?php echo $base_path; ?>assets/images/hero-bg.jpg') center/cover no-repeat;
    opacity: 0.1;
    z-index: 0;
}

.modern-title {
    font-weight: 700;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1.5rem;
}

.modern-divider {
    width: 80px;
    height: 4px;
    background: var(--primary-gradient);
    margin: 0 auto 2rem;
    position: relative;
}

.modern-divider::before,
.modern-divider::after {
    content: '';
    position: absolute;
    width: 40px;
    height: 2px;
    background: var(--primary-gradient);
    top: 50%;
    transform: translateY(-50%);
}

.modern-divider::before {
    left: -50px;
}

.modern-divider::after {
    right: -50px;
}

.modern-text {
    color: #666;
    max-width: 600px;
    margin: 0 auto;
}

/* Dark Mode Styles */
body.dark-mode .modern-hero {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.2) 0%, rgba(0, 0, 0, 0.1) 100%);
}

body.dark-mode .modern-text {
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

.modern-title,
.modern-divider,
.modern-text {
    animation: fadeInUp 0.6s ease forwards;
}

.modern-divider {
    animation-delay: 0.2s;
}

.modern-text {
    animation-delay: 0.4s;
}
</style> 