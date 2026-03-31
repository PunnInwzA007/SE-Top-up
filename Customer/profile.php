<?php require_once "auth.php"; ?>
<?php 
include "partials/header.php";

/* mock data (เดี๋ยวค่อยดึง DB) */
require_once "../config/db.php";

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
SELECT id, username, firstname, lastname, email, phone
FROM users
WHERE id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

/* generate display user id */
$user_display_id = "s" . str_pad($user['id'],9,"0",STR_PAD_LEFT);
?>

    <!-- PAGE HERO -->
    <section class="se-page-hero">
        <div class="se-page-hero-inner">
                <h2 class="se-page-title">My Profile</h2>
            <p class="se-page-breadcrumb">Home > Profile</p>
        </div>
    </section>

    <section class="se-section">
        <div class="se-container">

        <!-- PROFILE HEADER -->
        <div class="se-card p-4 mb-4 text-center">

        <div class="se-profile-avatar mb-3">
            <img src="https://api.dicebear.com/7.x/fun-emoji/svg?seed=<?= $user['username'] ?>" class="se-ph se-ph-square" style="width:120px;margin:auto;">
        </div>

        <h4 style="font-weight:900;">
            <?= htmlspecialchars($user['username']) ?>
        </h4>

        <p style="color:#666;">
            <?= htmlspecialchars($user['email']) ?>
        </p>

        </div>


        <div class="row g-4">

        <!-- PERSONAL INFO -->
        <div class="col-lg-6">
        <div class="se-card p-4">

            <h5 class="mb-3" style="font-weight:800;">Personal Information</h5>

            <div class="mb-3">
            <label class="form-label">First Name</label>
            <input class="form-control"
                    value="<?= htmlspecialchars($user['firstname']) ?>"
                    readonly>
            </div>

            <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input class="form-control"
                    value="<?= htmlspecialchars($user['lastname']) ?>"
                    readonly>
            </div>

            <button class="se-btn-green w-100"
                data-bs-toggle="modal"
                data-bs-target="#editPersonalModal">
                Edit Personal Info
            </button>

        </div>
        </div>


        <!-- CONTACT INFO -->
        <div class="col-lg-6">
        <div class="se-card p-4">

            <h5 class="mb-3" style="font-weight:800;">Contact Information</h5>

            <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control"
                    value="<?= htmlspecialchars($user['email']) ?>"
                    readonly>
            </div>

            <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input class="form-control"
                    value="<?= htmlspecialchars($user['phone']) ?>"
                    readonly>
            </div>

            <button class="se-btn-green w-100"
                data-bs-toggle="modal"
                data-bs-target="#editContactModal">
                Edit Contact Info
            </button>

        </div>
        </div>


        <!-- ACCOUNT INFO -->
        <div class="col-lg-6">
        <div class="se-card p-4">

            <h5 class="mb-3" style="font-weight:800;">Account Information</h5>

            <div class="mb-3">
            <label class="form-label">User ID</label>
            <input class="form-control"
                    value="<?= htmlspecialchars($user['id']) ?>"
                    readonly>
            </div>

            <button class="se-btn-black w-100"
                    data-bs-toggle="modal"
                    data-bs-target="#uidModal">
            Manage Player UID
            </button>

        </div>
        </div>


        <!-- SECURITY -->
        <div class="col-lg-6">
        <div class="se-card p-4">

            <h5 class="mb-3" style="font-weight:800;">Security</h5>

            <button class="se-btn-red w-100"
            data-bs-toggle="modal"
            data-bs-target="#changePasswordModal">
            Change Password
            </button>

        </div>
        </div>

        </div>

        </div>
    </section>

<?php include "partials/footer.php"; ?>