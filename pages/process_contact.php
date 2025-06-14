<?php
require_once '../db_connect.php';

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
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
    
    try {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message, newsletter_subscription, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        
        // Bind parameters
        $stmt->bind_param("sssssi", $name, $email, $phone, $subject, $message, $newsletter);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Send email notification to admin
            $to = "admin@xafladia.com";
            $email_subject = "New Contact Form Submission: " . $subject;
            $email_body = "Name: " . $name . "\n";
            $email_body .= "Email: " . $email . "\n";
            $email_body .= "Phone: " . $phone . "\n";
            $email_body .= "Message: " . $message . "\n";
            $email_body .= "Newsletter Subscription: " . ($newsletter ? "Yes" : "No") . "\n";
            
            $headers = "From: " . $email . "\r\n";
            $headers .= "Reply-To: " . $email . "\r\n";
            
            mail($to, $email_subject, $email_body, $headers);
            
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