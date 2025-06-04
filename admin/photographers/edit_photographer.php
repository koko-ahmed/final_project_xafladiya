<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/db.php';

$message = '';
$message_type = '';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ' . get_url('admin/photographers/dashboard.php'));
    exit;
}

$id = (int)$_GET['id'];

// Fetch photographer data
$query = "SELECT * FROM photographers WHERE id = $id";
$result = mysqli_query($db, $query);
$photographer = mysqli_fetch_assoc($result);

if (!$photographer) {
    header('Location: ' . get_url('admin/photographers/dashboard.php'));
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = trim($_POST['name'] ?? '');
    $specialty = trim($_POST['specialty'] ?? '');
    $contactEmail = trim($_POST['contact_email'] ?? '');
    $contactPhone = trim($_POST['contact_phone'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $years_experience = trim($_POST['years_experience'] ?? '');
    $rating = trim($_POST['rating'] ?? '');
    $image = $_FILES['image'] ?? null;

    if (empty($name)) {
        $message = 'Photographer name is mandatory.';
        $message_type = 'danger';
    } else {
        // Sanitize for database
        $name = mysqli_real_escape_string($db, $name);
        $specialty = mysqli_real_escape_string($db, $specialty);
        $contactEmail = mysqli_real_escape_string($db, $contactEmail);
        $contactPhone = mysqli_real_escape_string($db, $contactPhone);
        $bio = mysqli_real_escape_string($db, $bio);
        $location = mysqli_real_escape_string($db, $location);
        $years_experience = mysqli_real_escape_string($db, $years_experience);
        $rating = mysqli_real_escape_string($db, $rating);

        // Handle image upload
        $image_path = $photographer['image']; // Keep existing image by default
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = __DIR__ . '/../../assets/images/photographers/';
            
            // Create directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_tmp_path = $_FILES['image']['tmp_name'];
            $file_name = $_FILES['image']['name'];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Generate unique filename
            $new_file_name = uniqid() . '.' . $file_extension;
            $target_file_path = $upload_dir . $new_file_name;

            // Check if file is an actual image
            $check = getimagesize($file_tmp_path);
            if ($check !== false) {
                // Allow certain file formats
                if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif") {
                    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $message_type = "danger";
                } else {
                    // Try to move the uploaded file
                    if (move_uploaded_file($file_tmp_path, $target_file_path)) {
                        // Delete old image if it exists
                        if (!empty($photographer['image'])) {
                            $old_image_path = __DIR__ . '/../../' . $photographer['image'];
                            if (file_exists($old_image_path)) {
                                unlink($old_image_path);
                            }
                        }
                        // Store the relative path
                        $image_path = 'assets/images/photographers/' . $new_file_name;
                    } else {
                        $message = "Sorry, there was an error uploading your image.";
                        $message_type = "danger";
                    }
                }
            } else {
                $message = "File is not a valid image.";
                $message_type = "danger";
            }
        }

        if (empty($message)) {
            // Update the photographer in the database
            $query = "UPDATE photographers SET 
                     name = '$name',
                     specialty = '$specialty',
                     contact_email = '$contactEmail',
                     contact_phone = '$contactPhone',
                     bio = '$bio',
                     location = '$location',
                     years_experience = '$years_experience',
                     rating = '$rating',
                     image = " . ($image_path ? "'$image_path'" : "NULL") . "
                     WHERE id = $id";

            if (mysqli_query($db, $query)) {
                $message = 'Photographer updated successfully!';
                $message_type = 'success';
                // Redirect after a short delay to show the success message
                echo '<script>setTimeout(function(){ window.location.href = "' . get_url('photographers.php') . '"; }, 1500);</script>';
            } else {
                $message = 'Error updating photographer: ' . mysqli_error($db);
                $message_type = 'danger';
            }
        }
    }
}
?>

<div class="container mt-5">
    <h1>Edit Photographer</h1>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Photographer Name</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="<?php echo htmlspecialchars($photographer['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="specialty" class="form-label">Specialty (e.g., Wedding, Events)</label>
            <input type="text" class="form-control" id="specialty" name="specialty" 
                   value="<?php echo htmlspecialchars($photographer['specialty']); ?>">
        </div>
        <div class="mb-3">
            <label for="contact_email" class="form-label">Contact Email</label>
            <input type="email" class="form-control" id="contact_email" name="contact_email" 
                   value="<?php echo htmlspecialchars($photographer['contact_email']); ?>">
        </div>
        <div class="mb-3">
            <label for="contact_phone" class="form-label">Contact Phone</label>
            <input type="text" class="form-control" id="contact_phone" name="contact_phone" 
                   value="<?php echo htmlspecialchars($photographer['contact_phone']); ?>">
        </div>
        <div class="mb-3">
            <label for="bio" class="form-label">Bio</label>
            <textarea class="form-control" id="bio" name="bio" rows="4"><?php echo htmlspecialchars($photographer['bio']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location (e.g., Mogadishu)</label>
            <input type="text" class="form-control" id="location" name="location" 
                   value="<?php echo htmlspecialchars($photographer['location'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label for="years_experience" class="form-label">Years of Experience</label>
            <input type="number" class="form-control" id="years_experience" name="years_experience" 
                   value="<?php echo htmlspecialchars($photographer['years_experience'] ?? ''); ?>" min="0">
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (out of 5.0, e.g., 4.5)</label>
            <input type="number" step="0.1" class="form-control" id="rating" name="rating" 
                   value="<?php echo htmlspecialchars($photographer['rating'] ?? ''); ?>" min="0" max="5">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Photographer Image</label>
            <?php if (!empty($photographer['image'])): ?>
                <div class="mb-2">
                    <img src="<?php echo get_url($photographer['image']); ?>" 
                         alt="Current Image" 
                         style="max-width: 200px; height: auto;">
                </div>
            <?php endif; ?>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <small class="form-text text-muted">Leave empty to keep the current image.</small>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Photographer</button>
        <a href="<?php echo get_url('admin/photographers/dashboard.php'); ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?> 