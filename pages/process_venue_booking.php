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

    // If this is a check-only request (AJAX), just check availability and return JSON
    if (isset($_POST['check_only']) && $_POST['check_only'] == '1' && $venue_id && $event_date) {
        $check_query = $db->prepare("SELECT COUNT(*) FROM venue_bookings WHERE venue_id = ? AND event_date = ?");
        $check_query->bind_param("is", $venue_id, $event_date);
        $check_query->execute();
        $check_query->bind_result($count);
        $check_query->fetch();
        $check_query->close();
        if ($count > 0) {
            echo json_encode(['success' => false, 'message' => '❌ This hall is already booked. Please choose another time or venue.']);
        } else {
            echo json_encode(['success' => true, 'message' => '✅ Venue is available.']);
        }
        exit;
    }

    // Basic validation
    if ($user_name && $user_email && $user_phone && $venue_id && $venue_name && $event_date && $guests && $duration_hours && $payment_method) {
        // Check if the venue is already booked for the selected date
        $db->begin_transaction();
        $check_query = $db->prepare("SELECT COUNT(*) FROM venue_bookings WHERE venue_id = ? AND event_date = ? FOR UPDATE");
        $check_query->bind_param("is", $venue_id, $event_date);
        $check_query->execute();
        $check_query->bind_result($count);
        $check_query->fetch();
        $check_query->close();

        if ($count > 0) {
            $db->rollback();
            $message = '❌ This hall is already booked. Please choose another time or venue.';
            // If AJAX, return JSON
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => $message]);
                exit;
            } else {
                $_SESSION['message'] = $message;
                $_SESSION['message_type'] = 'danger';
                header('Location: ../pages/hotels.php?booking=error');
                exit;
            }
        }
        // Venue is available
        $message = '✅ Venue is available.';
        // Proceed to insert booking
        $query = "INSERT INTO venue_bookings (user_name, user_email, user_phone, venue_id, venue_name, event_date, guests, duration_hours, special_requirements, payment_method, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        if (!$stmt) {
            $db->rollback();
            die("MySQL prepare error: " . $db->error);
        }
        $stmt->bind_param("sssississss", $user_name, $user_email, $user_phone, $venue_id, $venue_name, $event_date, $guests, $duration_hours, $special_requirements, $payment_method, $status);
        if ($stmt->execute()) {
            $stmt->close();
            $db->commit();
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
            // If AJAX, return JSON
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => true, 'message' => $message]);
                exit;
            } else {
                header('Location: ../pages/hotels.php?booking=success');
                exit;
            }
        } else {
            $stmt->close();
            $db->rollback();
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => 'Error saving booking. Please try again.']);
                exit;
            } else {
                header('Location: ../pages/hotels.php?booking=error');
                exit;
            }
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