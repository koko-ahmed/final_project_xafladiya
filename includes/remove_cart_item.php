<?php
session_start();
$key = $_POST['key'] ?? null;
if ($key !== null && isset($_SESSION['cart'][$key])) {
    unset($_SESSION['cart'][$key]);
    $count = count($_SESSION['cart']);
    echo json_encode(['success' => true, 'count' => $count]);
    exit;
}
echo json_encode(['success' => false, 'count' => isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0]); 