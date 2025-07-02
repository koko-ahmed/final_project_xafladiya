<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

// Initialize message variables
$message = '';
$message_type = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = isset($_POST['price']) && $_POST['price'] !== '' ? floatval($_POST['price']) : null;
    $capacity = filter_var($_POST['capacity'], FILTER_VALIDATE_INT) ?: null;
    $features = trim($_POST['features'] ?? '');
    $events = trim($_POST['events'] ?? '');
    $contactName = trim($_POST['contactName'] ?? '');
    $contactPhone = trim($_POST['contactPhone'] ?? '');

    if (empty($name) || empty($location) || empty($description)) {
        $_SESSION['message'] = 'All required fields (Name, Location, Description) are mandatory.';
        $_SESSION['message_type'] = 'danger';
        header('Location: ' . get_url('admin/venue/add_venue.php'));
        exit();
    }

    $image_path = null;
    // Handle image upload
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
                $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $_SESSION['message_type'] = 'danger';
                header('Location: ' . get_url('admin/venue/add_venue.php'));
                exit();
            }

            if (move_uploaded_file($file_tmp_path, $target_file_path)) {
                $image_path = 'assets/images/venues/' . $new_file_name;
            } else {
                $php_upload_error = $_FILES['image']['error'];
                $php_error_message = "";
                switch ($php_upload_error) {
                    case UPLOAD_ERR_INI_SIZE: $php_error_message = "The uploaded file exceeds the upload_max_filesize directive."; break;
                    case UPLOAD_ERR_FORM_SIZE: $php_error_message = "The uploaded file exceeds the MAX_FILE_SIZE directive."; break;
                    case UPLOAD_ERR_PARTIAL: $php_error_message = "The uploaded file was only partially uploaded."; break;
                    case UPLOAD_ERR_NO_FILE: $php_error_message = "No file was uploaded."; break;
                    case UPLOAD_ERR_NO_TMP_DIR: $php_error_message = "Missing a temporary folder."; break;
                    case UPLOAD_ERR_CANT_WRITE: $php_error_message = "Failed to write file to disk (permissions issue?)."; break;
                    case UPLOAD_ERR_EXTENSION: $php_error_message = "A PHP extension stopped the file upload."; break;
                    default: $php_error_message = "Unknown file move error."; break;
                }
                $_SESSION['message'] = "Sorry, there was an error uploading your image: " . $php_error_message;
                $_SESSION['message_type'] = 'danger';
                error_log("Image upload failed: " . $_SESSION['message']);
                header('Location: ' . get_url('admin/venue/add_venue.php'));
                exit();
            }
        } else {
            $_SESSION['message'] = "File is not a valid image or is corrupted.";
            $_SESSION['message_type'] = 'danger';
            header('Location: ' . get_url('admin/venue/add_venue.php'));
            exit();
        }
    } else if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $_SESSION['message'] = "Error during file upload. Error code: " . $_FILES['image']['error'];
        $_SESSION['message_type'] = 'danger';
        header('Location: ' . get_url('admin/venue/add_venue.php'));
        exit();
    }

    // Prepare and execute the INSERT query using prepared statements
    $query = "INSERT INTO venues (name, location, description, price, capacity, features, events, image, contact_name, contact_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sssdssssss', 
            $name, $location, $description, $price, $capacity, 
            $features, $events, $image_path, $contactName, $contactPhone
        );

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = 'Venue added successfully!';
            $_SESSION['message_type'] = 'success';
            header('Location: ' . get_url('admin/venue/dashboard.php'));
            exit();
        } else {
            $_SESSION['message'] = 'Error adding venue: ' . mysqli_stmt_error($stmt);
            $_SESSION['message_type'] = 'danger';
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = 'Database query preparation failed: ' . mysqli_error($db);
        $_SESSION['message_type'] = 'danger';
    }
    header('Location: ' . get_url('admin/venue/add_venue.php'));
    exit();
}

// Display any messages on page load (e.g., from a redirect)
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
                <h1 class="h2">Add New Venue</h1>
            </div>

            <?php if($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="modern-card">
                <div class="card-body">
                    <form action="add_venue.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Venue Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price (e.g., 500.00)</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price">
                        </div>
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacity (Number of guests)</label>
                            <input type="number" class="form-control" id="capacity" name="capacity">
                        </div>
                        <div class="mb-3">
                            <label for="features" class="form-label">Features (Comma separated, e.g., AC, Parking, WiFi)</label>
                            <input type="text" class="form-control" id="features" name="features">
                        </div>
                        <div class="mb-3">
                            <label for="events" class="form-label">Suitable Events (Comma separated, e.g., Weddings, Parties)</label>
                            <input type="text" class="form-control" id="events" name="events">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Venue Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="contactName" class="form-label">Contact Name</label>
                            <input type="text" class="form-control" id="contactName" name="contactName">
                        </div>
                        <div class="mb-3">
                            <label for="contactPhone" class="form-label">Contact Phone</label>
                            <input type="text" class="form-control" id="contactPhone" name="contactPhone">
                        </div>
                        <button type="submit" class="btn btn-primary-gradient">Add Venue</button>
                        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?> 