<?php
include '../includes/db.php'; // Include database connection

// Debug: Show that the handler is being called
file_put_contents(__DIR__ . '/debug_booking.txt', "Handler called at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debug: Log POST data
    file_put_contents(__DIR__ . '/debug_booking.txt', "POST: " . print_r($_POST, true) . "\n", FILE_APPEND);
    // Check if required fields are set
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['service']) && isset($_POST['date'])) {
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $phone = mysqli_real_escape_string($db, $_POST['phone']);
        $service = mysqli_real_escape_string($db, $_POST['service']);
        $professional = mysqli_real_escape_string($db, $_POST['professional']); // Optional field
        $date = mysqli_real_escape_string($db, $_POST['date']);
        $message = mysqli_real_escape_string($db, $_POST['message']); // Optional field

        // If service is photography or videography, insert into photographer_bookings
        if (in_array(strtolower($service), ['photography', 'videography', 'both'])) {
            $query = "INSERT INTO photographer_bookings (user_name, user_email, user_phone, service_type, professional_id, preferred_date, additional_details, status, booking_date) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";
            $stmt = mysqli_prepare($db, $query);
            if($stmt) {
                mysqli_stmt_bind_param($stmt, "sssssss", $name, $email, $phone, $service, $professional, $date, $message);
                $exec = mysqli_stmt_execute($stmt);
                // Debug: Log SQL error if any
                if(!$exec) {
                    file_put_contents(__DIR__ . '/debug_booking.txt', "SQL Error: " . mysqli_error($db) . "\n", FILE_APPEND);
                }
                if($exec) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to save cameraman booking: ' . mysqli_error($db)]);
                }
                mysqli_stmt_close($stmt);
            } else {
                file_put_contents(__DIR__ . '/debug_booking.txt', "Prepare Error: " . mysqli_error($db) . "\n", FILE_APPEND);
                echo json_encode(['status' => 'error', 'message' => 'Database prepare error: ' . mysqli_error($db)]);
            }
        } else {
            // Insert into general bookings table
            $query = "INSERT INTO bookings (name, email, phone, service_type, preferred_professional, preferred_date, additional_details, created_at) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = mysqli_prepare($db, $query);
            if($stmt) {
                mysqli_stmt_bind_param($stmt, "sssssss", $name, $email, $phone, $service, $professional, $date, $message);
                $exec = mysqli_stmt_execute($stmt);
                if(!$exec) {
                    file_put_contents(__DIR__ . '/debug_booking.txt', "SQL Error: " . mysqli_error($db) . "\n", FILE_APPEND);
                }
                if($exec) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to save booking: ' . mysqli_error($db)]);
                }
                mysqli_stmt_close($stmt);
            } else {
                file_put_contents(__DIR__ . '/debug_booking.txt', "Prepare Error: " . mysqli_error($db) . "\n", FILE_APPEND);
                echo json_encode(['status' => 'error', 'message' => 'Database prepare error: ' . mysqli_error($db)]);
            }
        }
    } else {
        file_put_contents(__DIR__ . '/debug_booking.txt', "Missing required fields\n", FILE_APPEND);
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    }
} else {
    file_put_contents(__DIR__ . '/debug_booking.txt', "Invalid request method\n", FILE_APPEND);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

mysqli_close($db);
?> 