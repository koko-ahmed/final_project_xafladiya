<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

// Fetch photographers from the database
$photographers = [];
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT * FROM photographers";
if ($search !== '') {
    $search_escaped = mysqli_real_escape_string($db, $search);
    $query .= " WHERE name LIKE '%$search_escaped%' OR contact_email LIKE '%$search_escaped%' OR contact_phone LIKE '%$search_escaped%' OR specialty LIKE '%$search_escaped%' OR location LIKE '%$search_escaped%'";
}
$query .= " ORDER BY name ASC";
$result = mysqli_query($db, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $photographers[] = $row;
    }
    mysqli_free_result($result);
} else {
    $_SESSION['message'] = 'Error fetching photographers: ' . mysqli_error($db);
    $_SESSION['message_type'] = 'danger';
}
?>

<?php include __DIR__ . '/../../includes/admin_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mt-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Manage Photographers</h1>
                <a href="add_photographer.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Photographer
                </a>
            </div>

            <!-- Search Form -->
            <form method="get" class="mb-3" style="max-width: 400px;">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search photographers..." value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-success" type="submit">Search</button>
                    <?php if ($search !== ''): ?>
                        <a href="dashboard.php" class="btn btn-danger">Reset</a>
                    <?php endif; ?>
                </div>
            </form>

            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                    <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Specialty</th>
                            <th>Bio</th>
                            <th>Location</th>
                            <th>Years Exp.</th>
                            <th>Rating</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($photographers)): ?>
                            <tr>
                                <td colspan="10" class="text-center">No photographers found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($photographers as $photographer): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($photographer['name']); ?></td>
                                    <td><?php echo htmlspecialchars($photographer['contact_email']); ?></td>
                                    <td><?php echo htmlspecialchars($photographer['contact_phone']); ?></td>
                                    <td><?php echo htmlspecialchars($photographer['specialty']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($photographer['bio'], 0, 50)) . (strlen($photographer['bio']) > 50 ? '...' : ''); ?></td>
                                    <td><?php echo htmlspecialchars($photographer['location']); ?></td>
                                    <td><?php echo htmlspecialchars($photographer['years_experience']); ?></td>
                                    <td><?php echo htmlspecialchars($photographer['rating']); ?></td>
                                    <td>
                                        <?php if (!empty($photographer['image'])): ?>
                                            <img src="<?php echo get_url($photographer['image']); ?>" alt="Photographer Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                        <?php else: ?>
                                            No Image
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="edit_photographer.php?id=<?php echo $photographer['id']; ?>" class="btn btn-sm btn-success me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete(<?php echo $photographer['id']; ?>, '<?php echo htmlspecialchars($photographer['name']); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the photographer "<span id="photographerName"></span>"?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" action="delete_photographer.php" method="POST" style="display: inline;">
                    <input type="hidden" name="photographer_id" id="photographerId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(photographerId, photographerName) {
    document.getElementById('photographerId').value = photographerId;
    document.getElementById('photographerName').textContent = photographerName;
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Initialize all tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?> 