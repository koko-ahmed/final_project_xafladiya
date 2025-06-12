<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

$message = '';
$message_type = '';
$redirect = false;
$event = null;

// Get event ID from URL
$event_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$event_id) {
    $_SESSION['message'] = 'Invalid event ID.';
    $_SESSION['message_type'] = 'danger';
    $redirect = true;
} else {
    // Fetch event data
    $query = "SELECT * FROM events WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, 'i', $event_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        // Handle form submission for updating event
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input
            $title = trim($_POST['title'] ?? '');
            $type = trim($_POST['type'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $event_date = trim($_POST['event_date'] ?? '');
            $event_time = trim($_POST['event_time'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $capacity = !empty($_POST['capacity']) ? (int)$_POST['capacity'] : null;
            $price = !empty($_POST['price']) ? (float)$_POST['price'] : null;
            $status = trim($_POST['status'] ?? 'active');

            if (empty($title) || empty($type) || empty($description) || empty($event_date) || empty($location)) {
                $message = 'Please fill in all required fields.';
                $message_type = 'danger';
            } else {
                // Handle image upload
                $image_path = $event['image_path'];
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = __DIR__ . '/../../assets/images/events/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }

                    $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

                    if (in_array($file_extension, $allowed_extensions)) {
                        $new_filename = uniqid() . '.' . $file_extension;
                        $upload_path = $upload_dir . $new_filename;

                        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                            // Delete old image if exists
                            if (!empty($event['image_path'])) {
                                $old_image_path = __DIR__ . '/../../' . $event['image_path'];
                                if (file_exists($old_image_path)) {
                                    unlink($old_image_path);
                                }
                            }
                            $image_path = 'assets/images/events/' . $new_filename;
                        }
                    }
                }

                // Prepare and execute the UPDATE query
                $query = "UPDATE events SET 
                         title = ?, type = ?, description = ?, event_date = ?, 
                         event_time = ?, location = ?, capacity = ?, price = ?, 
                         status = ?, image_path = ? 
                         WHERE id = ?";
                
                $stmt = mysqli_prepare($db, $query);
                mysqli_stmt_bind_param($stmt, 'ssssssdsssi', 
                    $title, $type, $description, $event_date, $event_time, 
                    $location, $capacity, $price, $status, $image_path, $event_id
                );

                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['message'] = 'Event updated successfully!';
                    $_SESSION['message_type'] = 'success';
                    $redirect = true;
                } else {
                    $message = 'Error updating event: ' . mysqli_error($db);
                    $message_type = 'danger';
                }
                mysqli_stmt_close($stmt);
            }
        }
    } else {
        $_SESSION['message'] = 'Event not found.';
        $_SESSION['message_type'] = 'danger';
        $redirect = true;
    }
}

// Handle redirect before any output
if ($redirect) {
    header("Location: " . get_url('admin/events/dashboard.php'));
    exit();
}

// Include header after all potential redirects
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Edit Event</h2>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                            <?php echo $message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($event): ?>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Event Title *</label>
                                <input type="text" class="form-control" id="title" name="title" 
                                       value="<?php echo htmlspecialchars($event['title']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Event Type *</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="">Select Event Type</option>
                                    <option value="wedding" <?php echo $event['type'] === 'wedding' ? 'selected' : ''; ?>>Wedding</option>
                                    <option value="graduation" <?php echo $event['type'] === 'graduation' ? 'selected' : ''; ?>>Graduation</option>
                                    <option value="corporate" <?php echo $event['type'] === 'corporate' ? 'selected' : ''; ?>>Corporate</option>
                                    <option value="birthday" <?php echo $event['type'] === 'birthday' ? 'selected' : ''; ?>>Birthday</option>
                                    <option value="other" <?php echo $event['type'] === 'other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($event['description']); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="event_date" class="form-label">Event Date *</label>
                                    <input type="date" class="form-control" id="event_date" name="event_date" 
                                           value="<?php echo $event['event_date']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="event_time" class="form-label">Event Time</label>
                                    <input type="time" class="form-control" id="event_time" name="event_time" 
                                           value="<?php echo $event['event_time']; ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Location *</label>
                                <input type="text" class="form-control" id="location" name="location" 
                                       value="<?php echo htmlspecialchars($event['location']); ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="number" class="form-control" id="capacity" name="capacity" min="0" 
                                           value="<?php echo $event['capacity']; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" 
                                           value="<?php echo $event['price']; ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Event Image</label>
                                <?php if (!empty($event['image_path'])): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo get_url($event['image_path']); ?>" alt="Current event image" 
                                             class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <small class="text-muted">Leave empty to keep the current image</small>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active" <?php echo $event['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo $event['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="<?php echo get_url('admin/events/dashboard.php'); ?>" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Event</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?> 