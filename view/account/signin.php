<div class="container-fluid sign-container">
    <div class="row justify-content-center">
        <div class="col-md-4 sign-form" style="margin: 10% 4% 10% 4%;">
            <h2>SIGNIN</h2>

            <form action="index.php?ac=signin" method="POST" onsubmit="return validateForm()">

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Email *" name="email" />
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password *" name="password" />
                </div>

                <div class="row justify-content-center">
                    <input type="submit" class="btnSubmit" value="Signin" name="signin" />
                </div>
            </form>

            <?php if (isset($notice)) { ?>
            <h5 style="color: rgb(255, 55, 155);">
                <i class="far fa-times-circle"></i> <?= $notice; ?>
            </h5>
            <?php } ?>

            <div class="d-flex justify-content-center links">
                Don't have an account?&nbsp;
                <a href="index.php?ac=signup">Signup</a>
            </div>
        </div>
    </div>
</div>