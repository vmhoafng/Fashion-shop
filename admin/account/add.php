<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $role = $_POST['inlineRadioOptions'];
    $address = $_POST['address'];

    // check exits Email
    $result = check_email($email);
    $notice = "";

    // if exits Email
    if ($result && $result['email_count'] > 0) {
        $notice = "Email đã được sử dụng.";
    } else {
        insert_user($email, $password, $username, $phone, $role, $address);
        header("Location: index.php?ac=account");
    }
}

?>

<main class="page-content">
    <div class="container-fluid">

        <div class="title-management">
            <h3>Accounts Management &nbsp; </h3>

            <h5><i class="fa fa-angle-right"></i> &nbsp; Create new account</h5>

            <?php if (isset($notice)) { ?>

            <h5 style="color: rgb(255, 55, 155);"> &nbsp;
                <i class="fa fa-angle-right"></i> &nbsp;
                <i class="far fa-times-circle"></i>
                <?= $notice; ?>
            </h5>

            <?php } ?>

            <a href="index.php?ac=account" class="btn all-btn-management btn-secondary">
                <i class="fas fa-angle-double-left"></i> &nbsp; Return
            </a>
        </div>
        <hr>

        <form action="#" method="POST" class="form-management">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" placeholder="Your Email">
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
                    <input type="text" class="form-control" name="username" placeholder="Your Name">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Phone</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="phone" placeholder="Your Phone Number">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="address" placeholder="Your Address">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Role</label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="1"
                        checked>
                    <label class="form-check-label" for="inlineRadio2">Customer</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2">
                    <label class="form-check-label" for="inlineRadio2">Admin</label>
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg mx-auto d-block">
                <i class="fas fa-user-plus"></i> &nbsp; Create
            </button>
        </form>