<?php
$activePage = "games";
require_once "auth.php";
require_once "../config/db.php";
$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM games WHERE 1=1";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND (
        name LIKE '%$search%'
        OR status LIKE '%$search%'
    )";
}

$sql .= " ORDER BY id DESC";

$result = $conn->query($sql);
?>
  <?php include "partials/header.php"; ?>
  <?php include("partials/sidebar.php"); ?>
  <!-- ================= Content Wrapper ================= -->
  <div id="content-wrapper" class="d-flex flex-column">

    <div id="content">

      <!-- ================= Page Content ================= -->
      <div class="container-fluid mt-4">
        <?php if(isset($_GET['success'])): ?>
          <div class="alert alert-success">
            ลบเกมสำเร็จ
          </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
          <div class="alert alert-danger">
            เกิดข้อผิดพลาด
          </div>
        <?php endif; ?>

        <!-- Title -->
        <h1 class="h3 mb-4 font-weight-bold text-dark">
          Games
        </h1>

        <!-- Card -->
          <div class="card shadow p-4">

              <form method="GET" class="d-flex justify-content-between mb-4">

                  <input type="text"
                        name="search"
                        class="form-control w-50"
                        placeholder="Search..."
                        value="<?= htmlspecialchars($search) ?>">

                  <button class="btn btn-primary px-4"
                          data-toggle="modal"
                          data-target="#addGameModal"
                          type="button">
                      + Add Game
                  </button>

              </form>
                          <!-- ================= Games Table ================= -->
          <table class="table text-center">

            <thead>
              <tr>
                <th></th>
                <th>ประเภทสินค้า</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
              <tr>

                <!-- Image -->
                <td>
                  <img src="<?= htmlspecialchars($row["image"]) ?>"
                       width="45"
                       style="border-radius:10px;"
                       onerror="this.src='assets/images/default.png';">
                </td>

                <!-- Name -->
                <td><?= $row["name"] ?></td>

                <!-- Status -->
                <td>
                  <?php if($row["status"]=="ON"): ?>
                    <span class="badge badge-success px-5 py-2">ON</span>
                  <?php else: ?>
                    <span class="badge badge-danger px-5 py-2">OFF</span>
                  <?php endif; ?>
                </td>

                <!-- Actions -->
                <td>
                  <!-- Edit -->
                  <button class="btn btn-primary btn-sm px-3"
                          data-toggle="modal"
                          data-target="#editGameModal"
                          data-id="<?= $row['id'] ?>"
                          data-name="<?= htmlspecialchars($row['name']) ?>"
                          data-status="<?= $row['status'] ?>">
                    Edit
                  </button>

                  <!-- Delete -->
                  <button class="btn btn-danger btn-sm px-3"
                          data-toggle="modal"
                          data-target="#deleteGameModal"
                          data-id="<?= $row['id'] ?>"
                          data-name="<?= htmlspecialchars($row['name']) ?>">
                    Delete
                  </button>
                </td>

              </tr>
            <?php endwhile; ?>
            </tbody>
          </table>
          </div>
          <!-- ============== End Table ============== -->

        </div>
        <!-- ============== End Card ============== -->

      </div>
      <!-- ============== End Container Fluid ============== -->

    </div>
    <!-- ============== End Content ============== -->

  </div>
  <!-- ============== End Content Wrapper ============== -->

</div>
<!-- ============== End Wrapper ============== -->

<?php include "partials/footer.php"; ?>