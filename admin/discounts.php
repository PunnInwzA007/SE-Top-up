<?php
$activePage = "discounts";
require_once "auth.php";
require_once "../config/db.php";

$search = $_GET['search'] ?? '';

$sql = "
SELECT * FROM discount_codes
WHERE status = 'ACTIVE'
";

if(!empty($search)){
    $search = $conn->real_escape_string($search);
    $sql .= " AND code LIKE '%$search%'";
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
Discount Codes
</h1>

<div class="card shadow p-4">
<?php if(isset($_GET['success'])): ?>
  <div class="alert alert-success">
    ลบ Discount Code เรียบร้อยแล้ว
  </div>
<?php endif; ?>

<?php if(isset($_GET['error'])): ?>
  <div class="alert alert-danger">
    เกิดข้อผิดพลาด
  </div>
<?php endif; ?>
<form method="GET" class="d-flex justify-content-between mb-4">

<input type="text"
       name="search"
       class="form-control w-50"
       placeholder="Search..."
       value="<?= htmlspecialchars($search) ?>">

<button class="btn btn-primary px-4"
        data-toggle="modal"
        data-target="#addDiscountModal"
        type="button">
    + Add Code
</button>

</form>

<table class="table text-center">

<thead>
<tr>
<th>Code</th>
<th>Discount</th>
<th>Min Price</th>
<th>Usage</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr>

<td><?= $row['code'] ?></td>

<td><?= $row['discount_amount'] ?> ฿</td>

<td><?= $row['min_price'] ?> ฿</td>

<td>
<?= $row['used_count'] ?>/<?= $row['usage_limit'] ?>
</td>

<td>
<?php if($row['status'] == 'ACTIVE'): ?>
<span class="badge badge-success">ACTIVE</span>
<?php else: ?>
<span class="badge badge-danger">DISABLED</span>
<?php endif; ?>
</td>

<td>
<a href="delete_discount.php?id=<?= $row['id'] ?>"
   class="btn btn-sm btn-danger">
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