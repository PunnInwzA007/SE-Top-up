<?php include "partials/header.php"; ?>

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
          <div class="se-ph se-ph-square"></div>
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
          <div class="se-ph se-ph-icon"></div>
          <div class="se-feature-text">เติมไวทันใจ</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="se-feature-card">
          <div class="se-ph se-ph-icon"></div>
          <div class="se-feature-text">ปลอดภัย 100%</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="se-feature-card">
          <div class="se-ph se-ph-icon"></div>
          <div class="se-feature-text">ประวัติครบทุกออเดอร์</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="se-feature-card">
          <div class="se-ph se-ph-icon"></div>
          <div class="se-feature-text">แต้มสะสมแลกรางวัล</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TRENDING GAMES -->
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
      <?php for($i=1;$i<=3;$i++): ?>
      <div class="col-md-4">
        <a class="se-card-link" href="topup.php">
          <div class="se-card">
            <div class="se-ph se-ph-wide"></div>
            <div class="se-card-name">Game Name</div>
          </div>
        </a>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- TRENDING PACKAGE -->
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
      <?php for($i=1;$i<=3;$i++): ?>
      <div class="col-md-4">
        <a class="se-card-link" href="topup.php">
          <div class="se-card">
            <div class="se-ph se-ph-wide"></div>
            <div class="se-card-name">Package Name</div>
          </div>
        </a>
      </div>
      <?php endfor; ?>
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
        <a class="se-card-link" href="topup.php">
          <div class="se-cat">
            <div class="se-cat-title">Mobile Games</div>
            <div class="se-ph se-ph-square"></div>
          </div>
        </a>
      </div>

      <div class="col-6 col-lg-3">
        <a class="se-card-link" href="topup.php">
          <div class="se-cat">
            <div class="se-cat-title">PC Games</div>
            <div class="se-ph se-ph-square"></div>
          </div>
        </a>
      </div>

      <div class="col-6 col-lg-3">
        <a class="se-card-link" href="topup.php">
          <div class="se-cat">
            <div class="se-cat-title">Subscriptions</div>
            <div class="se-ph se-ph-square"></div>
          </div>
        </a>
      </div>

      <div class="col-6 col-lg-3">
        <a class="se-card-link" href="topup.php">
          <div class="se-cat">
            <div class="se-cat-title">Gift Cards</div>
            <div class="se-ph se-ph-square"></div>
          </div>
        </a>
      </div>
    </div>

    <div class="se-cta">
      <div class="se-ph se-ph-cta"></div>

      <div class="se-cta-card se-cta-left">
        <div class="se-cta-tag">SE TOPUP</div>
        <div class="se-cta-title">เติมเกมวันนี้<br>รับแต้มสะสมทันที!</div>
         <div class="se-cta-desc">
           เติมเกมง่าย ปลอดภัย ตลอดวันตลอดคืน 24 ชั่วโมง<br>
           ทำการเติมจะได้รับ Reward เพื่อใช้แลกของลดราคา
        </div>
        <a class="se-cta-btn" href="topup.html">TOP-UP NOW</a>
        </div>
        <div class="se-cta-card se-cta-right">
          <div class="se-cta-tag">REWARD POINTS</div>
          <div class="se-cta-title">แลกแต้มสะสม<br>รับคูปองส่วนลด</div>
          <div class="se-cta-desc">
            สะสมแต้มจากทุกคำสั่งซื้อ<br>
            นำไปแลกส่วนลด แก้เกมถูกลง และรับโบนัสพิเศษได้เลย
          </div>
          <a class="se-cta-btn" href="points.html">REDEEM NOW</a>
        </div>
      </div>
  </div>
</section>
<script src="se-home.js"></script>
<?php include "partials/footer.php"; ?>