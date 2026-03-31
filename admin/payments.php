<?php
$activePage = "payments";
require_once "auth.php";
require_once "../config/db.php";

$search = $_GET['search'] ?? '';
$type   = $_GET['type'] ?? '';
$sort   = $_GET['sort'] ?? 'newest';

$sql = "
SELECT 
    p.id,
    u.username,
    p.amount,
    p.type,
    p.status,
    p.charge_id,
    p.created_at
FROM payments p
LEFT JOIN users u ON p.user_id = u.id
WHERE 1=1
";

/* ===== SEARCH ===== */
if(!empty($search)){
    $search = $conn->real_escape_string($search);
    $sql .= " AND (
        u.username LIKE '%$search%'
        OR p.id LIKE '%$search%'
        OR p.charge_id LIKE '%$search%'
    )";
}

/* ===== FILTER TYPE ===== */
if(!empty($type)){
    $type = $conn->real_escape_string($type);
    $sql .= " AND p.type = '$type'";
}

/* ===== SORT ===== */
switch($sort){
    case 'oldest':
        $sql .= " ORDER BY p.created_at ASC";
        break;
    case 'amount_high':
        $sql .= " ORDER BY p.amount DESC";
        break;
    case 'amount_low':
        $sql .= " ORDER BY p.amount ASC";
        break;
    default:
        $sql .= " ORDER BY p.created_at DESC";
}

$result = $conn->query($sql);
?>

<?php include "partials/header.php"; ?>
<?php include("partials/sidebar.php"); ?>

<div id="content-wrapper" class="d-flex flex-column">
<div id="content">

<div class="container-fluid mt-4">

<h1 class="h3 mb-4 font-weight-bold text-dark">
Payment Logs
</h1>

<div class="card shadow p-4">

<!-- FILTER -->
<form method="GET" class="form-row align-items-center mb-4">

    <!-- Search -->
    <div class="col-md-3 mb-2">
        <input type="text"
               name="search"
               class="form-control"
               placeholder="Search username / id..."
               value="<?= htmlspecialchars($search) ?>">
    </div>

    <div class="col-md-6"></div>

    <!-- TYPE -->
    <div class="col-md-2 mb-2">
        <select name="type"
                class="form-control"
                onchange="this.form.submit()">

            <option value="">All Type</option>
            <option value="wallet" <?= ($type=="wallet")?'selected':'' ?>>Wallet</option>
            <option value="package" <?= ($type=="package")?'selected':'' ?>>Package</option>

        </select>
    </div>

    <!-- SORT -->
    <div class="col-md-1 mb-2">
        <select name="sort"
                class="form-control"
                onchange="this.form.submit()">

            <option value="newest" <?= ($sort=='newest')?'selected':'' ?>>Newest</option>
            <option value="oldest" <?= ($sort=='oldest')?'selected':'' ?>>Oldest</option>
            <option value="amount_high" <?= ($sort=='amount_high')?'selected':'' ?>>High</option>
            <option value="amount_low" <?= ($sort=='amount_low')?'selected':'' ?>>Low</option>

        </select>
    </div>

</form>

<!-- TABLE -->
<div class="table-responsive">
<table class="table text-center">

<thead>
<tr>
<th>ID</th>
<th>User</th>
<th>Amount</th>
<th>Charge ID</th>
<th>Type</th>
<th>Status</th>
<th>Date</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()): ?>
<tr>

<td>#<?= $row['id'] ?></td>

<td><?= htmlspecialchars($row['username'] ?? '-') ?></td>

<td>
<b>฿<?= number_format($row['amount'],2) ?></b>
</td>
<td>
<code><?= htmlspecialchars($row['charge_id'] ?? '-') ?></code>
</td>
<td>
<?php if($row['type']=='wallet'): ?>
<span class="badge badge-primary px-3 py-2">WALLET</span>
<?php else: ?>
<span class="badge badge-success px-3 py-2">PACKAGE</span>
<?php endif; ?>
</td>

<td>
<?php if($row['status']=='successful'): ?>
<span class="badge badge-success">SUCCESS</span>
<?php elseif($row['status']=='pending'): ?>
<span class="badge badge-warning">PENDING</span>
<?php else: ?>
<span class="badge badge-danger">FAILED</span>
<?php endif; ?>
</td>

<td>
<?= date("d M Y H:i", strtotime($row['created_at'])) ?>
</td>

</tr>
<?php endwhile; ?>

</tbody>

</table>
</div>

</div>
</div>
</div>
</div>

<?php include "partials/footer.php"; ?>