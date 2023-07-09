<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta bane="viewport" content="width=device-width,initial-scale=1.0">
    <link href="registration_login.css" rel="stylesheet">
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

    <?php
        if(isset($_POST["login"])){
            $Email = $_POST["Email"];
            $Password = $_POST["Password"];

            require_once "admin_connect.php";
            $sql = "SELECT * FROM admin WHERE Email = '$Email'";
			$result = mysqli_query($conn, $sql);
			$user = mysqli_fetch_array($result , MYSQLI_ASSOC);
            if($user){
                if(password_verify($Password, $user["Password"])){
                    if($user["Role"] == 'Insurance Company'){
                        session_start();
                        $_SESSION["user"]="Yes";
                        header("location:insuranceCompany.php");
                        die();

                    }elseif($user["Role"] == 'Ministry of Transport'){
                        session_start();
                        $_SESSION["user"]="MOT";
                        header("location:ministryofTransport.php");
                        die();

                        if(isset($_SESSION["user"])){
                            header("location:ministryofTransport.php");
                        }
                    }elseif($user["Role" == 'Technical Visit']){
                        header("location:technicalVisit.php");
                        die();
                    }
                }else{
                    echo "Incorrect Password";
                }
            }else{
                echo "Email not found!";
            }
        }
    ?>

<?php

        

    if(isset($_POST["register"])){
        $Name = $_POST["Name"];
        $Email = $_POST["Email"];
        $Role = $_POST["Role"];
        $Password = $_POST["Password"];
        $Repeat_Password = $_POST["Repeat_Password"];

        $Password_hash = password_hash($Password, PASSWORD_DEFAULT);
		$errors = array();

        require_once "admin_connect.php";
		$sql = "SELECT * FROM admin WHERE Email = '$Email'";
		$result = mysqli_query($conn, $sql);
		$rowCount = mysqli_num_rows($result);
		if($rowCount > 0){
			array_push($errors, "Email already exists");
		}

        if(count($errors)>0){
            foreach($errors as $error){
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
        else{
            
            $sql = "INSERT INTO admin(Name, Email, Role, Password)values( ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepare = mysqli_stmt_prepare($stmt,$sql);
            if($prepare){
                mysqli_stmt_bind_param($stmt,"ssss", $Name, $Email, $Role, $Password_hash);
                mysqli_stmt_execute($stmt);
                
                $sql = "SELECT * FROM admin WHERE Email = '$Email'";
			$result = mysqli_query($conn, $sql);
			$user = mysqli_fetch_array($result , MYSQLI_ASSOC);
            if($user){
                if($user["Role"] == 'Insurance Company'){
                        header("location:insuranceCompany.php");
                        die();
                    }elseif($user["Role"] == 'Ministry of Transport'){
                        header("location:ministryofTransport.php.php");
                        die();
                    }elseif($user["Role"] == 'Technical Visit'){
                        header("location:technicalVisit.php.php");
                        die();
                    }
            }
            }else{
                die("Something went wrong!");
            }
        }
    }
?>
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