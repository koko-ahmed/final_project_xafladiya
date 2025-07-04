<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/admin_header.php';
require_once __DIR__ . '/../../includes/db.php';

$message = '';
$message_type = '';

// Handle form submission for adding a new photographer
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
    $price = trim($_POST['price'] ?? '');
    $price_type = trim($_POST['price_type'] ?? '');

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
        $price = mysqli_real_escape_string($db, $price);
        $price_type = mysqli_real_escape_string($db, $price_type);

        // Handle image upload (similar logic as in venue dashboard)
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = __DIR__ . '/../../assets/images/photographers/'; // Directory to save uploaded images

            // Create the upload directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Ensure directory exists and is writable
            }

            $file_tmp_path = $_FILES['image']['tmp_name'];
            $file_name = $_FILES['image']['name'];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Generate a unique file name
            $new_file_name = uniqid() . '.' . $file_extension;
            $target_file_path = $upload_dir . $new_file_name;

            // Check if the file is an actual image
            $check = getimagesize($file_tmp_path);
            if($check !== false) {
                 // Allow certain file formats
                if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg"
                    && $file_extension != "gif" ) {
                    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed for images.";
                    $message_type = "danger";
                } else {
                    // Try to move the uploaded file
                    if (move_uploaded_file($file_tmp_path, $target_file_path)) {
                        // Store the relative path in database
                        $image_path = 'assets/images/photographers/' . $new_file_name;
                    } else {
                         $message = "Sorry, there was an error uploading your image.";
                         $message_type = "danger";
                    }
                }
            } else {
                $message = "File is not a valid image or is corrupted.";
                $message_type = "danger";
            }
        } else if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
             $message = "Error during file upload. Error code: " . $_FILES['image']['error'];
             $message_type = "danger";
        }


        // Prepare and execute the INSERT query
        $query = "INSERT INTO photographers (name, specialty, contact_email, contact_phone, bio, image, location, years_experience, rating, price, price_type) VALUES (";
        $query .= "'" . $name . "', ";
        $query .= "'" . $specialty . "', ";
        $query .= "'" . $contactEmail . "', ";
        $query .= "'" . $contactPhone . "', ";
        $query .= "'" . $bio . "', ";
        $query .= ($image_path ? "'" . mysqli_real_escape_string($db, $image_path) . "'" : "NULL");
        $query .= ", ";
        $query .= "'" . $location . "', ";
        $query .= "'" . $years_experience . "', ";
        $query .= "'" . $rating . "', ";
        $query .= "'" . $price . "', ";
        $query .= "'" . $price_type . "'";
        $query .= ")";

        if (mysqli_query($db, $query)) {
            $message = 'Photographer added successfully!';
            $message_type = 'success';
            // Clear form fields after successful submission
            $name = $specialty = $contactEmail = $contactPhone = $bio = $location = $years_experience = $rating = $price = $price_type = '';
            // Redirect after a short delay to prevent resubmission on refresh
            echo '<script>setTimeout(function(){ window.location.href = "' . get_url('admin/photographers/dashboard.php') . '"; }, 2000);</script>';
        } else {
            $message = 'Error adding photographer: ' . mysqli_error($db);
            $message_type = 'danger';
        }
    }
}

?>

<div class="container-fluid">
  <div class="row">
    <?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mt-5">
      <h1>Add New Photographer</h1>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Photographer Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="specialty" class="form-label">Specialty (e.g., Wedding, Events)</label>
                <input type="text" class="form-control" id="specialty" name="specialty" value="<?php echo htmlspecialchars($specialty ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="contact_email" class="form-label">Contact Email</label>
                <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($contactEmail ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="contact_phone" class="form-label">Contact Phone</label>
                <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?php echo htmlspecialchars($contactPhone ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control" id="bio" name="bio" rows="4"><?php echo htmlspecialchars($bio ?? ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location (e.g., Mogadishu)</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($location ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="years_experience" class="form-label">Years of Experience</label>
                <input type="number" class="form-control" id="years_experience" name="years_experience" value="<?php echo htmlspecialchars($years_experience ?? ''); ?>" min="0">
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating (out of 5.0, e.g., 4.5)</label>
                <input type="number" step="0.1" class="form-control" id="rating" name="rating" value="<?php echo htmlspecialchars($rating ?? ''); ?>" min="0" max="5">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($price ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="price_type" class="form-label">Price Type</label>
                <select class="form-control" id="price_type" name="price_type" required>
                    <option value="" disabled selected>Select type</option>
                    <option value="per hour" <?php if(($price_type ?? '') == 'per hour') echo 'selected'; ?>>Per Hour</option>
                    <option value="per event" <?php if(($price_type ?? '') == 'per event') echo 'selected'; ?>>Per Event</option>
                    <option value="per day" <?php if(($price_type ?? '') == 'per day') echo 'selected'; ?>>Per Day</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Photographer Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            
            <button type="submit" class="btn btn-primary">Add Photographer</button>
            <a href="<?php echo get_url('admin/photographers/dashboard.php'); ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </main>
  </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?> 