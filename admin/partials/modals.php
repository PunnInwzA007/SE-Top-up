<!-- ================= ORDER MODAL ================= -->

<!-- Update Order Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">

      <h4 class="font-weight-bold mb-4">
        Order ID : <span id="modalOrderId"></span>
      </h4>

      <form method="POST" action="update-order.php">

        <input type="hidden" name="id" id="modalInputId">

        <h6 class="mb-3">Update Status</h6>

        <div class="form-group">

          <div class="custom-control custom-radio mb-2">
            <input type="radio" id="modalCancel"
                   name="status"
                   value="cancel"
                   class="custom-control-input">
            <label class="custom-control-label text-danger" for="modalCancel">
              Cancel (ยกเลิก)
            </label>
          </div>

          <div class="custom-control custom-radio mb-2">
            <input type="radio" id="modalSuccess"
                   name="status"
                   value="success"
                   class="custom-control-input">
            <label class="custom-control-label text-success" for="modalSuccess">
              Success (สำเร็จ)
            </label>
          </div>

          <div class="custom-control custom-radio mb-4">
            <input type="radio" id="modalPending"
                   name="status"
                   value="pending"
                   class="custom-control-input">
            <label class="custom-control-label text-warning" for="modalPending">
              Pending (กำลังดำเนินการ)
            </label>
          </div>

        </div>

        <div class="text-right">
          <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">
            Cancel
          </button>

          <button type="submit" class="btn btn-success">
            OK
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- ================= GAME MODAL ================= -->
<!-- ===== Edit ===== -->
<div class="modal fade" id="editGameModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content p-3">

      <form action="edit-game.php"
            method="POST"
            enctype="multipart/form-data">

        <input type="hidden" name="id" id="editGameId">

        <div class="modal-header">
          <h5 class="modal-title">Edit Game</h5>
          <button type="button" class="close" data-dismiss="modal">
            &times;
          </button>
        </div>

        <div class="modal-body">

          <label>Game Name</label>
          <input class="form-control mb-3"
                 name="name"
                 id="editGameName"
                 required>

          <label>Status</label>
          <select name="status"
                  id="editGameStatus"
                  class="form-control mb-3">
            <option value="ON">ON</option>
            <option value="OFF">OFF</option>
          </select>

          <label>Change Image</label>
          <input type="file"
                 name="image"
                 class="form-control">

        </div>

        <div class="modal-footer">
          <button type="button"
                  class="btn btn-danger"
                  data-dismiss="modal">
            Cancel
          </button>

          <button type="submit"
                  class="btn btn-primary">
            Save
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
<!-- ===== Delete ===== -->
<div class="modal fade" id="deleteGameModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content p-3">

      <form action="delete-game.php" method="POST">

        <input type="hidden" name="id" id="deleteGameId">

        <div class="modal-header">
          <h5 class="modal-title text-danger">Delete Game</h5>
          <button type="button" class="close" data-dismiss="modal">
            &times;
          </button>
        </div>

        <div class="modal-body">
          แน่ใจนะว่าจะลบเกมนี้?
          <h5 class="mt-3 font-weight-bold"
              id="deleteGameName"></h5>
        </div>

        <div class="modal-footer">
          <button type="button"
                  class="btn btn-primary"
                  data-dismiss="modal">
            Cancel
          </button>

          <button type="submit"
                  class="btn btn-danger">
            Delete
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
<!-- ===== Add ===== -->
<div class="modal fade" id="addGameModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content p-3">

      <form action="add-game.php"
            method="POST"
            enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title">Add New Game</h5>
          <button type="button" class="close" data-dismiss="modal">
            &times;
          </button>
        </div>

        <div class="modal-body">

          <label>Game Name</label>
          <input type="text"
                 name="name"
                 class="form-control mb-3"
                 required>

          <label>Status</label>
          <select name="status"
                  class="form-control mb-3">
            <option value="ON">ON</option>
            <option value="OFF">OFF</option>
          </select>

          <label>Game Image</label>
          <input type="file"
                 name="image"
                 class="form-control"
                 required>

        </div>

        <div class="modal-footer">
          <button type="button"
                  class="btn btn-danger"
                  data-dismiss="modal">
            Cancel
          </button>

          <button type="submit"
                  class="btn btn-primary">
            Save Game
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- ================= Logout Modal (Single) ================= -->
<div class="modal fade" id="logoutModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content logout-modal">

      <div class="modal-header logout-header">
        <h2 class="logout-title">Confirm Logout</h2>
      </div>

      <div class="modal-body logout-body">
        <p>Are you sure you want to log out?</p>
      </div>

      <div class="modal-footer logout-footer">

        <button type="button"
                class="btn logout-btn cancel-btn"
                data-dismiss="modal">
          Cancel
        </button>

        <a href="logout.php"
           class="btn logout-btn ok-btn">
          OK
        </a>

      </div>

    </div>
  </div>
</div>

