<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

$venue = null;

// Get venue ID from URL
$venue_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$venue_id) {
    $_SESSION['message'] = 'Invalid venue ID provided.';
    $_SESSION['message_type'] = 'danger';
    header("Location: " . get_url('admin/venue/dashboard.php'));
    exit();
}

// Handle form submission for updating venue
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $venue_id_post = filter_input(INPUT_POST, 'venue_id', FILTER_SANITIZE_NUMBER_INT);
    if ($venue_id_post != $venue_id) {
        $_SESSION['message'] = 'Security error: Venue ID mismatch.';
        $_SESSION['message_type'] = 'danger';
        header("Location: " . get_url('admin/venue/dashboard.php'));
        exit();
    }

    // Sanitize and validate input
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT) ?: null;
    $capacity = filter_var($_POST['capacity'], FILTER_VALIDATE_INT) ?: null;
    $features = trim($_POST['features'] ?? '');
    $events = trim($_POST['events'] ?? '');
    $contactName = trim($_POST['contactName'] ?? '');
    $contactPhone = trim($_POST['contactPhone'] ?? '');

    if (empty($name) || empty($location) || empty($description)) {
        $_SESSION['message'] = 'All required fields (Name, Location, Description) are mandatory.';
        $_SESSION['message_type'] = 'danger';
        header('Location: ' . get_url('admin/venue/edit_venue.php?id=' . $venue_id));
        exit();
    }

    // Fetch current image path for potential deletion
    $current_image_path_query = "SELECT image FROM venues WHERE id = ?";
    $stmt_img = mysqli_prepare($db, $current_image_path_query);
    mysqli_stmt_bind_param($stmt_img, 'i', $venue_id);
    mysqli_stmt_execute($stmt_img);
    mysqli_stmt_bind_result($stmt_img, $current_image);
    mysqli_stmt_fetch($stmt_img);
    mysqli_stmt_close($stmt_img);

    $image_path = $current_image; // Default to current image

    // Handle new image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../../assets/images/venues/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_tmp_path = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = uniqid() . '.' . $file_extension;
        $target_file_path = $upload_dir . $new_file_name;

        $check = getimagesize($file_tmp_path);
        if($check !== false) {
            if(!in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed for image upload.";
                $_SESSION['message_type'] = 'danger';
                header('Location: ' . get_url('admin/venue/edit_venue.php?id=' . $venue_id));
                exit();
            }

            if (move_uploaded_file($file_tmp_path, $target_file_path)) {
                $image_path = 'assets/images/venues/' . $new_file_name;
                // Delete old image if a new one was uploaded and old one exists
                if ($current_image && file_exists(__DIR__ . '/../../' . $current_image)) {
                    unlink(__DIR__ . '/../../' . $current_image);
                }
            } else {
                $_SESSION['message'] = "Error uploading new image. Please try again.";
                $_SESSION['message_type'] = 'danger';
                header('Location: ' . get_url('admin/venue/edit_venue.php?id=' . $venue_id));
                exit();
            }
        } else {
            $_SESSION['message'] = "Uploaded file is not a valid image or is corrupted.";
            $_SESSION['message_type'] = 'danger';
            header('Location: ' . get_url('admin/venue/edit_venue.php?id=' . $venue_id));
            exit();
        }
    } else if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $_SESSION['message'] = "Error during file upload. Error code: " . $_FILES['image']['error'];
        $_SESSION['message_type'] = 'danger';
        header('Location: ' . get_url('admin/venue/edit_venue.php?id=' . $venue_id));
        exit();
    }

    // Prepare and execute the UPDATE query using prepared statements
    $update_query = "UPDATE venues SET name = ?, location = ?, description = ?, price = ?, capacity = ?, features = ?, events = ?, image = ?, contact_name = ?, contact_phone = ? WHERE id = ?";
    $stmt = mysqli_prepare($db, $update_query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sssdssssssi', 
            $name, $location, $description, $price, $capacity, 
            $features, $events, $image_path, $contactName, $contactPhone, $venue_id
        );

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = 'Venue updated successfully!';
            $_SESSION['message_type'] = 'success';
            header("Location: " . get_url('admin/venue/dashboard.php'));
            exit();
        } else {
            $_SESSION['message'] = 'Error updating venue: ' . mysqli_stmt_error($stmt);
            $_SESSION['message_type'] = 'danger';
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = 'Database query preparation failed: ' . mysqli_error($db);
        $_SESSION['message_type'] = 'danger';
    }
    // If there was an error during update, redirect back to edit page
    header('Location: ' . get_url('admin/venue/edit_venue.php?id=' . $venue_id));
    exit();
}

// Fetch venue data for display (if not a POST request or if POST failed)
$query = "SELECT id, name, location, description, price, capacity, features, events, image, contact_name, contact_phone FROM venues WHERE id = ? LIMIT 1";
$stmt = mysqli_prepare($db, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'i', $venue_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $venue = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['message'] = 'Venue not found.';
        $_SESSION['message_type'] = 'danger';
        header("Location: " . get_url('admin/venue/dashboard.php'));
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['message'] = 'Database query preparation failed: ' . mysqli_error($db);
    $_SESSION['message_type'] = 'danger';
    header("Location: " . get_url('admin/venue/dashboard.php'));
    exit();
}

// Display messages if redirected from a previous action
if(isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

?>

<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mt-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Venue</h1>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($venue): ?>
                <div class="modern-card">
                    <div class="card-body">
                        <form action="edit_venue.php?id=<?php echo $venue_id; ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="venue_id" value="<?php echo htmlspecialchars($venue['id']); ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Venue Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($venue['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($venue['location']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($venue['description']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price (e.g., 500.00)</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($venue['price'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Capacity (Number of guests)</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo htmlspecialchars($venue['capacity'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="features" class="form-label">Features (Comma separated, e.g., AC, Parking, WiFi)</label>
                                <input type="text" class="form-control" id="features" name="features" value="<?php echo htmlspecialchars($venue['features'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="events" class="form-label">Suitable Events (Comma separated, e.g., Weddings, Parties)</label>
                                <input type="text" class="form-control" id="events" name="events" value="<?php echo htmlspecialchars($venue['events'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Venue Image</label>
                                <?php if (!empty($venue['image'])): ?>
                                    <div class="mb-2">
                                        Current Image: <img src="<?php echo get_url($venue['image']); ?>" alt="Current Venue Image" style="max-width: 150px; height: auto;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <small class="form-text text-muted">Upload a new image to replace the current one.</small>
                            </div>
                            <div class="mb-3">
                                <label for="contactName" class="form-label">Contact Name</label>
                                <input type="text" class="form-control" id="contactName" name="contactName" value="<?php echo htmlspecialchars($venue['contact_name'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="contactPhone" class="form-label">Contact Phone</label>
                                <input type="text" class="form-control" id="contactPhone" name="contactPhone" value="<?php echo htmlspecialchars($venue['contact_phone'] ?? ''); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary-gradient">Update Venue</button>
                            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?> 