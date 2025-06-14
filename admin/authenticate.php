<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../config/config.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = "Please enter both username and password.";
    header("Location: login.php");
    exit();
}

$stmt = $db->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    // Set session variables
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['last_activity'] = time();
    
    // Regenerate session ID for security
    session_regenerate_id(true);
    
    // Redirect to the new central admin dashboard
    header("Location: " . get_url('admin/dashboard.php'));
    exit();
} else {
    $_SESSION['login_error'] = "Invalid username or password.";
    header("Location: login.php");
    exit();
}

$stmt->close();
$db->close();
?>
