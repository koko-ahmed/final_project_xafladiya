<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ' . get_url('admin/photographers/dashboard.php'));
    exit;
}

$id = (int)$_GET['id'];

// First, get the photographer's image path
$query = "SELECT image FROM photographers WHERE id = $id";
$result = mysqli_query($db, $query);
$photographer = mysqli_fetch_assoc($result);

if ($photographer && !empty($photographer['image'])) {
    // Delete the image file if it exists
    $image_path = __DIR__ . '/../../' . $photographer['image'];
    if (file_exists($image_path)) {
        unlink($image_path);
    }
}

// Delete the photographer from the database
$query = "DELETE FROM photographers WHERE id = $id";
if (mysqli_query($db, $query)) {
    $_SESSION['message'] = 'Photographer deleted successfully.';
    $_SESSION['message_type'] = 'success';
} else {
    $_SESSION['message'] = 'Error deleting photographer: ' . mysqli_error($db);
    $_SESSION['message_type'] = 'danger';
}

header('Location: ' . get_url('admin/photographers/dashboard.php'));
exit; 