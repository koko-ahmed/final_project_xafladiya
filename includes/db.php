<?php
$serverlocalhost = "localhost";
$username = "root";
$password = "";
$database = "xafladia_db";

$db = mysqli_connect($serverlocalhost, $username, $password, $database);

if(!$db){
    die("Connection failed: " . mysqli_connect_error());
}

// Only process form data if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields exist
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $message = mysqli_real_escape_string($db, $_POST['message']);
        
        $query = "INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);
        
        if($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);
            
            if(mysqli_stmt_execute($stmt)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to save message']);
            }
            
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    }
}
?>
