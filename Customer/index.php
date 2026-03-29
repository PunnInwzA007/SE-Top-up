<?php include "partials/header.php"; ?>
<?php require_once "../config/db.php";?>
<?php
// ==========================
// 🔥 TRENDING GAMES
// ==========================
$trendingGames = $conn->query("
  SELECT g.*, COUNT(o.id) as total_orders
  FROM games g
  LEFT JOIN packages p ON g.id = p.game_id
  LEFT JOIN orders o ON p.id = o.package_id AND o.status = 'success'
  WHERE g.status = 'ON'
  GROUP BY g.id
  ORDER BY total_orders DESC
  LIMIT 3
");

// ==========================
// 💎 TRENDING PACKAGE
// ==========================
$trendingPackages = $conn->query("
  SELECT p.*, g.name as game_name, g.image,
         COUNT(o.id) as total_orders
  FROM packages p
  JOIN games g ON p.game_id = g.id
  LEFT JOIN orders o ON p.id = o.package_id AND o.status = 'success'
  WHERE p.status = 'ON'
  GROUP BY p.id
  ORDER BY total_orders DESC
  LIMIT 3
");

// ==========================
// 🧩 CATEGORIES
// ==========================
$categories = $conn->query("
  SELECT category, COUNT(*) as total
  FROM games
  WHERE status = 'ON'
  GROUP BY category
");

function mapCategoryName($cat){
  return [
    'mobile' => 'Mobile Games',
    'pc' => 'PC Games',
    'gift' => 'Gift Cards',
    'sub' => 'Subscriptions'
  ][$cat] ?? $cat;
}
?>

<!-- HERO -->
<section class="se-hero">
  <div class="se-container">
    <div class="row align-items-center se-hero-row">
      <div class="col-lg-6">
        <div class="se-hero-left">
          <div class="se-hero-kicker">WELCOME TO SE TOPUP</div>
          <h1 class="se-hero-title">
            เติมเกมง่าย ปลอดภัย ภายในไม่กี่วินาที!
          </h1>
          <p class="se-hero-desc">
            เติม UC, Diamonds, VP และอีกมากมาย<br>
            สามารถเติมได้ 24 ชั่วโมง พร้อมโปรโมชั่นและแต้มสะสม
          </p>

          <div class="se-search" style="position:relative;">
            
            <form action="topup.php" method="GET">
              <input 
                type="text" 
                name="search" 
                id="searchInput"
                placeholder="ค้นหาเกม..." 
                autocomplete="off"
              />
              <button type="submit">Search</button>
            </form>

            <!-- ❗ แยกออกมานอก form -->
            <div id="searchResult" class="search-dropdown"></div>

          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="se-hero-right">
          <img class="se-ph se-ph-square" src="../admin/uploads/heropic.jpg"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="se-features">
  <div class="se-container">
    <div class="row g-3">
      <div class="col-6 col-lg-3">
        <div class="se-feature-card">
          <img class="se-hr se-hr-heroicon" src="../admin/uploads/fasttop.jpg" alt="Fast Top-up">
          <div class="se-feature-text">เติมไวทันใจ</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="se-feature-card">
          <img class="se-hr se-hr-heroicon" src="../admin/uploads/sectop.jpg" alt="Fast Top-up">
          <div class="se-feature-text">ปลอดภัย 100%</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="se-feature-card">
          <img class="se-hr se-hr-heroicon" src="../admin/uploads/histop.jpg" alt="Fast Top-up">
          <div class="se-feature-text">ประวัติครบทุกออเดอร์</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="se-feature-card">
          <img class="se-hr se-hr-heroicon" src="../admin/uploads/pointtop.jpg" alt="Fast Top-up">
          <div class="se-feature-text">แต้มสะสมแลกรางวัล</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========================== -->
<!-- 🔥 TRENDING GAMES -->
<!-- ========================== -->
<section class="se-section">
  <div class="se-container">
    <div class="se-section-head">
      <div>
        <div class="se-tag">Trending</div>
        <h2 class="se-h2">Trending Games</h2>
      </div>
      <a class="se-btn-view" href="topup.php">View</a>
    </div>

    <div class="row g-3 mt-2">
      <?php while($g = $trendingGames->fetch_assoc()): ?>
      <div class="col-md-4">
        <a class="se-card-link" href="product.php?game_id=<?= $g['id'] ?>">
          <div class="se-card">
            <img src="../admin/<?= $g['image'] ?>" class="se-ph se-ph-wide">
            <div class="se-card-name"><?= $g['name'] ?></div>
          </div>
        </a>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- ========================== -->
<!-- 💎 TRENDING PACKAGE -->
<!-- ========================== -->
<section class="se-panel">
  <div class="se-container">
    <div class="se-section-head">
      <div>
        <div class="se-tag">Trending</div>
        <h2 class="se-h2">Trending Package</h2>
      </div>
      <a class="se-btn-view" href="topup.php">View</a>
    </div>

    <div class="row g-3 mt-2">
      <?php while($p = $trendingPackages->fetch_assoc()): ?>
      <div class="col-md-4">
        <a class="se-card-link" href="product.php?game_id=<?= $p['game_id'] ?>">
          <div class="se-card">
            <img src="../admin/<?= $p['image'] ?>" class="se-ph se-ph-wide">
            <div class="se-card-name">
              <?= $p['game_name'] ?> - <?= $p['name'] ?>
            </div>
          </div>
        </a>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section class="se-section se-section-center">
  <div class="se-container">
    <div class="se-tag">Categories</div>
    <h2 class="se-h2">Top Categories</h2>

    <div class="row g-3 mt-3">
      <div class="col-6 col-lg-3">
        <a class="se-card-link" href="topup.php?category=mobile">
          <div class="se-cat">
            <div class="se-cat-title">Mobile Games</div>
            <img src="../admin/uploads/mobilegames.jpg" class="se-ph se-ph-square">
          </div>
        </a>
      </div>

      <div class="col-6 col-lg-3">
        <a class="se-card-link" href="topup.php?category=pc">
          <div class="se-cat">
            <div class="se-cat-title">PC Games</div>
            <img src="../admin/uploads/pcgames.jpg" class="se-ph se-ph-square">
          </div>
        </a>
      </div>

      <div class="col-6 col-lg-3">
        <a class="se-card-link" href="topup.php?category=sub">
          <div class="se-cat">
            <div class="se-cat-title">Subscriptions</div>
            <img src="../admin/uploads/subscriptions.jpg" class="se-ph se-ph-square">
          </div>
        </a>
      </div>

      <div class="col-6 col-lg-3">
        <a class="se-card-link" href="topup.php?category=gift">
          <div class="se-cat">
            <div class="se-cat-title">Gift Cards</div>
              <img src="../admin/uploads/giftcard.jpg" class="se-ph se-ph-square">
            </div>
        </a>
      </div>
    </div>

    <div class="se-cta">
      <div class="se-ph se-ph-cta"><img src="../admin/uploads/BackG.jpg"></div>

      <div class="se-cta-card se-cta-left">
        <div class="se-cta-tag">SE TOPUP</div>
        <div class="se-cta-title">เติมเกมวันนี้<br>รับแต้มสะสมทันที!</div>
         <div class="se-cta-desc">
           เติมเกมง่าย ปลอดภัย ตลอดวันตลอดคืน 24 ชั่วโมง<br>
           ทำการเติมจะได้รับ Reward เพื่อใช้แลกของลดราคา
        </div>
        <a class="se-cta-btn" href="topup.php">TOP-UP NOW</a>
        </div>
        <div class="se-cta-card se-cta-right">
          <div class="se-cta-tag">REWARD POINTS</div>
          <div class="se-cta-title">แลกแต้มสะสม<br>รับคูปองส่วนลด</div>
          <div class="se-cta-desc">
            สะสมแต้มจากทุกคำสั่งซื้อ<br>
            นำไปแลกส่วนลด แก้เกมถูกลง และรับโบนัสพิเศษได้เลย
          </div>
          <a class="se-cta-btn" href="points.php">REDEEM NOW</a>
        </div>
      </div>
  </div>
</section>
<script src="se-home.js"></script>
<?php include "partials/footer.php"; ?>