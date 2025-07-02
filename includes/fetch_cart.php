<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
if (empty($cart)) {
    echo '<div class="text-center text-muted">Your cart is empty.</div>';
    exit;
}
$total = 0;
echo '<ul class="list-group">';
foreach ($cart as $key => $item) {
    echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
    echo '<div>';
    echo '<strong>' . htmlspecialchars($item['type']) . ':</strong> ' . htmlspecialchars($item['name']);
    if (!empty($item['date'])) echo ' <span class="text-muted">(' . htmlspecialchars($item['date']) . ')</span>';
    if (isset($item['price']) && $item['price'] !== '') {
        echo '<div class="small text-success">$' . htmlspecialchars($item['price']);
        if (!empty($item['price_type'])) echo ' <span class="text-muted">(' . htmlspecialchars($item['price_type']) . ')</span>';
        echo '</div>';
        $total += floatval($item['price']);
    }
    echo '</div>';
    echo '<button class="btn btn-sm btn-danger remove-cart-item" data-key="' . htmlspecialchars($key) . '"><i class="fas fa-trash"></i></button>';
    echo '</li>';
}

echo '</ul>';
echo '<div class="mt-3 text-end fw-bold">Total: $' . number_format($total, 2) . '</div>'; 
