<?php 
require_once "auth.php";
require_once "../config/db.php";
$activePage = "orders";

$search   = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$sort     = $_GET['sort'] ?? 'newest';

$sql = "
SELECT 
    orders.id,
    users.username AS customer_name,
    orders.game_uid,
    orders.status,
    orders.created_at,
    orders.package_name AS package_name,
    orders.price,
    orders.game_name AS game_name
FROM orders
JOIN users ON orders.user_id = users.id
LEFT JOIN packages ON orders.package_id = packages.id
LEFT JOIN games ON packages.game_id = games.id
WHERE 1=1
";

/* ===== Search ===== */
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND (
        orders.id LIKE '%$search%'
        OR users.username LIKE '%$search%'
        OR packages.name LIKE '%$search%'
        OR games.name LIKE '%$search%'
    )";
}

/* ===== Category Filter ===== */
if (!empty($category)) {
    $category = intval($category);
    $sql .= " AND games.id = $category";
}

/* ===== Sorting ===== */
switch ($sort) {
    case 'oldest':
        $sql .= " ORDER BY orders.created_at ASC";
        break;
    case 'price_high':
        $sql .= " ORDER BY packages.price DESC";
        break;
    case 'price_low':
        $sql .= " ORDER BY packages.price ASC";
        break;
    default:
        $sql .= " ORDER BY orders.created_at DESC";
}

$result = $conn->query($sql);
?>

  <?php include "partials/header.php"; ?>
  <?php include("partials/sidebar.php"); ?>

  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">

    <div id="content">

      <!-- Page Content -->
      <div class="container-fluid mt-4">

        <!-- Title -->
        <h1 class="h3 mb-4 font-weight-bold text-dark">
          Orders
        </h1>

        <!-- Orders Card -->
        <div class="card shadow p-4">

          <!-- Top Controls -->
          <div class="row mb-4">
              <div class="col-12">

                  <form method="GET" class="form-row align-items-center">

                      <!-- Search -->
                      <div class="col-md-3 mb-2">
                          <input type="text"
                                name="search"
                                class="form-control"
                                placeholder="Search..."
                                value="<?= htmlspecialchars($search) ?>">
                      </div>
                      
                      <div class="col-md-7"></div>
                      <!-- Category -->
                      <div class="col-md-1 mb-2">
                          <select name="category"
                                  class="form-control"
                                  onchange="this.form.submit()">

                              <option value="">All Games</option>

                              <?php
                              $gamesList = $conn->query("SELECT * FROM games");
                              while ($g = $gamesList->fetch_assoc()):
                              ?>
                                  <option value="<?= $g['id'] ?>"
                                      <?= ($category == $g['id']) ? 'selected' : '' ?>>
                                      <?= $g['name'] ?>
                                  </option>
                              <?php endwhile; ?>
                          </select>
                      </div>

                      <!-- Sort -->
                      <div class="col-md-1 mb-2">
                          <select name="sort"
                                  class="form-control"
                                  onchange="this.form.submit()">

                              <option value="newest" <?= ($sort == 'newest') ? 'selected' : '' ?>>Newest</option>
                              <option value="oldest" <?= ($sort == 'oldest') ? 'selected' : '' ?>>Oldest</option>
                              <option value="price_high" <?= ($sort == 'price_high') ? 'selected' : '' ?>>Price High</option>
                              <option value="price_low" <?= ($sort == 'price_low') ? 'selected' : '' ?>>Price Low</option>

                          </select>
                      </div>

                  </form>

              </div>
          </div>

            <!-- Orders Table -->
          <div class="table-responsive">
            <table class="table text-center">

              <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Game</th>
                    <th>Package</th>
                    <th>UID</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th></th>
                </tr>
              </thead>

                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>

                            <?php
                            $statusClass = [
                                'pending' => 'warning',
                                'success' => 'success',
                                'cancel'  => 'danger'
                            ];

                            $badgeColor = $statusClass[strtolower($row['status'])] ?? 'secondary';
                            ?>

                            <tr>
                                <td>#<?= $row['id'] ?></td>

                                <td>
                                    <?= htmlspecialchars($row['customer_name']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['game_name']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['package_name']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['game_uid']) ?>
                                </td>

                                <td><?= number_format($row['price'], 2) ?></td>

                                <td>
                                <?= date("d M Y H:i", strtotime($row['created_at'])) ?>
                                </td>

                                <td>
                                    <span class="badge badge-<?= $badgeColor ?> px-3 py-2 text-capitalize">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>

                                <td>
                                    <button class="btn btn-sm btn-primary"
                                            data-toggle="modal"
                                            data-target="#statusModal"
                                            data-id="<?= $row['id'] ?>"
                                            data-status="<?= $row['status'] ?>">
                                        View
                                    </button>
                                </td>
                            </tr>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No orders found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
          </div>
        </div>
      </div>

    </div>

<?php include "partials/footer.php"; ?>
