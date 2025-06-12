<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photographer_id'])) {
    $photographer_id = filter_input(INPUT_POST, 'photographer_id', FILTER_SANITIZE_NUMBER_INT);

    if ($photographer_id) {
        // First, get the photographer's image path
        $query = "SELECT image FROM photographers WHERE id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, 'i', $photographer_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && $photographer = mysqli_fetch_assoc($result)) {
            // Delete the image file if it exists
            if (!empty($photographer['image'])) {
                $image_path = __DIR__ . '/../../' . $photographer['image'];
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }
        mysqli_stmt_close($stmt);

        // Delete the photographer from the database
        $query = "DELETE FROM photographers WHERE id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, 'i', $photographer_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = 'Photographer deleted successfully!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error deleting photographer: ' . mysqli_error($db);
            $_SESSION['message_type'] = 'danger';
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = 'Invalid photographer ID.';
        $_SESSION['message_type'] = 'danger';
    }
} else {
    $_SESSION['message'] = 'Invalid request method.';
    $_SESSION['message_type'] = 'danger';
}

header('Location: ' . get_url('admin/photographers/dashboard.php'));
exit(); 