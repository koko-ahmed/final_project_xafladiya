<?php
session_start();
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $username = isset($_POST['username']) ? mysqli_real_escape_string($db, $_POST['username']) : null;
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if (empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['message'] = 'Please fill in all required fields.';
        header('Location: ../pages/register.php');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = 'Invalid email format.';
        header('Location: ../pages/register.php');
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['message'] = 'Passwords do not match.';
        header('Location: ../pages/register.php');
        exit();
    }

    // Check if email already exists
    $check_query = "SELECT id FROM users WHERE email = ?";
    $check_stmt = mysqli_prepare($db, $check_query);
    
    if (!$check_stmt) {
        $_SESSION['message'] = 'Database error: ' . mysqli_error($db);
        header('Location: ../pages/register.php');
        exit();
    }

    mysqli_stmt_bind_param($check_stmt, "s", $email);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
    
    if (mysqli_stmt_num_rows($check_stmt) > 0) {
        $_SESSION['message'] = 'Email already exists.';
        mysqli_stmt_close($check_stmt);
        header('Location: ../pages/register.php');
        exit();
    }
    
    mysqli_stmt_close($check_stmt);

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $insert_stmt = mysqli_prepare($db, $insert_query);
    
    if (!$insert_stmt) {
        $_SESSION['message'] = 'Database error: ' . mysqli_error($db);
        header('Location: ../pages/register.php');
        exit();
    }

    mysqli_stmt_bind_param($insert_stmt, "sss", $username, $email, $hashed_password);

    if (mysqli_stmt_execute($insert_stmt)) {
        $_SESSION['message'] = 'Registration successful! You can now log in.';
        header('Location: ../pages/login.php');
        exit();
    } else {
        $_SESSION['message'] = 'Registration failed: ' . mysqli_error($db);
        header('Location: ../pages/register.php');
        exit();
    }

    mysqli_stmt_close($insert_stmt);
    mysqli_close($db);
} else {
    // If not a POST request, redirect to register page
    header('Location: ../pages/register.php');
    exit();
}
?> 