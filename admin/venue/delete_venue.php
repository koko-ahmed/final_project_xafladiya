<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/session_config.php';
require_once __DIR__ . '/../includes/admin_auth.php';
require_once __DIR__ . '/../includes/db.php';

// Get venue ID from URL
$venue_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$venue_id) {
    // Redirect back to dashboard with an error message if ID is missing
    $_SESSION['message'] = 'Invalid venue ID for deletion.';
    $_SESSION['message_type'] = 'danger';
    header('Location: ' . get_url('venue/dashboard.php'));
    exit();
}

// Prepare and execute the DELETE query
$query = "DELETE FROM venues WHERE id = " . mysqli_real_escape_string($db, $venue_id);

if (mysqli_query($db, $query)) {
    $_SESSION['message'] = 'Venue deleted successfully!';
    $_SESSION['message_type'] = 'success';
} else {
    $_SESSION['message'] = 'Error deleting venue: ' . mysqli_error($db);
    $_SESSION['message_type'] = 'danger';
}

// Redirect back to the admin dashboard
header("Location: " . get_url('venue/dashboard.php'));
exit();
?> 