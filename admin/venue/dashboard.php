<?php
require_once __DIR__ . '/../../config/config.php'; // Load config first (includes get_url function)
require_once __DIR__ . '/../../config/session_config.php'; // Then session config
require_once __DIR__ . '/../../includes/admin_auth.php'; // Then admin auth
require_once __DIR__ . '/../../includes/header.php';    // Then header

$message = '';
$message_type = '';

// Handle venue update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['venue_id'])) {
    $venue_id = filter_input(INPUT_POST, 'venue_id', FILTER_SANITIZE_NUMBER_INT);
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
            $message = 'Venue updated successfully!';
            $message_type = 'success';
        } else {
            $message = 'Error updating venue: ' . mysqli_error($db);
            $message_type = 'danger';
        }
    }
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $capacity = trim($_POST['capacity'] ?? '');
    $features = trim($_POST['features'] ?? '');
    $events = trim($_POST['events'] ?? '');
    $image = $_FILES['image'] ?? null;
    $contactName = trim($_POST['contactName'] ?? '');
    $contactPhone = trim($_POST['contactPhone'] ?? '');

    if (empty($name) || empty($location) || empty($description)) {
        $message = 'All required fields are missing.';
        $message_type = 'danger';
    } else {
        // Sanitize for database using the existing connection ($db from db.php)
        $name = mysqli_real_escape_string($db, $name);
        $location = mysqli_real_escape_string($db, $location);
        $description = mysqli_real_escape_string($db, $description);
        $price = mysqli_real_escape_string($db, $price);
        $capacity = mysqli_real_escape_string($db, $capacity);
        $features = mysqli_real_escape_string($db, $features);
        $events = mysqli_real_escape_string($db, $events);
        $contactName = mysqli_real_escape_string($db, $contactName);
        $contactPhone = mysqli_real_escape_string($db, $contactPhone);

        // Handle image upload
        $image_path = null; // Initialize image_path
        // Check if file was uploaded without errors
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/images/venues/'; // Directory to save uploaded images relative to admin/

            // Create the upload directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Ensure directory exists and is writable
            }

            $file_tmp_path = $_FILES['image']['tmp_name'];
            $file_name = $_FILES['image']['name'];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Generate a unique file name to prevent overwriting
            $new_file_name = uniqid() . '.' . $file_extension;
            $target_file_path = $upload_dir . $new_file_name;

            // Check if the file is an actual image
            $check = getimagesize($file_tmp_path);
            if($check !== false) {
                 // Check file size (optional, add your limit)
                // if ($_FILES['image']['size'] > 500000) { // Example: 500KB
                //     $message = "Sorry, your file is too large.";
                //     $message_type = "danger";
                // } else {
                    // Allow certain file formats
                    if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg"
                    && $file_extension != "gif" ) {
                        $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $message_type = "danger";
                    } else {
                        // Try to move the uploaded file
                        if (move_uploaded_file($file_tmp_path, $target_file_path)) {
                            // File successfully moved, store the relative path in database
                            // This path should be relative to your web root for displaying images
                            $image_path = 'assets/images/venues/' . $new_file_name; // Store this in DB
                        } else {
                             // Detailed error reporting for move_uploaded_file failure
                            $php_upload_error = $_FILES['image']['error'];
                            $php_error_message = "";
                            switch ($php_upload_error) {
                                case UPLOAD_ERR_INI_SIZE:
                                    $php_error_message = "The uploaded file exceeds the upload_max_filesize directive.";
                                    break;
                                case UPLOAD_ERR_FORM_SIZE:
                                    $php_error_message = "The uploaded file exceeds the MAX_FILE_SIZE directive.";
                                    break;
                                case UPLOAD_ERR_PARTIAL:
                                    $php_error_message = "The uploaded file was only partially uploaded.";
                                    break;
                                case UPLOAD_ERR_NO_FILE:
                                    $php_error_message = "No file was uploaded.";
                                    break;
                                case UPLOAD_ERR_NO_TMP_DIR:
                                    $php_error_message = "Missing a temporary folder.";
                                    break;
                                case UPLOAD_ERR_CANT_WRITE:
                                    $php_error_message = "Failed to write file to disk (permissions issue?).";
                                    break;
                                case UPLOAD_ERR_EXTENSION:
                                    $php_error_message = "A PHP extension stopped the file upload.";
                                    break;
                                default:
                                    // Check file system permissions if move_uploaded_file failed but PHP had no specific upload error
                                    if (!is_writable($upload_dir)) {
                                         $php_error_message = "Upload directory is not writable. Check permissions.";
                                    } else {
                                         $php_error_message = "Unknown file move error. Check server logs.";
                                    }
                                    break;
                            }

                            $message = "Sorry, there was an error uploading your image: " . $php_error_message;
                            $message_type = "danger";
                             error_log("Image upload failed: " . $message); // Log detailed error
                        }
                    }
                // } // End file size check
            } else {
                $message = "File is not a valid image or is corrupted.";
                $message_type = "danger";
            }
        } else if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
             // Handle other potential upload errors, excluding UPLOAD_ERR_NO_FILE (no file was uploaded)
             $message = "Error during file upload. Error code: " . $_FILES['image']['error'];
             $message_type = "danger";
        }


        // Prepare and execute the INSERT query
        $query = "INSERT INTO venues (name, location, description, price, capacity, features, events, image, contact_name, contact_phone)";
        $query .= " VALUES (";
        $query .= "'" . $name . "', ";
        $query .= "'" . $location . "', ";
        $query .= "'" . $description . "', ";
        // Handle optional fields using concatenation and ternary operator
        $query .= ($price ? "'" . $price . "'" : "NULL") . ", ";
        $query .= ($capacity ? "'" . $capacity . "'" : "NULL") . ", ";
        $query .= ($features ? "'" . $features . "'" : "NULL") . ", ";
        $query .= ($events ? "'" . $events . "'" : "NULL") . ", ";
        // Use the $image_path variable which contains the path relative to the webroot
        $query .= ($image_path ? "'" . mysqli_real_escape_string($db, $image_path) . "'" : "NULL");
        $query .= ", '". $contactName . "', ";
        $query .= "'" . $contactPhone . "'";
        $query .= ")";


        if (mysqli_query($db, $query)) {
            $message = 'Venue added successfully!';
            $message_type = 'success';
        } else {
            $message = 'Error adding venue: ' . mysqli_error($db);
            $message_type = 'danger';
        }
    }
}

