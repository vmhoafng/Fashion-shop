<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $role = $_POST['inlineRadioOptions'];
    $address = $_POST['address'];

    $notice = "";

    // Regex kiểm tra
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $notice = "Email không hợp lệ.";
    } elseif (strlen($password) < 6) {
        $notice = "Mật khẩu phải có ít nhất 6 ký tự.";
    } elseif (empty($username)) {
        $notice = "Tên không được để trống.";
    } elseif (!preg_match('/^(0|\+84)[0-9]{9}$/', $phone)) {
        $notice = "Số điện thoại không hợp lệ.";
    } else {
        // check tồn tại email
        $result = check_email($email);

        if ($result && $result['email_count'] > 0) {
            $notice = "Email đã được sử dụng.";
        } else {
            insert_user($email, $password, $username, $phone, $role, $address);
            header("Location: index.php?ac=account");
            exit;
        }
    }
}
?>

<main class="page-content">
    <div class="container-fluid">
        <div class="title-management">
            <h3>Accounts Management</h3>
            <div>
                <?php if (isset($notice)) { ?>
                    <h5>
                        <i class="fa fa-exclamation-circle"></i>
                        <?= htmlspecialchars($notice); ?>
                    </h5>
                <?php } ?>
                <a href="index.php?ac=account" class="btn all-btn-management btn-secondary">
                    <i class="fa fa-arrow-left"></i> Return
                </a>
            </div>
        </div>
        <hr>
        <form action="#" method="POST" class="form-management">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" placeholder="Your Email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" placeholder="Your Password">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="username" placeholder="Your Name" value="<?= isset($username) ? htmlspecialchars($username) : '' ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Phone</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="phone" placeholder="Your Phone Number" value="<?= isset($phone) ? htmlspecialchars($phone) : '' ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="address" placeholder="Your Address" value="<?= isset($address) ? htmlspecialchars($address) : '' ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Role</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" checked>
                        <label class="form-check-label" for="inlineRadio1">Customer</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2">Admin</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-block">
                <i class="fa fa-user-plus"></i> Create
            </button>
        </form>
    </div>
</main>