<!-- Add Package Modal -->
<div class="modal fade" id="addPackageModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="add_package.php" method="POST">

        <div class="modal-header">
          <h5 class="modal-title">Add Package</h5>
          <button type="button" class="close" data-dismiss="modal">
            &times;
          </button>
        </div>

        <div class="modal-body">

          <!-- Game -->
          <div class="form-group">
            <label>Game</label>
            <select name="game_id" class="form-control" required>

              <?php
              $games = $conn->query("SELECT * FROM games");
              while($g = $games->fetch_assoc()):
              ?>

              <option value="<?= $g['id'] ?>">
                <?= $g['name'] ?>
              </option>

              <?php endwhile; ?>

            </select>
          </div>

          <!-- Package Name -->
          <div class="form-group">
            <label>Package Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <!-- Price -->
          <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
          </div>

          <!-- Status -->
          <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="ON">ON</option>
              <option value="OFF">OFF</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            Add Package
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- Edit Package Modal -->
<div class="modal fade" id="editPackageModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="update_package.php" method="POST">

        <div class="modal-header">
          <h5 class="modal-title">Edit Package</h5>
          <button type="button" class="close" data-dismiss="modal">
            &times;
          </button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="id" id="editPackageId">

          <!-- Game -->
          <div class="form-group">
            <label>Game</label>
            <select name="game_id" class="form-control" id="editPackageGame">

              <?php
              $games = $conn->query("SELECT * FROM games");
              while($g = $games->fetch_assoc()):
              ?>

              <option value="<?= $g['id'] ?>">
                <?= $g['name'] ?>
              </option>

              <?php endwhile; ?>

            </select>
          </div>

          <!-- Package Name -->
          <div class="form-group">
            <label>Package Name</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   id="editPackageName">
          </div>

          <!-- Price -->
          <div class="form-group">
            <label>Price</label>
            <input type="number"
                   step="0.01"
                   name="price"
                   class="form-control"
                   id="editPackagePrice">
          </div>

          <!-- Status -->
          <div class="form-group">
            <label>Status</label>
            <select name="status"
                    class="form-control"
                    id="editPackageStatus">

              <option value="ON">ON</option>
              <option value="OFF">OFF</option>

            </select>
          </div>

        </div>

        <div class="modal-footer">

          <!-- Delete -->
          <a href="#" id="deletePackageBtn"
             class="btn btn-danger">
             Delete
          </a>

          <!-- Save -->
          <button type="submit"
                  class="btn btn-primary">
              Save Changes
          </button>

        </div>

      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="addRewardModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="add_reward.php" method="POST">

        <div class="modal-header">
          <h5 class="modal-title">Add Reward</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Type</label>
            <select name="type" class="form-control">
              <option value="balance">Balance</option>
              <option value="code">Code</option>
              <option value="giftcard">Giftcard</option>
            </select>
          </div>

          <div class="form-group">
            <label>Package</label>
            <select name="package_id" class="form-control">
              <option value="">None</option>
              <?php
              $pk = $conn->query("SELECT * FROM packages");
              while($p = $pk->fetch_assoc()):
              ?>
              <option value="<?= $p['id'] ?>">
                <?= $p['name'] ?>
              </option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Point Cost</label>
            <input type="number" name="point_cost" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" placeholder="ใส่จำนวน เช่น 10">
          </div>
        </div>
              
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>

      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="editRewardModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="update_reward.php" method="POST">

        <div class="modal-header">
          <h5 class="modal-title">Edit Reward</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="id" id="editRewardId">

          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" id="editRewardName" class="form-control">
          </div>

          <div class="form-group">
            <label>Type</label>
            <select name="type" id="editRewardType" class="form-control">
              <option value="balance">Balance</option>
              <option value="code">Code</option>
              <option value="giftcard">Giftcard</option>
            </select>
          </div>

          <div class="form-group">
            <label>Package</label>
            <select name="package_id" id="editRewardPackage" class="form-control">
              <option value="">None</option>
              <?php
              $pk = $conn->query("SELECT * FROM packages");
              while($p = $pk->fetch_assoc()):
              ?>
              <option value="<?= $p['id'] ?>">
                <?= $p['name'] ?>
              </option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Point Cost</label>
            <input type="number" name="point_cost" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Amount</label>
            <input type="number" name="amount" id="editAmount" class="form-control">
          </div>
        </div>

        <div class="modal-footer">

          <a href="#" id="deleteRewardBtn" class="btn btn-danger">
            Delete
          </a>

          <button type="submit" class="btn btn-primary">
            Save
          </button>

        </div>

      </form>

    </div>
  </div>
</div>
<!-- ADD GIFTCARD -->
<div class="modal fade" id="addGiftcardModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="add_giftcard.php" method="POST">

        <div class="modal-header">
          <h5 class="modal-title">Add Giftcard</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <label>Reward</label>
            <select name="reward_id" class="form-control">
              <?php
              $rs = $conn->query("SELECT id,name FROM rewards WHERE type='giftcard'");
              while($r = $rs->fetch_assoc()):
              ?>
              <option value="<?= $r['id'] ?>">
                <?= $r['name'] ?>
              </option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Codes</label>
            <textarea name="codes" class="form-control" rows="5"
              placeholder="1 code ต่อ 1 บรรทัด"></textarea>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-primary">Add</button>
        </div>

      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="addDiscountModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="add_discount.php" method="POST">

        <div class="modal-header">
          <h5 class="modal-title">Add Discount Code</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <label>Code</label>
            <input type="text" name="code" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Discount Amount</label>
            <input type="number" name="discount_amount" class="form-control">
          </div>

          <div class="form-group">
            <label>Minimum Price</label>
            <input type="number" name="min_price" class="form-control">
          </div>

          <div class="form-group">
            <label>Usage Limit</label>
            <input type="number" name="usage_limit" class="form-control">
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-primary">Add</button>
        </div>

      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="addBonusModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="add_bonus.php" method="POST">

        <div class="modal-header">
          <h5 class="modal-title">Add Bonus Code</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <label>Package</label>
            <select name="package_id" class="form-control">
              <?php
              $pk = $conn->query("SELECT id,name FROM packages");
              while($p = $pk->fetch_assoc()):
              ?>
              <option value="<?= $p['id'] ?>">
                <?= $p['name'] ?>
              </option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Codes</label>
            <textarea name="codes" class="form-control" rows="5"
              placeholder="1 code ต่อ 1 บรรทัด"></textarea>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-primary">Add</button>
        </div>

      </form>

    </div>
  </div>
</div>