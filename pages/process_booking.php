<?php
include '../includes/db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if required fields are set
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['service']) && isset($_POST['date'])) {
        
        // Sanitize and get form data
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $phone = mysqli_real_escape_string($db, $_POST['phone']);
        $service = mysqli_real_escape_string($db, $_POST['service']);
        $professional = mysqli_real_escape_string($db, $_POST['professional']); // Optional field
        $date = mysqli_real_escape_string($db, $_POST['date']);
        $message = mysqli_real_escape_string($db, $_POST['message']); // Optional field
        
        // Insert into database
        $query = "INSERT INTO bookings (name, email, phone, service_type, preferred_professional, preferred_date, additional_details, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = mysqli_prepare($db, $query);
        
        if($stmt) {
            // Bind parameters (s = string, i = integer, d = double, b = blob)
            mysqli_stmt_bind_param($stmt, "sssssss", $name, $email, $phone, $service, $professional, $date, $message);
            
            if(mysqli_stmt_execute($stmt)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to save booking: ' . mysqli_error($db)]);
            }
            
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database prepare error: ' . mysqli_error($db)]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

mysqli_close($db);
?> 