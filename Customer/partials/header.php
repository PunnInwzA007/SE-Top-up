<?php
if(session_status() === PHP_SESSION_NONE){
  session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<?php
require_once __DIR__ . '/../../config/db.php';
$balance = 0;
if(isset($_SESSION['user_id'])){
  $uid = $_SESSION['user_id'];

  $stmt = $conn->prepare("SELECT balance FROM users WHERE id = ?");
  $stmt->bind_param("i", $uid);
  $stmt->execute();
  $result = $stmt->get_result();

  if($row = $result->fetch_assoc()){
    $balance = $row['balance'];
  }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SE Topup - ร้านเติมเกมออนไลน์ ROV PUBG Free Fire Genshin Impact ราคาถูก เติมไว ปลอดภัย</title>
  <link rel="icon" type="image/png" href="/admin/assets/images/LogoBlue.png">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/animate.css">

  <!-- Custom -->
  <link rel="stylesheet" href="assets/css/se-home.css">
</head>
<body>

<!-- preloader -->
<div id="js-preloader" class="js-preloader">
  <div class="preloader-inner">
    <span class="dot"></span>
    <div class="dots"><span></span><span></span><span></span></div>
  </div>
</div>

<header class="se-header">
  <div class="se-container">
    <div class="se-topbar">
      <a class="se-brand" href="index.php">
        <span class="se-logo-box">
          <img src="assets/image/Logo.png" width="50" height="50" alt="SE TopUp Logo">
        </span>
        <span class="se-brand-text">SE Top-Up</span>
      </a>

      <nav class="se-nav">
        <a class="se-nav-item <?= $currentPage=='index.php'?'is-active':'' ?>" href="index.php">Home</a>
        <a class="se-nav-item <?= $currentPage=='topup.php'?'is-active':'' ?>" href="topup.php">Top-up</a>
        <a class="se-nav-item <?= $currentPage=='history.php'?'is-active':'' ?>" href="history.php">History</a>
        <a class="se-nav-item <?= $currentPage=='points.php'?'is-active':'' ?>" href="points.php">Points</a>

        <?php if(isset($_SESSION['user_id'])): ?>
          <div class="dropdown">
            <a class="se-nav-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              👤 <?= htmlspecialchars($_SESSION['username']) ?>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">

              <!-- 💰 BALANCE -->
              <li class="px-3 py-2">
                 เงินคงเหลือ: <strong><?= number_format($balance, 2) ?> บาท</strong>
              </li>
              <!-- 🎁 REDEEM -->
              <li><hr class="dropdown-divider"></li>

              <li>
                <a class="dropdown-item" href="profile.php">Profile</a>
              </li>

              <li>
                <a class="dropdown-item" href="history.php">เติมเงิน</a>
              </li>

              <li>
                <a class="dropdown-item" href="coderedeem.php">Redeem</a>
              </li>

              <li><hr class="dropdown-divider"></li>

              <li>
                <a class="dropdown-item text-danger" href="logout.php">Logout</a>
              </li>

            </ul>
          </div>

          <?php else: ?>
          <a class="se-nav-item se-nav-signin" href="login.php">SIGN IN</a>
          <?php endif; ?>
      </nav>
    </div>
  </div>
</header>