<?php
session_start();
require_once "../config/db.php";

$errors = [];
$success = "";

/* ================= LOGIN ================= */

if(isset($_POST['login'])){

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare(
"SELECT * FROM users WHERE username=?"
);

$stmt->bind_param("s",$username);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 1){

$user = $result->fetch_assoc();

if($password == $user['password']){

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];

header("Location:index.php");
exit();

}else{
$error = "Wrong password";
}

}else{
$error = "User not found";
}

}


/* ================= REGISTER ================= */

/* ================= REGISTER ================= */

if(isset($_POST['register'])){

$username  = isset($_POST['reg_username']) ? trim($_POST['reg_username']) : '';
$firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
$lastname  = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
$password  = isset($_POST['reg_password']) ? trim($_POST['reg_password']) : '';
$confirm   = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
$email     = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone     = isset($_POST['phone']) ? trim($_POST['phone']) : '';

/* ===== VALIDATION ===== */

if(empty($username) || empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($phone)){
    $error = "กรุณากรอกข้อมูลให้ครบ";
}
if($password !== $confirm){
    $errors['confirm_password'] = "รหัสผ่านไม่ตรงกัน";
}

if(!preg_match('/^[0-9]{10}$/', $phone)){
    $errors['phone'] = "เบอร์โทรต้องเป็นตัวเลข 10 หลัก";
}
else{

    // 🔍 เช็ค username ซ้ำ
    $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
    $errors['reg_username'] = "Username นี้ถูกใช้แล้ว";
    }else{

        $status = 'active';
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // 🔥 INSERT
        $stmt = $conn->prepare("
        INSERT INTO users (username, firstname, lastname, password, email, phone, status)
        VALUES (?,?,?,?,?,?,?)
        ");

        $stmt->bind_param(
        "sssssss",
        $username,
        $firstname,
        $lastname,
        $hashed_password,
        $email,
        $phone,
        $status
        );

        if(empty($errors) && $stmt->execute()){
            $success = "สมัครสำเร็จ กรุณา login";
        }else{
            $error = "เกิดข้อผิดพลาด";
        }
    }
}
}

?>

<?php if(isset($_SESSION['error'])): ?>

<div class="alert alert-danger">
<?= $_SESSION['error'] ?>
</div>

<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php include "partials/header.php"; ?>

<section class="se-section">
    <div class="se-container">

        <?php if($success): ?>
            <div class="alert alert-success mb-4"><?= $success ?></div>
        <?php endif; ?>

        <div class="row g-4">

        <!-- LOGIN -->
        <div class="col-lg-6">

            <div class="se-card p-4">

                <h4 class="mb-2">Login to our site</h4>
                <p class="text-muted mb-4">
                    Enter username and password to log on:
                </p>

                <form method="POST" action="login_process.php">

                    <input
                    type="text"
                    name="username"
                    class="form-control mb-3"
                    placeholder="Username"
                    required
                    >

                    <input
                    type="password"
                    name="password"
                    class="form-control mb-3"
                    placeholder="Password"
                    required
                    >

                    <button
                    name="login"
                    class="se-btn-green w-100">
                    Sign in
                    </button>

                </form>

            </div>
        </div>


        <!-- REGISTER -->
        <div class="col-lg-6">

            <div class="se-card p-4">

            <h4 class="mb-2">Sign up now</h4>

            <p class="text-muted mb-4">
                Fill in the form below to get instant access:
            </p>

            <form method="POST">

                <input type="text" name="reg_username"
                class="form-control mb-3 <?= isset($errors['reg_username']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($_POST['reg_username'] ?? '') ?>" placeholder="Username">
                <?php if(isset($errors['reg_username'])): ?>
                <div class="text-danger"><?= $errors['reg_username'] ?></div>
                <?php endif; ?>

                <input type="text" name="firstname"
                class="form-control mb-3 <?= isset($errors['firstname']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>" placeholder="First Name">
                <?php if(isset($errors['firstname'])): ?>
                <div class="text-danger"><?= $errors['firstname'] ?></div>
                <?php endif; ?>

                <input type="text" name="lastname"
                class="form-control mb-3 <?= isset($errors['lastname']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>" placeholder="Last Name">
                <?php if(isset($errors['lastname'])): ?>
                <div class="text-danger"><?= $errors['lastname'] ?></div>
                <?php endif; ?>

                <input type="email" name="email"
                class="form-control mb-3 <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="E-Mail Address">
                <?php if(isset($errors['email'])): ?>
                <div class="text-danger"><?= $errors['email'] ?></div>
                <?php endif; ?>

                <input type="password" name="reg_password"
                class="form-control mb-3 <?= isset($errors['reg_password']) ? 'is-invalid' : '' ?>"
                placeholder="Password">
                <?php if(isset($errors['reg_password'])): ?>
                <div class="text-danger"><?= $errors['reg_password'] ?></div>
                <?php endif; ?>

                <input type="password" name="confirm_password"
                class="form-control mb-3 <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>"
                placeholder="Confirm Password">
                <?php if(isset($errors['confirm_password'])): ?>
                <div class="text-danger"><?= $errors['confirm_password'] ?></div>
                <?php endif; ?>

                <input type="text" name="phone"
                class="form-control mb-3 <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                placeholder="Phone" maxlength="10"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                <?php if(isset($errors['phone'])): ?>
                <div class="text-danger"><?= $errors['phone'] ?></div>
                <?php endif; ?>
                
                <button
                name="register"
                class="se-btn-green w-100">
                Register
                </button>

            </form>

            </div>
        </div>

        </div>

    </div>
</section>

<?php include "partials/footer.php"; ?>