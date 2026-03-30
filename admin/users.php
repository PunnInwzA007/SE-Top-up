<?php
$activePage = "users";
require_once "auth.php";
require_once "../config/db.php";

$search = $_GET['search'] ?? '';

$sql = "
SELECT id, username, email, status, created_at
FROM users
WHERE 1=1
";

if(!empty($search)){
    $search = $conn->real_escape_string($search);
    $sql .= " AND (
        username LIKE '%$search%'
        OR email LIKE '%$search%'
    )";
}

$sql .= " ORDER BY id DESC";

$result = $conn->query($sql);
?>

<?php include "partials/header.php"; ?>
<?php include("partials/sidebar.php"); ?>

<div id="content-wrapper" class="d-flex flex-column">
<div id="content">

<div class="container-fluid mt-4">

<h1 class="h3 mb-4 font-weight-bold text-dark">
Users Management
</h1>

<div class="card shadow p-4">

<!-- SEARCH -->
<form method="GET" class="d-flex justify-content-between mb-4">

<input type="text"
       name="search"
       class="form-control w-50"
       placeholder="Search username/email..."
       value="<?= htmlspecialchars($search) ?>">

</form>

<!-- TABLE -->
<table class="table text-center">

<thead>
<tr>
<th>ID</th>
<th>Username</th>
<th>Email</th>
<th>Status</th>
<th>Created</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr>

<td><?= $row['id'] ?></td>

<td><?= htmlspecialchars($row['username']) ?></td>

<td><?= htmlspecialchars($row['email']) ?></td>

<td>
<?php if($row['status'] == 'active'): ?>
<span class="badge badge-success">ACTIVE</span>
<?php else: ?>
<span class="badge badge-danger">BANNED</span>
<?php endif; ?>
</td>

<td>
<?= date("d M Y", strtotime($row['created_at'])) ?>
</td>

<td>

<button class="btn btn-sm btn-primary"
        data-toggle="modal"
        data-target="#editUserModal"
        data-id="<?= $row['id'] ?>"
        data-username="<?= htmlspecialchars($row['username']) ?>"
        data-email="<?= htmlspecialchars($row['email']) ?>"
        data-status="<?= $row['status'] ?>">
Edit
</button>

<a href="delete_user.php?id=<?= $row['id'] ?>"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Disable user?')">
Disable
</a>

</td>

</tr>
<?php endwhile; ?>
</tbody>

</table>

</div>
</div>
</div>
</div>

<?php include "partials/footer.php"; ?>