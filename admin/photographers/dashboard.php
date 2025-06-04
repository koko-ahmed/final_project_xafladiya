<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/db.php';

$message = '';
$message_type = '';

// Fetch photographers from the database
$photographers = [];
$query = "SELECT id, name, specialty, contact_email, contact_phone, bio, image FROM photographers ORDER BY name";
$result = mysqli_query($db, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $photographers[] = $row;
    }
    mysqli_free_result($result);
} else {
    $message = 'Error fetching photographers: ' . mysqli_error($db);
    $message_type = 'danger';
}
?>

<div class="container mt-5">
    <h1>Photographer Management</h1>

    <h2>Existing Photographers</h2>

    <a href="<?php echo get_url('admin/photographers/add_photographer.php'); ?>" class="btn btn-primary mb-3">
        <i class="fas fa-plus-circle me-2"></i> Add New Photographer
    </a>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($photographers)): ?>
        <p>No photographers found.</p>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($photographers as $photographer): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <?php if (!empty($photographer['image'])): ?>
                            <img src="<?php echo get_url($photographer['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($photographer['name']); ?>" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <img src="<?php echo get_url('assets/images/placeholder.jpg'); ?>" class="card-img-top" alt="No Image Available" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($photographer['name']); ?></h5>
                            <p class="card-text mb-2"><strong>Specialty:</strong> <?php echo htmlspecialchars($photographer['specialty']); ?></p>
                            <p class="card-text mb-2"><strong>Email:</strong> <?php echo htmlspecialchars($photographer['contact_email']); ?></p>
                            <p class="card-text mb-2"><strong>Phone:</strong> <?php echo htmlspecialchars($photographer['contact_phone']); ?></p>
                            <?php if (!empty($photographer['bio'])): ?>
                                <p class="card-text"><strong>Bio:</strong> <?php echo nl2br(htmlspecialchars($photographer['bio'])); ?></p>
                            <?php endif; ?>
                            <div class="mt-3">
                                <a href="<?php echo get_url('admin/photographers/edit_photographer.php?id=' . $photographer['id']); ?>" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?php echo get_url('admin/photographers/delete_photographer.php?id=' . $photographer['id']); ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this photographer?');">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?> 