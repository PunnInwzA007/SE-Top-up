<?php
$activePage = "rewards";
require_once "auth.php";
require_once "../config/db.php";

$search = $_GET['search'] ?? '';

$sql = "
SELECT rewards.*, packages.name AS package_name
FROM rewards
LEFT JOIN packages ON rewards.package_id = packages.id
WHERE 1=1
";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND rewards.name LIKE '%$search%'";
}

$sql .= " ORDER BY rewards.id DESC";

$result = $conn->query($sql);
?>

<?php include "partials/header.php"; ?>
<?php include("partials/sidebar.php"); ?>

<div id="content-wrapper" class="d-flex flex-column">
<div id="content">

<div class="container-fluid mt-4">

<h1 class="h3 mb-4 font-weight-bold text-dark">
Rewards
</h1>

<div class="card shadow p-4">

<form method="GET" class="d-flex justify-content-between mb-4">

<input type="text"
       name="search"
       class="form-control w-50"
       placeholder="Search..."
       value="<?= htmlspecialchars($search) ?>">

<button class="btn btn-primary px-4"
        data-toggle="modal"
        data-target="#addRewardModal"
        type="button">
    + Add Reward
</button>

</form>

<table class="table text-center">

<thead>
<tr>
<th>Name</th>
<th>Type</th>
<th>Package</th>
<th>Amount</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr>

<td><?= htmlspecialchars($row['name']) ?></td>

<td><?= $row['type'] ?></td>

<td><?= $row['package_name'] ?? 'No Package' ?></td>
<td><?= $row['amount'] ?? '-' ?></td>

<td>
<button class="btn btn-sm btn-primary"
        data-toggle="modal"
        data-target="#editRewardModal"
        data-id="<?= $row['id'] ?>"
        data-name="<?= htmlspecialchars($row['name']) ?>"
        data-type="<?= $row['type'] ?>"
        data-package="<?= $row['package_name'] ?? 'No Package' ?>
        data-id="<?= $row['id'] ?>"
        data-name="<?= htmlspecialchars($row['name']) ?>"
        data-type="<?= $row['type'] ?>">
Edit
</button>

<a href="delete_reward.php?id=<?= $row['id'] ?>"
   class="btn btn-sm btn-danger"
   onclick="return confirm('ลบ reward นี้?')">
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