<!-- Manage Player UID Modal -->
<div class="modal fade" id="uidModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Manage Player UID</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <!-- Add UID -->
        <form method="POST" action="add_uid.php" class="mb-4">

          <div class="row g-2">

            <div class="col-md-5">
              <select name="game_id" class="form-select" required>
                <option value="">Select Game</option>

                <?php
                require_once "../config/db.php";

                $games = $conn->query("SELECT id,name FROM games WHERE status='ON'");

                while($g = $games->fetch_assoc()):
                ?>

                <option value="<?= $g['id'] ?>">
                  <?= htmlspecialchars($g['name']) ?>
                </option>

                <?php endwhile; ?>

              </select>
            </div>

            <div class="col-md-5">
              <input
                type="text"
                name="uid"
                class="form-control"
                placeholder="Enter Player UID"
                required
              >
            </div>

            <div class="col-md-2">
              <button class="se-btn-green w-100">
                Add
              </button>
            </div>

          </div>

        </form>

        <!-- UID LIST -->
        <table class="table">

          <thead>
            <tr>
              <th>Game</th>
              <th>UID</th>
              <th width="120">Action</th>
            </tr>
          </thead>

          <tbody>

          <?php
          $user_id = $_SESSION['user_id'];

          $stmt = $conn->prepare("
          SELECT game_uids.id, games.name, game_uids.uid
          FROM game_uids
          JOIN games ON games.id = game_uids.game_id
          WHERE game_uids.user_id=?
          ");

          $stmt->bind_param("i",$user_id);
          $stmt->execute();

          $uids = $stmt->get_result();

          while($row = $uids->fetch_assoc()):
          ?>

          <tr>

            <td><?= htmlspecialchars($row['name']) ?></td>

            <td><?= htmlspecialchars($row['uid']) ?></td>

            <td>

              <a
              href="delete_uid.php?id=<?= $row['id'] ?>"
              class="btn btn-sm btn-danger"
              onclick="return confirm('Delete UID?')"
              >
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


<div id="uidModal" class="uid-modal">
  <div class="uid-modal-content">
    <h5>เลือก UID</h5>

    <div id="uidList"></div>

    <button onclick="closeUidModal()" class="se-btn-gray w-100 mt-3">
      ปิด
    </button>
  </div>
</div>

<div class="modal fade" id="historyModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">รายละเอียด</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p><strong>เกม:</strong> <span id="m_game"></span></p>
        <p><strong>รางวัล:</strong> <span id="m_name"></span></p>
        <p><strong>แต้ม:</strong> <span id="m_point"></span></p>
        <p><strong>เวลา:</strong> <span id="m_date"></span></p>
        <p><strong>สถานะ:</strong> <span id="m_status"></span></p>
        <hr>

        <div id="m_detail" style="font-weight:700;"></div>
      </div>

    </div>
  </div>
</div>