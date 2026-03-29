<?php 
require_once "../config/db.php";
require_once "auth.php"; 

$user_id = $_SESSION['user_id'];

/* ===== POINT ===== */
$stmt = $conn->prepare("SELECT points FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result()->fetch_assoc();
$points = $result['points'] ?? 0;

/* ===== REWARDS ===== */
$rewardResult = $conn->query("SELECT * FROM rewards ORDER BY point_cost ASC");

/* map type -> category (ใช้กับ filter เดิม) */
function mapCategory($type){
  return match($type){
    'balance' => 'coupon',
    'code' => 'bonus',
    'giftcard' => 'gift',
    default => 'other'
  };
}
/* ===== HISTORY ===== */
$stmt = $conn->prepare("
  SELECT ur.*, r.name, r.point_cost
  FROM user_rewards ur
  JOIN rewards r ON ur.reward_id = r.id
  WHERE ur.user_id = ?
  ORDER BY ur.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$historyResult = $stmt->get_result();
?>
<?php include "partials/header.php"; ?>
<!-- PAGE HERO -->
<section class="se-page-hero">
  <div class="se-page-hero-inner">
    <h2 class="se-page-title">Points</h2>
    <p class="se-page-breadcrumb">Home > Points</p>
  </div>
</section>

<section class="se-section">
  <div class="se-container">

    <!-- POINT SUMMARY -->
    <div class="se-point-box mb-5">
      <!-- กล่องแต้ม -->
      <div class="se-point-left">
        <h2><?= $points ?></h2>
        <span>Points</span>
      </div>

      <!-- ฝั่งขวา -->
      <div class="se-point-right">
        ทุกการเติม 10 บาท = 1 Point<br>
        แต้มสามารถใช้แลกคูปองและโบนัสได้
      </div>

    </div>

    <!-- FILTER -->
    <div class="se-filter mb-4">
      <button class="se-filter-btn active" data-category="coupon">คูปองส่วนลด</button>
      <button class="se-filter-btn" data-category="bonus">โบนัสเติมฟรี</button>
      <button class="se-filter-btn" data-category="gift">Gift Cards</button>
    </div>

    <!-- GRID -->
    <div class="row g-4 se-grid">

      <?php if($rewardResult->num_rows > 0): ?>
        <?php while($r = $rewardResult->fetch_assoc()): ?>
          <?php $category = mapCategory($r['type']); ?>

            <div class="col-lg-3 col-md-4 col-6 se-card-item"
                data-category="<?= $category ?>">

              <!-- ✅ กดได้ทุกอัน -->
              <a href="redeem.php?id=<?= $r['id'] ?>" class="se-card-topup">

                <img src="../admin/uploads/<?= htmlspecialchars($r['image']) ?>">

                <div class="se-card-name">
                  <?= htmlspecialchars($r['name']) ?>
                </div>

                <div style="text-align:center;margin-top:6px;">
                  <span class="se-point-badge">
                    <?= number_format($r['point_cost']) ?> Points
                  </span>
                </div>

              </a>

            </div>

        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align:center;">ยังไม่มี reward</p>
      <?php endif; ?>

    </div>

    <div class="se-pagination mt-5 text-center"></div>

    <!-- HISTORY -->
    <div class="mt-5">
      <h3 style="font-weight:900;">ประวัติการแลกแต้ม</h3>

      <div class="se-card mt-3 p-3">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>วันที่</th>
                <th>รางวัล</th>
                <th>แต้มที่ใช้</th>
                <th>สถานะ</th>
              </tr>
            </thead>
            <tbody>
              <?php if($historyResult->num_rows > 0): ?>
                
                <?php while($h = $historyResult->fetch_assoc()): ?>
                  <tr>
                    <!-- วันที่ -->
                    <td><?= date("d/m/Y", strtotime($h['created_at'])) ?></td>

                    <!-- ชื่อ reward -->
                    <td><?= htmlspecialchars($h['name']) ?></td>

                    <!-- แต้ม -->
                    <td>-<?= number_format($h['point_cost']) ?></td>

                    <!-- สถานะ -->
                    <td>
                      <span class="badge bg-<?= $h['status']=='success'?'success':'danger' ?>">
                        <?= $h['status']=='success'?'สำเร็จ':'ยกเลิก' ?>
                      </span>
                    </td>
                  </tr>
                <?php endwhile; ?>

              <?php else: ?>
                <tr>
                  <td colspan="4" style="text-align:center;">ยังไม่มีประวัติ</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>

  </div>
</section>

<?php include "partials/footer.php"; ?>
