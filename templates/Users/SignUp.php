<?php include __DIR__ . '/../header.php'; ?>
    <div class="formSignUp color">
        <h1>Create an account</h1>
        <form>
            <input type="text" name="login" id="login" placeholder="Login"><br>
            <div id="loginError" class="error"></div><br>
            <input type="password" name="password" id="password" placeholder="Password"><br>
            <div id="passwordError" class="error"></div><br>
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm password"><br>
            <div id="confirmPasswordError" class="error"></div><br>
            <input type="email" name="email" id="email" placeholder="Email"><br>
            <div id="emailError" class="error"></div><br>
            <input type="text" name="name" id="name" placeholder="name"><br>
            <div id="nameError" class="error"></div><br>
            <span onclick="register()">Continue</span>
            <div id="result" class='success'></div>
            <br>
            <span onclick="redirect('/users/login')">to Sign In</span>
        </form>
    </div>
        <script src="/../../www/scripts.js"></script>
<?php include __DIR__ . '/../footer.php'; ?>