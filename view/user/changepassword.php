<?php
$user= $_SESSION['user'];
$rePasswordError=false;
$oldPasswordError=false;
if(isset($_POST['changepassword'])){
    $oldpassword=$_POST['oldpassword'];
    $newpassword=$_POST['newpassword'];
    $repassword=$_POST['repassword'];
    if($oldpassword==$user['user_password']){
        if($newpassword==$repassword){
            changepassword($user['user_id'],$newpassword);
            $_SESSION['user']['user_password']=$newpassword;
            header('Location: index.php?ac=userdetail');
        }else{
            $rePasswordError=true;
        }
    }else{
        $oldPasswordError=true;
    }
}
?>
<main class="page-content" style="margin-top:100px; margin-left:200px; margin-bottom:200px" >
    <div class="container-fluid">
        <h2>Change Password</h2>
        <div class="row ">
            <div class="col-md-6">
                <form method="post">
                    <div class="form-group">
                        <label for="oldpassword">Old Password:</label>
                        <input type="password" class="form-control" id="oldpassword" name="oldpassword" required>
                        <?php if($oldPasswordError){ ?>
                            <label class="text-danger">Old password not correct</label>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="newpassword">New Password:</label>
                        <input type="password" class="form-control" id="newpassword" name="newpassword" required>
                    </div>
                    <div class="form-group">
                        <label for="repassword">Re-Password:</label>
                        <input type="password" class="form-control" id="repassword" name="repassword" required>
                        
                        <?php if($rePasswordError){ ?>
                            <label class="text-danger">re Passwords do not match</label>
                        <?php } ?>
                    </div>
                    <button type="submit" class="btn btn-primary" name="changepassword">Change</button>
                </form>
    </div>
</main>
