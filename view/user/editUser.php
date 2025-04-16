<?php
$user= $_SESSION['user'];
if(isset($_POST['edituser'])){
    $user_name=$_POST['name'];
    $user_email=$_POST['email'];
    $user_phoneNumber=$_POST['phone'];
    $user_address=$_POST['address'];
    edituser($user['user_id'],$user_name,$user_email,$user_phoneNumber,$user_address);
    $_SESSION['user']['user_name']=$user_name;
    $_SESSION['user']['user_email']=$user_email;
    $_SESSION['user']['user_phoneNumber']=$user_phoneNumber;
    $_SESSION['user']['user_address']=$user_address;
    header('Location: index.php?ac=userdetail');
}
?>
<main class="page-content" style="margin-top:100px; margin-left:200px; margin-bottom:200px" >
    <div class="container-fluid">
        <h2>Edit User</h2>
        <div class="row ">
            <div class="col-md-6">
                <form method="post">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['user_name'];  ?> " require>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $user['user_email']; ?>" require>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['user_phoneNumber']; ?> " require>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $user['user_address']; ?>" require>
                    </div>
                    <button type="submit" class="btn btn-primary" name="edituser">Save</button>
                </form>
    </div>
</main>
