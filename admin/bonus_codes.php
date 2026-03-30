<?php
$activePage = "bonus_codes";
require_once "auth.php";
require_once "../config/db.php";

$search = $_GET['search'] ?? '';

$sql = "
SELECT bc.*, p.name AS package_name
FROM bonus_codes bc
LEFT JOIN packages p ON bc.package_id = p.id
WHERE 1=1
";

if(!empty($search)){
    $search = $conn->real_escape_string($search);
    $sql .= " AND (
        bc.code LIKE '%$search%'
        OR p.name LIKE '%$search%'
    )";
}

$sql .= " ORDER BY bc.id DESC";

$result = $conn->query($sql);

// สำหรับ dropdown
$packages = $conn->query("SELECT id,name FROM packages");
?>

<?php include "partials/header.php"; ?>
<?php include("partials/sidebar.php"); ?>

<div id="content-wrapper" class="d-flex flex-column">
<div id="content">

<div class="container-fluid mt-4">

<h1 class="h3 mb-4 font-weight-bold text-dark">
Bonus Codes
</h1>

<div class="card shadow p-4">

<!-- 🔍 SEARCH + ADD -->
<form method="GET" class="d-flex justify-content-between mb-4">

<input type="text"
       name="search"
       class="form-control w-50"
       placeholder="Search..."
       value="<?= htmlspecialchars($search) ?>">

<button class="btn btn-primary px-4"
        data-toggle="modal"
        data-target="#addBonusModal"
        type="button">
    + Add Code
</button>

</form>

<!-- 📊 TABLE -->
<table class="table text-center">

<thead>
<tr>
<th>Code</th>
<th>Package</th>
<th>Status</th>
<th>Used By</th>
<th>Used At</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr>

<td><?= $row['code'] ?></td>

<td><?= $row['package_name'] ?? '-' ?></td>

<td>
<?php if($row['status'] == 'unused'): ?>
<span class="badge badge-success px-3 py-2">UNUSED</span>
<?php else: ?>
<span class="badge badge-danger px-3 py-2">USED</span>
<?php endif; ?>
</td>

<td><?= $row['user_id'] ?? '-' ?></td>

<td>
<?= $row['used_at'] ? date("d M Y H:i", strtotime($row['used_at'])) : '-' ?>
</td>

<td>
<a href="delete_bonus.php?id=<?= $row['id'] ?>"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Delete this code?')">
Delete
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