?>

<div class="container mt-5">
    <h1>Admin Dashboard</h1>

    <h2>Add New Venue</h2>
    <!-- Replacing the existing form with the modal trigger button -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVenueModal">
        <i class="fas fa-plus-circle me-2"></i> Add New Venue
    </button>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Include the Add Venue Modal HTML -->
    <div class="modal fade" id="addVenueModal" tabindex="-1" aria-labelledby="addVenueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(90deg, #684596 0%, #f58f1f 100%); color: #fff;">
                <h5 class="modal-title" id="addVenueModalLabel">Add Your Venue</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data"> <!-- Corrected action -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="venueName" class="form-label">Venue Name</label>
                        <input type="text" class="form-control" id="venueName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="venueLocation" class="form-label">Location</label>
                        <input type="text" class="form-control" id="venueLocation" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="venueDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="venueDescription" name="description" rows="4" required></textarea>
                    </div>
                     <div class="mb-3">
                        <label for="venuePrice" class="form-label">Price (e.g., $500/day)</label>
                        <input type="text" class="form-control" id="venuePrice" name="price">
                    </div>
                    <div class="mb-3">
                        <label for="venueCapacity" class="form-label">Capacity (e.g., Up to 300 guests)</label>
                        <input type="text" class="form-control" id="venueCapacity" name="capacity">
                    </div>
                     <div class="mb-3">
                        <label for="venueFeatures" class="form-label">Features (Comma separated, e.g., AC, Parking, WiFi)</label>
                        <input type="text" class="form-control" id="venueFeatures" name="features">
                    </div>
                     <div class="mb-3">
                        <label for="venueEvents" class="form-label">Suitable Events (Comma separated, e.g., Weddings, Parties)</label>
                        <input type="text" class="form-control" id="venueEvents" name="events">
                    </div>
        <div class="mb-3">
                        <label for="venueImage" class="form-label">Venue Image</label>
                        <input type="file" class="form-control" id="venueImage" name="image">
        </div>
        <div class="mb-3">
                        <label for="contactName" class="form-label">Contact Name</label>
                        <input type="text" class="form-control" id="contactName" name="contactName">
        </div>
        <div class="mb-3">
                        <label for="contactPhone" class="form-label">Contact Phone</label>
                        <input type="text" class="form-control" id="contactPhone" name="contactPhone">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Venue</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <?php
    // Fetch venues from the database
    $venues = [];
    $query = "SELECT id, name, location, description, price, capacity, features, events, image, contact_name, contact_phone FROM venues ORDER BY name";
    $result = mysqli_query($db, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $venues[] = $row;
        }
        mysqli_free_result($result);
    } else {
        $message = 'Error fetching venues: ' . mysqli_error($db);
        $message_type = 'danger';
    }
    ?>

    <?php if ($message && $message_type === 'danger'): // Display error only if fetching failed ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $message; ?>
        </div>
    <?php elseif (empty($venues)): ?>
        <p>No venues found.</p>
    <?php else: ?>
        
        <h2 class="mt-5">Existing Venues</h2>
        
        <div class="row g-4">
            <?php foreach ($venues as $venue): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-once="true">
                <div class="venue-card">
            <div class="venue-img-wrapper">
    <?php if (!empty($venue['image'])): ?>
        <img src="<?php echo get_url($venue['image']); ?>" 
             alt="<?php echo htmlspecialchars($venue['name']); ?>" 
             class="img-fluid lazy-load"
             loading="lazy" />
    <?php else: ?>
        <img src="<?php echo get_url('assets/images/placeholder.jpg'); ?>" 
             alt="No Image Available" 
             class="img-fluid lazy-load"
             loading="lazy" />
    <?php endif; ?>
    
    <?php if (!empty($venue['price'])): ?>
        <div class="venue-price"><?php echo htmlspecialchars($venue['price']); ?></div>
    <?php endif; ?>

    <?php if (!empty($venue['capacity'])): ?>
        <div class="venue-capacity-overlay">
            <i class="fas fa-users"></i> Up to <?php echo htmlspecialchars($venue['capacity']); ?> guests
        </div>
    <?php endif; ?>
                        </div>

                        <div class="venue-info">
                            <h4 class="venue-name"><?php echo htmlspecialchars($venue['name']); ?></h4>
                            <p class="venue-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($venue['location']); ?></p>
                            <?php if (!empty($venue['description'])): ?>
                                <p class="venue-description"><?php echo nl2br(htmlspecialchars($venue['description'])); ?></p>
    <?php endif; ?>

    <?php if (!empty($venue['features'])): ?>
                                <div class="venue-features">
            <?php 
            $features = explode(', ', $venue['features']);
            $feature_icons = [
                'AC' => 'snowflake',
                'Parking' => 'parking',
                'WiFi' => 'wifi',
                'Sound System' => 'music',
                'Catering' => 'utensils',
                'Projector' => 'tv',
                'Decoration' => 'paint-brush',
                'Outdoor Space' => 'tree',
                'Photography' => 'camera',
                'Bar Service' => 'glass-martini-alt',
                'Weather Protection' => 'umbrella',
                'Exhibition Space' => 'booth-curtain',
                'AV Equipment' => 'tv'
            ];
            foreach($features as $feature): 
                $feature = trim($feature);
                $icon = $feature_icons[$feature] ?? 'check';
            ?>
                                        <span class="feature-tooltip" data-bs-toggle="tooltip" title="<?php echo htmlspecialchars($feature); ?>">
                    <i class="fas fa-<?php echo $icon; ?>"></i>
                </span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($venue['events'])): ?>
                                <div class="venue-events">
            <?php foreach(explode(', ', $venue['events']) as $event): ?>
                <span class="event-tag"><?php echo htmlspecialchars(trim($event)); ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

                            <div class="admin-actions mt-3">
                                <a href="edit_venue.php?id=<?php echo $venue['id']; ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                <a href="delete_venue.php?id=<?php echo $venue['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this venue?');"><i class="fas fa-trash-alt"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
