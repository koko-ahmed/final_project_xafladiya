<?php
// Service Modal Template
// Get the base path for assets based on whether we're in the home page or not
$base_path = isset($is_home) && $is_home ? '' : '../../';

// Function to generate service modal
function generateServiceModal($modal_id, $title, $title_key, $heading, $heading_key, $description, $description_key, $features_heading_key, $features, $image_src) {
    global $base_path;
    ?>
    <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1" aria-labelledby="<?php echo $modal_id; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="<?php echo $modal_id; ?>Label" data-i18n="<?php echo $title_key; ?>"><?php echo $title; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <img src="<?php echo $base_path . $image_src; ?>" alt="<?php echo $title; ?>" class="img-fluid rounded">
                        </div>
                        <div class="col-md-6">
                            <h4 data-i18n="<?php echo $heading_key; ?>"><?php echo $heading; ?></h4>
                            <p data-i18n="<?php echo $description_key; ?>"><?php echo $description; ?></p>
                            <h5 data-i18n="<?php echo $features_heading_key; ?>">Features:</h5>
                            <ul>
                                <?php foreach ($features as $feature): ?>
                                    <li data-i18n="<?php echo $feature['key']; ?>"><?php echo $feature['text']; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-i18n="close">Close</button>
                    <a href="<?php echo $base_path; ?>pages/contact.php" class="btn btn-primary" data-i18n="inquire_now">Inquire Now</a>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<!-- Custom CSS -->
<style>
.modal-content {
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.modal-header {
    background: var(--primary-gradient);
    color: white;
    border: none;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.modal-body {
    padding: 2rem;
}

.modal-body img {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.modal-body img:hover {
    transform: scale(1.02);
}

.modal-body h4 {
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.modal-body ul {
    list-style: none;
    padding-left: 0;
}

.modal-body ul li {
    margin-bottom: 0.5rem;
    padding-left: 1.5rem;
    position: relative;
}

.modal-body ul li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--primary-color);
}

.modal-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    padding: 1rem 2rem;
}

/* Dark Mode Styles */
body.dark-mode .modal-content {
    background-color: #1a1a1a;
    color: #ffffff;
}

body.dark-mode .modal-body h4 {
    color: var(--primary-color);
}

body.dark-mode .modal-body ul li::before {
    color: var(--primary-color);
}

body.dark-mode .modal-footer {
    border-top-color: rgba(255, 255, 255, 0.1);
}
</style> 