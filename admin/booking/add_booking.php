<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/db.php';

$message = '';
$message_type = '';

// Fetch photographers for the dropdown
$photographers = [];
$photographer_query = "SELECT id, name FROM photographers ORDER BY name";
$photographer_result = mysqli_query($db, $photographer_query);

if ($photographer_result) {
    while ($row = mysqli_fetch_assoc($photographer_result)) {
        $photographers[] = $row;
    }
    mysqli_free_result($photographer_result);
}

// Handle form submission for adding a new booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $userName = trim($_POST['user_name'] ?? '');
    $userEmail = trim($_POST['user_email'] ?? '');
    $userPhone = trim($_POST['user_phone'] ?? '');
    $serviceType = trim($_POST['service_type'] ?? '');
    $professionalId = filter_input(INPUT_POST, 'professional_id', FILTER_SANITIZE_NUMBER_INT);
    $preferredDate = trim($_POST['preferred_date'] ?? '');
    $additionalDetails = trim($_POST['additional_details'] ?? '');
    $status = trim($_POST['status'] ?? 'Pending');

    if (empty($userName) || empty($userEmail) || empty($userPhone) || empty($serviceType) || empty($preferredDate)) {
        $message = 'Required fields (Name, Email, Phone, Service Type, Preferred Date) are mandatory.';
        $message_type = 'danger';
    } else {
        // Sanitize for database
        $userName = mysqli_real_escape_string($db, $userName);
        $userEmail = mysqli_real_escape_string($db, $userEmail);
        $userPhone = mysqli_real_escape_string($db, $userPhone);
        $serviceType = mysqli_real_escape_string($db, $serviceType);
        $professionalId = $professionalId ? mysqli_real_escape_string($db, $professionalId) : 'NULL';
        $preferredDate = mysqli_real_escape_string($db, $preferredDate);
        $additionalDetails = mysqli_real_escape_string($db, $additionalDetails);
        $status = mysqli_real_escape_string($db, $status);

        // Prepare and execute the INSERT query
        $query = "INSERT INTO photographer_bookings (user_name, user_email, user_phone, service_type, professional_id, preferred_date, additional_details, status) VALUES (';
        $query .= "'" . $userName . "', ";
        $query .= "'" . $userEmail . "', ";
        $query .= "'" . $userPhone . "', ";
        $query .= "'" . $serviceType . "', ";
        $query .= $professionalId . ', ';
        $query .= "'" . $preferredDate . "', ";
        $query .= "'" . $additionalDetails . "', ";
        $query .= "'" . $status . "')";

        if (mysqli_query($db, $query)) {
            $message = 'Booking added successfully!';
            $message_type = 'success';
            // Clear form fields after successful submission
            $userName = $userEmail = $userPhone = $serviceType = $professionalId = $preferredDate = $additionalDetails = $status = '';
             // Redirect after a short delay to prevent resubmission on refresh
            echo '<script>setTimeout(function(){ window.location.href = "' . get_url('admin/booking/dashboard.php') . '"; }, 2000);</script>';
        } else {
            $message = 'Error adding booking: ' . mysqli_error($db);
            $message_type = 'danger';
        }
    }
}

?>

<div class="container mt-5">
    <h1>Add New Photographer Booking</h1>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="userName" class="form-label">User Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="userName" name="user_name" value="<?php echo htmlspecialchars($userName ?? ''); ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="userEmail" class="form-label">User Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="userEmail" name="user_email" value="<?php echo htmlspecialchars($userEmail ?? ''); ?>" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="userPhone" class="form-label">User Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="userPhone" name="user_phone" value="<?php echo htmlspecialchars($userPhone ?? ''); ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                 <div class="mb-3">
                    <label for="serviceType" class="form-label">Service Type <span class="text-danger">*</span></label>
                     <select class="form-select" id="serviceType" name="service_type" required>
                        <option value="">Select Service Type</option>
                        <option value="Photography" <?php echo (isset($serviceType) && $serviceType === 'Photography') ? 'selected' : ''; ?>>Photography</option>
                        <option value="Videography" <?php echo (isset($serviceType) && $serviceType === 'Videography') ? 'selected' : ''; ?>>Videography</option>
                        <option value="Both" <?php echo (isset($serviceType) && $serviceType === 'Both') ? 'selected' : ''; ?>>Both</option>
                        <!-- Add more service types as needed -->
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                 <div class="mb-3">
                    <label for="professionalId" class="form-label">Preferred Professional</label>
                     <select class="form-select" id="professionalId" name="professional_id">
                        <option value="">Select a Professional (Optional)</option>
                        <?php foreach ($photographers as $photographer): ?>
                            <option value="<?php echo $photographer['id']; ?>" <?php echo (isset($professionalId) && (int)$professionalId === (int)$photographer['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($photographer['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="preferredDate" class="form-label">Preferred Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="preferredDate" name="preferred_date" value="<?php echo htmlspecialchars($preferredDate ?? ''); ?>" required>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="additionalDetails" class="form-label">Additional Details</label>
            <textarea class="form-control" id="additionalDetails" name="additional_details" rows="4"><?php echo htmlspecialchars($additionalDetails ?? ''); ?></textarea>
        </div>

         <div class="mb-3">
            <label for="status" class="form-label">Status</label>
             <select class="form-select" id="status" name="status">
                <option value="Pending" <?php echo (isset($status) && $status === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Confirmed" <?php echo (isset($status) && $status === 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                <option value="Cancelled" <?php echo (isset($status) && $status === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                <option value="Completed" <?php echo (isset($status) && $status === 'Completed') ? 'selected' : ''; ?>>Completed</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Booking</button>
        <a href="<?php echo get_url('admin/booking/dashboard.php'); ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?> 