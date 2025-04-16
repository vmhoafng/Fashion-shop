<div class="container-fluid sign-container">
    <div class="row justify-content-center">
        <div class="col-md-4 sign-form" style="margin: 8% 0 8% 0;">
            <h2>SIGNUP</h2>

            <form action="index.php?ac=signup" method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email *" name="email" />
                    <div class="error-message" id="email-error"></div>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password *" name="password" />
                    <div class="error-message" id="password-error"></div>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name *" name="username" />
                    <div class="error-message" id="username-error"></div>
                </div>

                <div class="form-group">
                    <input type="number" class="form-control" placeholder="Phone Number *" name="phone" />
                    <div class="error-message" id="phone-error"></div>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Address *" name="address" />
                    <div class="error-message" id="address-error"></div>
                </div>

                <div class="row justify-content-center">
                    <input type="submit" class="btnSubmit" value="Signup" name="signup" />
                </div>
            </form>

            <?php if (isset($notice)) {

                if ($notice === "Đăng ký thành công.") { ?>
                    <h5 style="color: green">
                        <i class="far fa-check-circle"></i>
                        <?= $notice; ?>
                    </h5>

                <?php } else { ?>

                    <h5 style="color: rgb(255, 55, 155);">
                        <i class="far fa-times-circle"></i>
                        <?= $notice; ?>
                    </h5>

            <?php }
            } ?>

            <div class="d-flex justify-content-center links">
                Already have an account an account?&nbsp;
                <a href="index.php?ac=signin">Signin</a>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            var email = document.querySelector('input[name="email"]').value;
            var password = document.querySelector('input[name="password"]').value;
            var username = document.querySelector('input[name="username"]').value;
            var phone = document.querySelector('input[name="phone"]').value;
            var address = document.querySelector('input[name="address"]').value;

            var emailError = document.getElementById('email-error');
            var passwordError = document.getElementById('password-error');
            var usernameError = document.getElementById('username-error');
            var phoneError = document.getElementById('phone-error');
            var addressError = document.getElementById('address-error');

            var check = true;

            if (email === '') {
                emailError.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Email không hợp lệ.';
                check = false;
            } else {
                emailError.textContent = '';
            }

            // \s => check exist space ' '
            if (/\s/.test(password) || password === '') {
                passwordError.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Mật khẩu không hợp lệ.';
                check = false;
            } else {
                passwordError.textContent = '';
            }

            // trim => skip space ' ' at start and end line
            if (username.trim() === '') {
                usernameError.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Tên không hợp lệ.';
                check = false;
            } else {
                usernameError.textContent = '';
            }

            if (/^[0][0-9]{9}$/.test(phone)) {
                phoneError.textContent = '';
            } else {
                phoneError.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Số điện thoại không hợp lệ.';
                check = false;
            }

            if (address === '') {
                addressError.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Địa chỉ không hợp lệ.';
                check = false;
            } else {
                addressError.textContent = '';
            }

            return check;
        }
    </script>

</div>