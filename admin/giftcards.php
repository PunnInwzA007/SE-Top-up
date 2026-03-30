<?php
$activePage = "giftcards";
require_once "auth.php";
require_once "../config/db.php";

$search = $_GET['search'] ?? '';

$sql = "
SELECT gs.*, r.name AS reward_name
FROM giftcard_stock gs
LEFT JOIN rewards r ON gs.reward_id = r.id
WHERE 1=1
";

if(!empty($search)){
    $search = $conn->real_escape_string($search);
    $sql .= " AND (
        gs.code LIKE '%$search%'
        OR r.name LIKE '%$search%'
    )";
}

$sql .= " ORDER BY gs.id DESC";

$result = $conn->query($sql);
?>

<?php include "partials/header.php"; ?>
<?php include("partials/sidebar.php"); ?>

<div id="content-wrapper" class="d-flex flex-column">
<div id="content">

<div class="container-fluid mt-4">

<h1 class="h3 mb-4 font-weight-bold text-dark">
Giftcard Stock
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
        data-target="#addGiftcardModal"
        type="button">
    + Add Giftcard
</button>

</form>

<!-- 📊 TABLE -->
<table class="table text-center">

<thead>
<tr>
<th>ID</th>
<th>Reward</th>
<th>Code</th>
<th>Status</th>
<th>Used By</th>
<th>Used At</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr>

<td><?= $row['id'] ?></td>

<td><?= htmlspecialchars($row['reward_name'] ?? '-') ?></td>

<td style="font-weight:bold;">
<?= htmlspecialchars($row['code']) ?>
</td>

<td>
<?php if($row['status'] == 'available'): ?>
<span class="badge badge-success px-3 py-2">Available</span>
<?php else: ?>
<span class="badge badge-danger px-3 py-2">Used</span>
<?php endif; ?>
</td>

<td><?= $row['used_by'] ?? '-' ?></td>

<td>
<?= $row['used_at'] ? date("d M Y H:i", strtotime($row['used_at'])) : '-' ?>
</td>

<td>
<a href="delete_giftcard.php?id=<?= $row['id'] ?>"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Delete this giftcard?')">
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