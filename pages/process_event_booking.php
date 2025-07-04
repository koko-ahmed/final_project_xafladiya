<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : null;
    $ticket_quantity = isset($_POST['ticketQuantity']) ? intval($_POST['ticketQuantity']) : null;
    $full_name = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $payment_method = trim($_POST['paymentMethod'] ?? '');
    $created_at = date('Y-m-d H:i:s');

    // Basic validation
    if ($event_id && $ticket_quantity && $full_name && $email && $phone && $payment_method) {
        // Get event info for cart and price
        $event_title = '';
        $event_price = 0;
        $event_query = $db->prepare('SELECT title, price, event_date FROM events WHERE id = ? LIMIT 1');
        if ($event_query) {
            $event_query->bind_param('i', $event_id);
            $event_query->execute();
            $event_query->bind_result($event_title, $event_price, $event_date);
            $event_query->fetch();
            $event_query->close();
        }
        // Insert into bookings table
        $stmt = $db->prepare('INSERT INTO bookings (event_id, ticket_quantity, full_name, email, phone, payment_method, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)');
        if ($stmt) {
            $stmt->bind_param('iisssss', $event_id, $ticket_quantity, $full_name, $email, $phone, $payment_method, $created_at);
            $success = $stmt->execute();
            $stmt->close();
            if ($success) {
                // Add to cart session
                if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
                $_SESSION['cart'][uniqid()] = [
                    'type' => 'Event',
                    'name' => $event_title,
                    'date' => $event_date ?? '',
                    'price' => $event_price * $ticket_quantity,
                    'details' => 'Tickets: ' . $ticket_quantity
                ];
                header('Location: events.php?booking=success');
                exit;
            } else {
                header('Location: events.php?booking=error');
                exit;
            }
        } else {
            header('Location: events.php?booking=error');
            exit;
        }
    } else {
        header('Location: events.php?booking=error');
        exit;
    }
} else {
    header('Location: events.php?booking=error');
    exit;
} 