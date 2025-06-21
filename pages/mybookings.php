<?php include '../includes/header.php'; ?>

<?php
if (!isset($_SESSION['email'])) {
    echo '<div class="container mt-5"><div class="alert alert-warning">You must be logged in to view your bookings.</div></div>';
    include '../includes/footer.php';
    exit;
}

$user_email = $_SESSION['email'];
include '../includes/db.php';

$bookings = [];
$error = '';

// Fetch general bookings
$query1 = "SELECT 'Venue/Event' AS booking_type, service_type, preferred_professional, preferred_date, additional_details, created_at, NULL as status FROM bookings WHERE email = ? ORDER BY created_at DESC";
$stmt1 = mysqli_prepare($db, $query1);
if ($stmt1) {
    mysqli_stmt_bind_param($stmt1, 's', $user_email);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    while ($row = mysqli_fetch_assoc($result1)) {
        $bookings[] = $row;
    }
    mysqli_stmt_close($stmt1);
} else {
    $error .= '<div class="alert alert-danger">Could not fetch general bookings. Table may not exist or query failed.<br>Error: ' . htmlspecialchars(mysqli_error($db)) . '</div>';
}

// Fetch photographer bookings
$query2 = "SELECT 'Cameraman' AS booking_type, service_type, professional_id, preferred_date, additional_details, booking_date as created_at, status FROM photographer_bookings WHERE user_email = ? ORDER BY booking_date DESC";
$stmt2 = mysqli_prepare($db, $query2);
if ($stmt2) {
    mysqli_stmt_bind_param($stmt2, 's', $user_email);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    while ($row = mysqli_fetch_assoc($result2)) {
        $bookings[] = $row;
    }
    mysqli_stmt_close($stmt2);
} else {
    $error .= '<div class="alert alert-danger">Could not fetch cameraman bookings. Table may not exist or query failed.<br>Error: ' . htmlspecialchars(mysqli_error($db)) . '</div>';
}

// Sort all bookings by date (descending)
usort($bookings, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
?>

<div class="container mt-5">
    <h1>My Bookings</h1>
    <?php echo $error; ?>
    <?php if (empty($bookings) && !$error): ?>
        <div class="alert alert-info">You have not made any bookings yet.</div>
    <?php elseif (!empty($bookings)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Service/Details</th>
                        <th>Preferred Professional</th>
                        <th>Preferred Date</th>
                        <th>Additional Details</th>
                        <th>Date Booked</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['booking_type']); ?></td>
                            <td><?php echo htmlspecialchars($booking['service_type']); ?></td>
                            <td><?php echo isset($booking['preferred_professional']) ? htmlspecialchars($booking['preferred_professional']) : (isset($booking['professional_id']) ? htmlspecialchars($booking['professional_id']) : ''); ?></td>
                            <td><?php echo htmlspecialchars($booking['preferred_date']); ?></td>
                            <td><?php echo htmlspecialchars($booking['additional_details']); ?></td>
                            <td><?php echo htmlspecialchars($booking['created_at']); ?></td>
                            <td><?php echo isset($booking['status']) ? htmlspecialchars($booking['status']) : 'N/A'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?> 