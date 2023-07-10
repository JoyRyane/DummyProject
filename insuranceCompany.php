<?php
    session_start();
    if(!isset($_SESSION["user"])){
        header("location:registration_login.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta bane="viewport" content="width=device-width,initial-scale=1.0">
    <link href="#" rel="stylesheet">
	<title>Register/Login</title>
</head>
<body>
    <header>
            <h2 class="logo">Logo</h2>
            <nav class="navigation">
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Services</a>
                <a href="#">Contact</a>
                <button class="btnLogin-popup">Login</button>
            </nav>
	</header>

    <div class="wrapper">
    <span class="icon-close"><img src="pictures/password.png"/></span>
        <div class="form-box login">
            <h2>Login</h2>
            <form action="registration_login.php" method="post">
                <div class="input-box">
                    <span class="icon"><img src="pictures/email.png"/></span>
                    <input type="email" name="Email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><img src="pictures/password.png"/></span>
                    <input type="password" name="Password" required>
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Remind me</label>
                    <a href="#">Forgot password?</a>
                </div>
                <input type="submit" name="login" class="btn" value="Login">
                <div class="login-register">
                    <p>Don't have an account?<a href="#" class="register-link">Register</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
				<h2>Registration</h2>
				<form action="registration_login.php" method="post">
					<div class="input-box">
						<span class="icon"><img src="pictures/email.png"/></span>
						<input type="text" name="Name" required>
						<label>Username</label>
					</div>
					<div class="input-box">
						<span class="icon"><img src="pictures/email.png"/></span>
						<input type="email" name="Email" required>
						<label>Email</label>
					</div>
                    <div class="input-box">
						<span class="icon"><img src="pictures/email.png"/></span>
						<select name="Role" required>
							<option value="" disabled selected>role</option>
							<option value="Insurance Company">Insurance Company</option>
							<option value="Ministry of Transport">Ministry of Transport</option>
							<option value="Technical Visit">Technical Visit</option>
						</select>
					</div>
					<div class="input-box">
						<span class="icon"><img src="pictures/password.png"/></span>
						<input type="password" name="Password" required>
						<label>Password</label>
					</div>
                    <div class="input-box">
						<span class="icon"><img src="pictures/password.png"/></span>
						<input type="password" name="Repeat_Password" required>	
						<label>Confirm Password</label>
					</div>
					<div class="remember-forgot">
						<label><input type="checkbox">Agree to terms and conditions</label>
					</div>
					<input type="submit" name="register" class="btn" value="Register">
					<div class="login-register">
						<p>Already have an account?<a href="#" class="login-link">Login</a></p>
					</div>
				</form>
		</div>
    </div>

    <script src="registration_login.js"></script>
</body>

</html>