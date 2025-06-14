<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

?>
<style>
.photographers-heading {
    margin-top: 4rem; /* Adjust this value as needed */
    margin-bottom: 2rem; /* Keep original mb-5 but maybe adjust */
}
</style>

<?php
// Fetch photographers from the database
$photographers = [];
$query = "SELECT id, name, specialty, contact_email, contact_phone, bio, image, location, years_experience, rating FROM photographers ORDER BY name";
$result = mysqli_query($db, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $photographers[] = $row;
    }
    mysqli_free_result($result);
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-5 photographers-heading">Our Professional Photographers</h1>

    <?php if (empty($photographers)): ?>
        <p class="text-center">No photographers available at the moment.</p>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($photographers as $photographer): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($photographer['image'])): ?>
                            <img src="<?php echo get_url($photographer['image']); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($photographer['name']); ?>" 
                                 style="height: 300px; object-fit: cover;">
                        <?php else: ?>
                            <img src="<?php echo get_url('assets/images/placeholder.jpg'); ?>" 
                                 class="card-img-top" 
                                 alt="No Image Available" 
                                 style="height: 300px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($photographer['name']); ?></h5>
                            <p class="card-text mb-2"><strong>Specialty:</strong> <?php echo htmlspecialchars($photographer['specialty']); ?></p>
                            <?php if (!empty($photographer['location'])): ?>
                                <p class="card-text mb-2"><i class="fas fa-map-marker-alt me-1"></i> <?php echo htmlspecialchars($photographer['location']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($photographer['years_experience']) && $photographer['years_experience'] > 0): ?>
                                <p class="card-text mb-2"><i class="fas fa-clock me-1"></i> <?php echo htmlspecialchars($photographer['years_experience']); ?> years experience</p>
                            <?php endif; ?>
                            <?php if (!empty($photographer['rating'])): ?>
                                <div class="card-text mb-2">
                                    <?php
                                    $rating = $photographer['rating'];
                                    $full_stars = floor($rating);
                                    $half_star = ceil($rating - $full_stars);
                                    $empty_stars = 5 - $full_stars - $half_star;

                                    for ($i = 0; $i < $full_stars; $i++) {
                                        echo '<i class="fas fa-star text-warning"></i>';
                                    }
                                    for ($i = 0; $i < $half_star; $i++) {
                                        echo '<i class="fas fa-star-half-alt text-warning"></i>';
                                    }
                                    for ($i = 0; $i < $empty_stars; $i++) {
                                        echo '<i class="far fa-star text-warning"></i>';
                                    }
                                    ?>
                                    (<?php echo htmlspecialchars(number_format($rating, 1)); ?>/5)
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($photographer['bio'])): ?>
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($photographer['bio'])); ?></p>
                            <?php endif; ?>
                            <div class="mt-3">
                                <a href="mailto:<?php echo htmlspecialchars($photographer['contact_email']); ?>" 
                                   class="btn btn-primary">Contact Photographer</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?> 