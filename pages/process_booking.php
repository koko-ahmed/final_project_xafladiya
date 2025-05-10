<?php
require_once '../db_connect.php';

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $service = $_POST['service'] ?? '';
    $professional = $_POST['professional'] ?? '';
    $date = $_POST['date'] ?? '';
    $message = $_POST['message'] ?? '';
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($service) || empty($date)) {
        http_response_code(400);
        echo json_encode(['error' => 'Please fill in all required fields']);
        exit;
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['error' => 'Please enter a valid email address']);
        exit;
    }
    
    // Validate date (must be in the future)
    $booking_date = new DateTime($date);
    $today = new DateTime();
    if ($booking_date < $today) {
        http_response_code(400);
        echo json_encode(['error' => 'Please select a future date']);
        exit;
    }
    
    try {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, service_type, professional_id, booking_date, message, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
        
        // Bind parameters
        $stmt->bind_param("sssssss", $name, $email, $phone, $service, $professional, $date, $message);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Send email notification to admin
            $to = "admin@xafladia.com";
            $email_subject = "New Booking Request: " . ucfirst($service);
            $email_body = "Name: " . $name . "\n";
            $email_body .= "Email: " . $email . "\n";
            $email_body .= "Phone: " . $phone . "\n";
            $email_body .= "Service: " . ucfirst($service) . "\n";
            $email_body .= "Professional: " . ucfirst($professional) . "\n";
            $email_body .= "Date: " . $date . "\n";
            $email_body .= "Message: " . $message . "\n";
            
            $headers = "From: " . $email . "\r\n";
            $headers .= "Reply-To: " . $email . "\r\n";
            
            mail($to, $email_subject, $email_body, $headers);
            
            // Send confirmation email to customer
            $customer_subject = "Booking Confirmation - Xafladiya";
            $customer_body = "Dear " . $name . ",\n\n";
            $customer_body .= "Thank you for booking with Xafladiya. We have received your booking request for " . ucfirst($service) . " on " . $date . ".\n\n";
            $customer_body .= "Our team will review your request and contact you shortly to confirm the details.\n\n";
            $customer_body .= "Best regards,\nXafladiya Team";
            
            mail($email, $customer_subject, $customer_body, "From: noreply@xafladia.com\r\n");
            
            // Return success response
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Error executing statement");
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'An error occurred while processing your request']);
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If not POST request, return 405 Method Not Allowed
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
} 