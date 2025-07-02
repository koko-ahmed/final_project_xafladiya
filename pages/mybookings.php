<?php
session_start();
include '../includes/header.php';
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
?>
<div class="container py-5">
  <h2 class="mb-4">My Cart</h2>
  <?php if (empty($cart)): ?>
    <div class="alert alert-info">Your cart is empty.</div>
  <?php else: ?>
    <ul class="list-group mb-4">
      <?php foreach ($cart as $key => $item): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong><?php echo htmlspecialchars($item['type']); ?>:</strong> <?php echo htmlspecialchars($item['name']); ?>
            <?php if (!empty($item['date'])): ?>
              <span class="text-muted">(<?php echo htmlspecialchars($item['date']); ?>)</span>
            <?php endif; ?>
            <?php if (isset($item['price']) && $item['price'] !== ''): ?>
              <div class="small text-success">$<?php echo htmlspecialchars($item['price']); ?>
                <?php if (!empty($item['price_type'])): ?>
                  <span class="text-muted">(<?php echo htmlspecialchars($item['price_type']); ?>)</span>
                <?php endif; ?>
              </div>
              <?php $total += floatval($item['price']); ?>
            <?php endif; ?>
            <?php if (!empty($item['details'])): ?>
              <div class="small text-muted"><?php echo htmlspecialchars($item['details']); ?></div>
            <?php endif; ?>
          </div>
          <button class="btn btn-sm btn-danger remove-cart-item" data-key="<?php echo htmlspecialchars($key); ?>"><i class="fas fa-trash"></i></button>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="mb-4 text-end fw-bold">Total: $<?php echo number_format($total, 2); ?></div>
    <button class="btn btn-success" id="confirm-all-bookings">Confirm All Bookings</button>
  <?php endif; ?>
</div>
<script>
document.querySelectorAll('.remove-cart-item').forEach(btn => {
  btn.addEventListener('click', function () {
    const itemKey = this.dataset.key;
    fetch('../includes/remove_cart_item.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'key=' + encodeURIComponent(itemKey)
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        location.reload();
      }
    });
  });
});

document.getElementById('confirm-all-bookings')?.addEventListener('click', function () {
  fetch('../includes/confirm_cart.php', { method: 'POST' })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Bookings confirmed!');
        location.reload();
      }
    });
});
</script>
<?php include '../includes/footer.php'; ?> 