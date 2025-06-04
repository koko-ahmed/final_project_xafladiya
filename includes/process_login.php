<?php
session_start();
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    // Basic validation
    if (empty($email) || empty($password)) {
        $_SESSION['message'] = 'Please fill in all fields.';
        header('Location: ../pages/login.php');
        exit();
    }

    // Fetch user from database
    $query = "SELECT id, username, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
        mysqli_stmt_fetch($stmt);

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Login successful
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            
            // Redirect to a protected page (e.g., index.php or a dashboard)
            header('Location: ../index.php'); // Change this to your desired redirect page
            exit();
        } else {
            // Incorrect password
            $_SESSION['message'] = 'Invalid email or password.';
            header('Location: ../pages/login.php');
            exit();
        }
    } else {
        // User not found
        $_SESSION['message'] = 'Invalid email or password.';
        header('Location: ../pages/login.php');
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($db);
} else {
    // If not a POST request, redirect to login page
    header('Location: ../pages/login.php');
    exit();
}
?> 