</div>

    <?php endif; ?>

</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?> 

<!-- Add CSS for venue cards -->
<style>
/* Modern Card Styles */
.venue-card {
    background: linear-gradient(to bottom, #ffffff, #f8f9fa);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-bottom: 30px;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 
                0 2px 4px -1px rgba(0,0,0,0.06);
}

.venue-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 
                0 10px 10px -5px rgba(0,0,0,0.04);
}

.venue-img-wrapper {
    position: relative;
    height: 240px;
    overflow: hidden;
}

.venue-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.venue-card:hover .venue-img-wrapper img {
    transform: scale(1.05);
}

.venue-info {
    padding: 1.5rem;
}

.venue-name {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    color: #333;
}

.venue-location {
    font-size: 1rem;
    color: #555;
    margin-bottom: 1rem;
}

.venue-capacity {
    font-size: 0.9rem;
    color: #777;
    margin-bottom: 1rem;
}

.venue-description {
    font-size: 0.95rem;
    color: #666;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.venue-features, .venue-events {
    margin-bottom: 1rem;
}

.feature-tooltip {
    display: inline-block;
    background-color: #e9e9eb;
    color: #333;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
}

.event-tag {
    display: inline-block;
    background-color: #e3f2fd;
    color: #1976d2;;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
}

.venue-price {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 5px;
    font-size: 1rem;
}

.venue-capacity-overlay {
    position: absolute;
    bottom: 10px; /* Adjust position as needed */
    left: 10px; /* Adjust position as needed */
    background-color: rgba(0, 123, 255, 0.7); /* Bootstrap primary color with opacity */
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 5px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 5px;
}


.admin-actions {
    display: flex;
    gap: 10px;
}

.admin-actions .btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

/* Add animation classes */
[data-aos] {
    opacity: 0;
    transition-property: opacity, transform;
}

[data-aos].aos-animate {
    opacity: 1;
}

[data-aos="fade-up"] {
    transform: translateY(20px);
}

[data-aos="fade-up"].aos-animate {
    transform: translateY(0);
}
</style>

<!-- Add AOS library for animations -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS animation library
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script> 