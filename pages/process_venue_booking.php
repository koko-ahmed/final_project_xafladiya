<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';
header('Content-Type: application/json');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = trim($_POST['user_name'] ?? '');
    $user_email = trim($_POST['user_email'] ?? '');
    $user_phone = trim($_POST['user_phone'] ?? '');
    $venue_id = !empty($_POST['venue_id']) ? (int)$_POST['venue_id'] : null;
    $venue_name = trim($_POST['venue_name'] ?? '');
    $event_date = trim($_POST['event_date'] ?? '');
    $guests = !empty($_POST['guests']) ? (int)$_POST['guests'] : null;
    $duration_hours = !empty($_POST['duration_hours']) ? (int)$_POST['duration_hours'] : null;
    $special_requirements = trim($_POST['special_requirements'] ?? '');
    $payment_method = trim($_POST['payment_method'] ?? '');
    $status = 'pending';

    // Basic validation
    if ($user_name && $user_email && $user_phone && $venue_id && $venue_name && $event_date && $guests && $duration_hours && $payment_method) {
        $query = "INSERT INTO venue_bookings (user_name, user_email, user_phone, venue_id, venue_name, event_date, guests, duration_hours, special_requirements, payment_method, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        if (!$stmt) {
            die("MySQL prepare error: " . $db->error);
        }
        $stmt->bind_param("sssississss", $user_name, $user_email, $user_phone, $venue_id, $venue_name, $event_date, $guests, $duration_hours, $special_requirements, $payment_method, $status);
        if ($stmt->execute()) {
            $stmt->close();
            // Fetch venue price from DB
            $venue_price = 0;
            $venue_query = $db->prepare('SELECT price FROM venues WHERE id = ? LIMIT 1');
            if ($venue_query) {
                $venue_query->bind_param('i', $venue_id);
                $venue_query->execute();
                $venue_query->bind_result($venue_price);
                $venue_query->fetch();
                $venue_query->close();
            }
            // Add to cart session
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
            $_SESSION['cart'][uniqid()] = [
                'type' => 'Venue',
                'name' => $venue_name,
                'date' => $event_date,
                'price' => $venue_price,
                'guests' => $guests,
                'duration_hours' => $duration_hours
            ];
            header('Location: ../pages/hotels.php?booking=success');
            exit;
        } else {
            $stmt->close();
            header('Location: ../pages/hotels.php?booking=error');
            exit;
        }
    } else {
        header('Location: ../pages/hotels.php?booking=error');
        exit;
    }
} else {
    header('Location: ../pages/hotels.php?booking=error');
    exit;
}
?> 