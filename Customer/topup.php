<?php
require_once "../config/db.php";

$result = $conn->query("SELECT * FROM games");
$games = [];

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $games[] = $row;
  }
}
?>
<?php include "partials/header.php"; ?>
<!-- ===== PAGE HERO ===== -->
<section class="se-page-hero">
  <div class="se-page-hero-inner">
    <h2 class="se-page-title">TOP UP</h2>
    <p class="se-page-breadcrumb">Home > Top-Up</p>
  </div>
</section>

<section class="se-section">
  <div class="se-container">

    <!-- CATEGORIES -->
    <div class="se-filter mb-4">
      <button class="se-filter-btn active" data-category="game">ALL</button>
      <button class="se-filter-btn" data-category="mobile">MOBILE</button>
      <button class="se-filter-btn" data-category="pc">PC</button>
      <button class="se-filter-btn" data-category="gift">GIFT</button>
      <button class="se-filter-btn" data-category="sub">SUBSCRIPTIONS</button>
    </div>

    <!-- GRID -->
    <div class="row g-4 se-grid">

      <?php foreach($games as $game): ?>
        <div class="col-lg-3 col-md-4 col-6 se-card-item"
            data-category="game <?= $game['category'] ?>">

          <a href="product.php?game_id=<?= $game['id'] ?>" class="se-card-topup">

            <img src="../admin/uploads/<?= basename($game['image']) ?>">

            <div class="se-card-name">
              <?= htmlspecialchars($game['name']) ?>
            </div>

          </a>
        </div>
      <?php endforeach; ?>

    </div>

    <!-- PAGINATION -->
    <div class="se-pagination mt-5 text-center"></div>

  </div>
</section>

<?php include "partials/footer.php"; ?>