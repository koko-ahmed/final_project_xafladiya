<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $venue_id = filter_input(INPUT_POST, 'venue_id', FILTER_SANITIZE_NUMBER_INT);

    if (!$venue_id) {
        $_SESSION['message'] = 'Invalid venue ID for deletion.';
        $_SESSION['message_type'] = 'danger';
        header('Location: ' . get_url('admin/venue/dashboard.php'));
        exit();
    }

    // Get the image path before deleting the record
    $get_image_query = "SELECT image FROM venues WHERE id = ?";
    $stmt_get_image = mysqli_prepare($db, $get_image_query);
    if ($stmt_get_image) {
        mysqli_stmt_bind_param($stmt_get_image, 'i', $venue_id);
        mysqli_stmt_execute($stmt_get_image);
        mysqli_stmt_bind_result($stmt_get_image, $image_to_delete);
        mysqli_stmt_fetch($stmt_get_image);
        mysqli_stmt_close($stmt_get_image);

        // Delete the record from the database using prepared statement
        $delete_query = "DELETE FROM venues WHERE id = ?";
        $stmt_delete = mysqli_prepare($db, $delete_query);

        if ($stmt_delete) {
            mysqli_stmt_bind_param($stmt_delete, 'i', $venue_id);
            if (mysqli_stmt_execute($stmt_delete)) {
                // If deletion successful, remove the image file
                if (!empty($image_to_delete) && file_exists(__DIR__ . '/../../' . $image_to_delete)) {
                    unlink(__DIR__ . '/../../' . $image_to_delete);
                }
                $_SESSION['message'] = 'Venue deleted successfully!';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Error deleting venue: ' . mysqli_stmt_error($stmt_delete);
                $_SESSION['message_type'] = 'danger';
            }
            mysqli_stmt_close($stmt_delete);
        } else {
            $_SESSION['message'] = 'Database query preparation failed: ' . mysqli_error($db);
            $_SESSION['message_type'] = 'danger';
        }
    } else {
        $_SESSION['message'] = 'Database query preparation for image failed: ' . mysqli_error($db);
        $_SESSION['message_type'] = 'danger';
    }
} else {
    $_SESSION['message'] = 'Invalid request method.';
    $_SESSION['message_type'] = 'danger';
}

header("Location: " . get_url('admin/venue/dashboard.php'));
exit();
?> 