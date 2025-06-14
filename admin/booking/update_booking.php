<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = filter_input(INPUT_POST, 'booking_id', FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    if ($booking_id && $status) {
        $query = "UPDATE photographer_bookings SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "si", $status, $booking_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = 'Booking status updated successfully!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error updating booking status: ' . mysqli_error($db);
            $_SESSION['message_type'] = 'danger';
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = 'Invalid booking data.';
        $_SESSION['message_type'] = 'danger';
    }
} else {
    $_SESSION['message'] = 'Invalid request method.';
    $_SESSION['message_type'] = 'danger';
}

header("Location: dashboard.php");
exit();
?> 