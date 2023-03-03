<?php include __DIR__ . '/../header.php'; ?>
    <div class="formSignIn color">
        <h1>Welcome back!</h1>
        <form>
            <input type="text" name="login" id="login" placeholder="Login"><br>
            <div id="loginError" class="error"></div><br>
            <input type="password" name="password" id="password" placeholder="Password"><br>
            <div id="passwordError" class="error"></div><br>
            <span onclick="login()">Continue</span>
            <br><br>
            <span onclick="redirect('/users/register')">to Sign Up</span>
        </form>
        <script src="/../../www/scripts.js"></script>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>