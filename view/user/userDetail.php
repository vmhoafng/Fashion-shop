<?php
$user= $_SESSION['user'];
?>
<main class="page-content" style="margin-top:100px; margin-left:200px; margin-bottom:200px" >
    <div class="container-fluid">
        <h2>User Detail</h2>
        <div class="row ">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" value="<?php echo $user['user_name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" value="<?php echo $user['user_email']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" value="<?php echo $user['user_phoneNumber']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" value="<?php echo $user['user_address']; ?>" readonly>
                </div>
            <button type="submit" class="btn btn-primary" onclick="window.location.href='index.php?ac=edituser'">Edit profile</button>
            <button type="submit" class="btn btn-primary" onclick="window.location.href='index.php?ac=changepassword'">Change password</button>
    </div>

</main>