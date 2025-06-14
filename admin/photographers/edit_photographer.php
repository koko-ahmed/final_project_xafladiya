<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

$redirect = false;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = 'Invalid photographer ID.';
    $_SESSION['message_type'] = 'danger';
    header('Location: ' . get_url('admin/photographers/dashboard.php'));
    exit;
}

$id = (int)$_GET['id'];

// Fetch photographer data
$query = "SELECT * FROM photographers WHERE id = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$photographer = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$photographer) {
    $_SESSION['message'] = 'Photographer not found.';
    $_SESSION['message_type'] = 'danger';
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
    $years_experience = filter_var($_POST['years_experience'] ?? '', FILTER_VALIDATE_INT);
    $rating = filter_var($_POST['rating'] ?? '', FILTER_VALIDATE_FLOAT);

    if (empty($name)) {
        $_SESSION['message'] = 'Photographer name is mandatory.';
        $_SESSION['message_type'] = 'danger';
        $redirect = true;
    }

    if ($redirect) {
        header('Location: ' . get_url('admin/photographers/dashboard.php'));
        exit();
    }

    // Handle image upload
    $image_path = $photographer['image']; // Keep existing image by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../../assets/images/photographers/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_tmp_path = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $new_file_name = uniqid() . '.' . $file_extension;
        $target_file_path = $upload_dir . $new_file_name;

        $check = getimagesize($file_tmp_path);
        if ($check === false) {
            $_SESSION['message'] = "File is not a valid image.";
            $_SESSION['message_type'] = "danger";
            $redirect = true;
        } else if (!in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $_SESSION['message_type'] = "danger";
            $redirect = true;
        } else {
            if (move_uploaded_file($file_tmp_path, $target_file_path)) {
                if (!empty($photographer['image'])) {
                    $old_image_path = __DIR__ . '/../../' . $photographer['image'];
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
                $image_path = 'assets/images/photographers/' . $new_file_name;
            } else {
                $_SESSION['message'] = "Sorry, there was an error uploading your image.";
                $_SESSION['message_type'] = "danger";
                $redirect = true;
            }
        }
    } else if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
         $_SESSION['message'] = "Error during file upload. Error code: " . $_FILES['image']['error'];
         $_SESSION['message_type'] = "danger";
         $redirect = true;
    }

    if ($redirect) {
        header('Location: ' . get_url('admin/photographers/dashboard.php'));
        exit();
    }

    // Update the photographer in the database using prepared statement
    $query = "UPDATE photographers SET 
             name = ?,
             specialty = ?,
             contact_email = ?,
             contact_phone = ?,
             bio = ?,
             location = ?,
             years_experience = ?,
             rating = ?,
             image = ?
             WHERE id = ?";

    $stmt = mysqli_prepare($db, $query);
    
    // Determine image_path binding value
    $image_bind_value = $image_path;
    if (empty($image_path)) {
        $image_bind_value = NULL;
    }

    // Bind parameters with correct types
    mysqli_stmt_bind_param($stmt, 'ssssssidsi',
        $name,
        $specialty,
        $contactEmail,
        $contactPhone,
        $bio,
        $location,
        $years_experience,
        $rating,
        $image_bind_value,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = 'Photographer updated successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error updating photographer: ' . mysqli_error($db);
        $_SESSION['message_type'] = 'danger';
    }
    mysqli_stmt_close($stmt);

    header('Location: ' . get_url('admin/photographers/dashboard.php'));
    exit();
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mt-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Photographer</h1>
            </div>

            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                    <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                    ?>
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
                           value="<?php echo htmlspecialchars($photographer['location']); ?>">
                </div>
                <div class="mb-3">
                    <label for="years_experience" class="form-label">Years of Experience</label>
                    <input type="number" class="form-control" id="years_experience" name="years_experience" 
                           value="<?php echo htmlspecialchars($photographer['years_experience']); ?>" min="0">
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating (out of 5.0, e.g., 4.5)</label>
                    <input type="number" step="0.1" class="form-control" id="rating" name="rating" 
                           value="<?php echo htmlspecialchars($photographer['rating']); ?>" min="0" max="5">
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
        </main>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?> 