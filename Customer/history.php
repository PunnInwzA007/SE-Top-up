<?php require_once "auth.php"; ?>
<?php require_once "../config/db.php"; ?>
<?php include "partials/header.php"; ?>
<?php

$user_id = $_SESSION['user_id'];

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? 'all';
$sort = $_GET['sort'] ?? 'date_desc';
$sql = "
SELECT 
orders.id,
orders.created_at,
orders.game_uid,
orders.status,
orders.price,
orders.package_name,
orders.game_name
FROM orders
WHERE orders.user_id = $user_id
";
if(!empty($search)){

$search = $conn->real_escape_string($search);

$sql .= " AND (
orders.game_name LIKE '%$search%'
OR orders.package_name LIKE '%$search%'
OR orders.game_uid LIKE '%$search%'
OR orders.price LIKE '%$search%'
OR orders.id LIKE '%$search%'
)";
}
if($category != "all"){
$category = (int)$category;
$sql .= " AND games.id = $category";
}
switch($sort){

case "date_asc":
$sql .= " ORDER BY orders.created_at ASC";
break;

case "price_desc":
$sql .= " ORDER BY orders.price DESC";
break;

case "price_asc":
$sql .= " ORDER BY orders.price ASC";
break;

default:
$sql .= " ORDER BY orders.created_at DESC";

}

$result = $conn->query($sql);
$games = $conn->query("
SELECT id,name 
FROM games 
WHERE status='ON'
ORDER BY name ASC
");
?>
<!-- PAGE HERO -->
<section class="se-page-hero">
  <div class="se-page-hero-inner">
    <h2 class="se-page-title">History</h2>
    <p class="se-page-breadcrumb">Home > History</p>
  </div>
</section>

<section class="se-section">
  <div class="se-container">

    <div class="se-card p-4">

      <!-- TOOLS -->
      <form method="GET" class="d-flex justify-content-between flex-wrap mb-4 gap-3">

        <input type="text"
          name="search"
          class="form-control"
          style="max-width:250px"
          placeholder="search"
          value="<?= htmlspecialchars($search) ?>">

        <div class="d-flex gap-2">
          <select name="category" class="form-select" onchange="this.form.submit()">

            <option value="all">Category</option>

            <?php while($g = $games->fetch_assoc()): ?>

            <option value="<?= $g['id'] ?>"
            <?= $category == $g['id'] ? 'selected' : '' ?>>

            <?= htmlspecialchars($g['name']) ?>

            </option>

            <?php endwhile; ?>

            </select>

          <select name="sort" class="form-select" onchange="this.form.submit()">
            <option value="date_desc" <?= $sort=="date_desc"?'selected':'' ?>>ล่าสุด</option>
            <option value="date_asc" <?= $sort=="date_asc"?'selected':'' ?>>เก่าสุด</option>
            <option value="price_desc" <?= $sort=="price_desc"?'selected':'' ?>>ราคา สูง → ต่ำ</option>
            <option value="price_asc" <?= $sort=="price_asc"?'selected':'' ?>>ราคา ต่ำ → สูง</option>
          </select>
        </div>
        
      </form>

      <!-- TABLE -->
      <div class="table-responsive">
        <table class="table text-center">
          <thead>
          <tr>
          <th>วันที่</th>
          <th>Order</th>
          <th>Game</th>
          <th>UID</th>
          <th>Package</th>
          <th>ราคา</th>
          <th>Status</th>
          </tr>
          </thead>

        <tbody>

          <?php while($row = $result->fetch_assoc()): ?>
            <tr>

            <td>
            <?= date("d M Y H:i",strtotime($row["created_at"])) ?>
            </td>

            <td>
            #<?= $row["id"] ?>
            </td>

            <td>
            <?= $row["game_name"] ?>
            </td>

            <td>
            <?= htmlspecialchars($row["game_uid"]) ?>
            </td>

            <td>
            <?= $row["package_name"] ?>
            </td>

            <td>
            ฿<?= number_format($row["price"],2) ?>
            </td>

            <td>

            <?php if($row["status"]=="success"): ?>
            <span class="badge bg-success px-3 py-2">SUCCESS</span>

            <?php elseif($row["status"]=="pending"): ?>
            <span class="badge bg-warning px-3 py-2">PENDING</span>

            <?php else: ?>
            <span class="badge bg-danger px-3 py-2">CANCEL</span>
            <?php endif; ?>

            </td>

            </tr>
          <?php endwhile; ?>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="se-pagination mt-4 text-center"></div>

      </div>

  </div>
</section>

<?php include "partials/footer.php"; ?>