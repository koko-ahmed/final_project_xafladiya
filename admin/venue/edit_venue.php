<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/session_config.php';
require_once __DIR__ . '/../includes/admin_auth.php';
require_once __DIR__ . '/../includes/header.php';

$venue = null;
$message = '';
$message_type = '';

// Get venue ID from URL
$venue_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$venue_id) {
    $_SESSION['message'] = 'Invalid venue ID.';
    $_SESSION['message_type'] = 'danger';
    header("Location: " . get_url('venue/dashboard.php'));
    exit();
}

// Fetch venue data
$query = "SELECT id, name, location, description, price, capacity, features, events, image, contact_name, contact_phone FROM venues WHERE id = " . mysqli_real_escape_string($db, $venue_id);
$result = mysqli_query($db, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $venue = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    // Handle form submission for updating venue
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize and validate input
        $name = trim($_POST['name'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $capacity = trim($_POST['capacity'] ?? '');
        $features = trim($_POST['features'] ?? '');
        $events = trim($_POST['events'] ?? '');
        $contactName = trim($_POST['contactName'] ?? '');
        $contactPhone = trim($_POST['contactPhone'] ?? '');

        if (empty($name) || empty($location) || empty($description)) {
            $message = 'All required fields are mandatory.';
            $message_type = 'danger';
        } else {
            // Sanitize for database
            $name_db = mysqli_real_escape_string($db, $name);
            $location_db = mysqli_real_escape_string($db, $location);
            $description_db = mysqli_real_escape_string($db, $description);
            $price_db = mysqli_real_escape_string($db, $price);
            $capacity_db = mysqli_real_escape_string($db, $capacity);
            $features_db = mysqli_real_escape_string($db, $features);
            $events_db = mysqli_real_escape_string($db, $events);
            $contactName_db = mysqli_real_escape_string($db, $contactName);
            $contactPhone_db = mysqli_real_escape_string($db, $contactPhone);

            // Prepare and execute the UPDATE query
            $update_query = "UPDATE venues SET ";
            $update_query .= "name='{$name_db}', ";
            $update_query .= "location='{$location_db}', ";
            $update_query .= "description='{$description_db}', ";
            $update_query .= "price=" . ($price_db ? "'{$price_db}'" : "NULL") . ", ";
            $update_query .= "capacity=" . ($capacity_db ? "'{$capacity_db}'" : "NULL") . ", ";
            $update_query .= "features=" . ($features_db ? "'{$features_db}'" : "NULL") . ", ";
            $update_query .= "events=" . ($events_db ? "'{$events_db}'" : "NULL") . ", ";
            $update_query .= "contact_name='{$contactName_db}', ";
            $update_query .= "contact_phone='{$contactPhone_db}' ";
            $update_query .= "WHERE id = " . mysqli_real_escape_string($db, $venue_id);

            if (mysqli_query($db, $update_query)) {
                $_SESSION['message'] = 'Venue updated successfully!';
                $_SESSION['message_type'] = 'success';
                header("Location: " . get_url('venue/dashboard.php'));
                exit();
            } else {
                $message = 'Error updating venue: ' . mysqli_error($db);
                $message_type = 'danger';
            }
        }
    }
} else {
    $_SESSION['message'] = 'Venue not found.';
    $_SESSION['message_type'] = 'danger';
    header("Location: " . get_url('venue/dashboard.php'));
    exit();
}
?>

<div class="container mt-5">
    <h1>Edit Venue</h1>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($venue): ?>
        <form action="<?php echo get_url('venue/dashboard.php'); ?>" method="POST">
            <input type="hidden" name="venue_id" value="<?php echo $venue_id; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Venue Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($venue['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($venue['location']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($venue['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($venue['price']); ?>">
            </div>
            <div class="mb-3">
                <label for="capacity" class="form-label">Capacity</label>
                <input type="text" class="form-control" id="capacity" name="capacity" value="<?php echo htmlspecialchars($venue['capacity']); ?>">
            </div>
            <div class="mb-3">
                <label for="features" class="form-label">Features</label>
                <textarea class="form-control" id="features" name="features" rows="3"><?php echo htmlspecialchars($venue['features']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="events" class="form-label">Events</label>
                <textarea class="form-control" id="events" name="events" rows="3"><?php echo htmlspecialchars($venue['events']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="contactName" class="form-label">Contact Name</label>
                <input type="text" class="form-control" id="contactName" name="contactName" value="<?php echo htmlspecialchars($venue['contact_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="contactPhone" class="form-label">Contact Phone</label>
                <input type="text" class="form-control" id="contactPhone" name="contactPhone" value="<?php echo htmlspecialchars($venue['contact_phone']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Venue</button>
            <a href="<?php echo get_url('venue/dashboard.php'); ?>" class="btn btn-secondary">Cancel</a>
        </form>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?> 