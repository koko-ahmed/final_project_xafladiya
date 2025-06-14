<?php
require_once '../config/config.php';
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $user_name = mysqli_real_escape_string($db, $_POST['name']);
    $user_email = mysqli_real_escape_string($db, $_POST['email']);
    $user_phone = mysqli_real_escape_string($db, $_POST['phone']);
    $service_type = mysqli_real_escape_string($db, $_POST['service']);
    $professional_name = mysqli_real_escape_string($db, $_POST['professional']);
    $preferred_date = mysqli_real_escape_string($db, $_POST['date']);
    $additional_details = mysqli_real_escape_string($db, $_POST['message']);
    
    // Get professional_id from photographers table
    $professional_id = null;
    if (!empty($professional_name)) {
        $query = "SELECT id FROM photographers WHERE name = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "s", $professional_name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $professional_id = $row['id'];
        }
        mysqli_stmt_close($stmt);
    }

    // Insert booking into database
    $query = "INSERT INTO photographer_bookings (
        user_name, 
        user_email, 
        user_phone, 
        service_type, 
        professional_id,
        preferred_date, 
        additional_details, 
        booking_date, 
        status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 'pending')";

    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "sssssss", 
        $user_name, 
        $user_email, 
        $user_phone, 
        $service_type, 
        $professional_id,
        $preferred_date, 
        $additional_details
    );

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['booking_success'] = true;
        header("Location: cameraman.php#booking");
        exit();
    } else {
        $_SESSION['booking_error'] = "Error submitting booking: " . mysqli_error($db);
        header("Location: cameraman.php#booking");
        exit();
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: cameraman.php");
    exit();
}
?> 