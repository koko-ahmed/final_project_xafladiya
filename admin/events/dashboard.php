<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/session_config.php';
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/db.php';

$message = '';
$message_type = '';

// Fetch events from the database
$events = [];
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT * FROM events";
if ($search !== '') {
    $search_escaped = mysqli_real_escape_string($db, $search);
    $query .= " WHERE title LIKE '%$search_escaped%' OR type LIKE '%$search_escaped%' OR location LIKE '%$search_escaped%' OR status LIKE '%$search_escaped%'";
}
$query .= " ORDER BY event_date DESC";
$result = mysqli_query($db, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
    mysqli_free_result($result);
} else {
    $message = 'Error fetching events: ' . mysqli_error($db);
    $message_type = 'danger';
}
?>

<?php include __DIR__ . '/../../includes/admin_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php include __DIR__ . '/../../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mt-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Manage Events</h1>
                <a href="add_event.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Event
                </a>
            </div>

            <!-- Search Form -->
            <form method="get" class="mb-3" style="max-width: 400px;">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search events..." value="<?php echo htmlspecialchars($search); ?>">
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
                            <th>Title</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($events)): ?>
                            <tr>
                                <td colspan="6" class="text-center">No events found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($events as $event): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                                    <td><?php echo htmlspecialchars($event['type']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($event['event_date'])); ?></td>
                                    <td><?php echo htmlspecialchars($event['location']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $event['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                            <?php echo ucfirst($event['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-success me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete(<?php echo $event['id']; ?>, '<?php echo htmlspecialchars($event['title']); ?>')">
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
                Are you sure you want to delete the event "<span id="eventTitle"></span>"?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" action="delete_event.php" method="POST" style="display: inline;">
                    <input type="hidden" name="event_id" id="eventId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(eventId, eventTitle) {
    document.getElementById('eventId').value = eventId;
    document.getElementById('eventTitle').textContent = eventTitle;
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