<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = filter_input(INPUT_POST, 'event_id', FILTER_SANITIZE_NUMBER_INT);

    if ($event_id) {
        // First, get the event's image path
        $query = "SELECT image_path FROM events WHERE id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, 'i', $event_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && $row = mysqli_fetch_assoc($result)) {
            // Delete the event image if it exists
            if (!empty($row['image_path'])) {
                $image_path = __DIR__ . '/../../' . $row['image_path'];
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }
        mysqli_stmt_close($stmt);

        // Delete the event from the database
        $query = "DELETE FROM events WHERE id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, 'i', $event_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = 'Event deleted successfully!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error deleting event: ' . mysqli_error($db);
            $_SESSION['message_type'] = 'danger';
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = 'Invalid event ID.';
        $_SESSION['message_type'] = 'danger';
    }
} else {
    $_SESSION['message'] = 'Invalid request method.';
    $_SESSION['message_type'] = 'danger';
}

// Redirect back to the dashboard
header("Location: " . get_url('admin/events/dashboard.php'));
exit(); 