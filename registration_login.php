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
                        $_SESSION["user"]="MOT";
                        if(isset($_SESSION["user"])){
                            header("location:vehicleInsurance.html");
                            die();
                        }
                    }elseif($user["Role"] == 'Ministry of Transport'){
                        session_start();
                        $_SESSION["user"]="MOT";                       
                        if(isset($_SESSION["user"])){
                            header("location:ministryofTransport.php");
                            die();
                        }
                    }elseif($user["Role"] == 'Technical Visit'){
                        session_start();
                        $_SESSION["user"]="MOT";                       
                        if(isset($_SESSION["user"])){
                            header("location:technicalVisit.php");
                            die();
                        }                       
                    }
                }else{
                    echo "Incorrect Password";
                }
            }else{
                echo "Email not found!";
            }
			if(empty($Email)){
				echo "Email Required!";
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
					
					if(empty($Name)){
						array_push($errors, "<b>Name required</b>");
					}
					else if(empty($Email)){
						array_push($errors, "<b>Email required</b>");
					}
					else if($Role == 'Pending'){
						array_push($errors, "<b>Role required</b>");
					}
					else if(empty($Password)){
						array_push($errors, "<b>Password required</b>");
					}
					else if(empty($Repeat_Password)){
						array_push($errors, "<b>Confirm your Password</b>"); 
					}
					else if(!filter_var($Email,FILTER_VALIDATE_EMAIL)){
						array_push($errors, "<b>Invalid Email</b>");
					}
					else if(strlen($Password)<8){
						array_push($errors, "\n<b>Password must be 8 characters long</b>");
					}
					else if($Password != $Repeat_Password){
						array_push($errors, "\n<b>Password does not match</b>");
					}
					else if(!preg_match("/[A-Z]/",$Password) ||!preg_match("/[a-z]/",$Password)||!preg_match("/[0-9]/",$Password)
						||!preg_match("/[^\w]/", $Password)){
							array_push($errors,"<b>Password must include atleast one uppercase letter, one lowercase letter, one number and a special character</b>");
					}
					

        require_once "admin_connect.php";
		if(!empty($Name) AND !empty($Email) AND !empty($Password) AND !empty($Repeat_Password) AND $Role!='Pending'){
			$sql = "SELECT * FROM admin WHERE Email = '$Email'";
			$result = mysqli_query($conn, $sql);
			$rowCount = mysqli_num_rows($result);
			if($rowCount > 0){
				array_push($errors, "<b>Email already exists</b>");
			}
		}
        if(count($errors)>0){
            foreach($errors as $error){
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
		
		else if(isset($_POST["check"])){
			if(!empty($Name) AND !empty($Email) AND !empty($Password) AND !empty($Repeat_Password) AND $Role != 'Pending'){
            
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
                        header("location:vehicleInsurance.html");
                        die();
                    }elseif($user["Role"] == 'Ministry of Transport'){
                        header("location:ministryofTransport.php");
                        die();
                    }elseif($user["Role"] == 'Technical Visit'){
                        header("location:technicalVisit.php");
                        die();
                    }
            }
            }else{
                die("Something went wrong!");
            }
        }
		}
		else if(!isset($_POST["check"])){
			echo "<b>You must agree to the terms and conditions to register!</b>";
		}
        
    }
?>

	
    <div class="wrapper">
    <span class="icon-close"><img src="pictures/wCross.png" style="width: 15px;"/></span>
        <div class="form-box login">
            <h2>Login</h2>
            <form action="registration_login.php" method="post">
                <div class="input-box">
                    <span class="icon"><img src="pictures/email.png"/></span>
                    <input type="email" name="Email">
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><img src="pictures/password.png"/></span>
                    <input type="password" name="Password">
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Remind me</label>
                    <a href="#">Forgot password?</a>
                </div>
                <input type="submit" name="login" class="btn" value="Login">
                <div class="login-register">
                    <p>Don't have an account?<a href="#" class="register-link" style="font-weight:bold;font-size:20px;color:#fff;"> Register</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
				<h2>Registration</h2>
				<form action="registration_login.php" method="post">
					<div class="input-box">
						<span class="icon"><img src="pictures/user.png" style="width:30px;"/></span>
						<input type="text" name="Name">
						<label>Username</label>
					</div>
					<div class="input-box">
						<span class="icon"><img src="pictures/email.png"/></span>
						<input type="email" name="Email">
						<label>Email</label>
					</div>
                    <div class="input-box">
						<span class="icon"><img src="pictures/user.png"/ style="width:30px;"></span>
						<select name="Role">
						<!--disabled selected-->
							<option value="Pending">Role</option>
							<option value="Insurance Company">Insurance Company</option>
							<option value="Ministry of Transport">Ministry of Transport</option>
							<option value="Technical Visit">Technical Visit</option>
						</select>
					</div>
					<div class="input-box">
						<span class="icon"><img src="pictures/password.png"/></span>
						<input type="password" name="Password">
						<label>Password</label>
					</div>
                    <div class="input-box">
						<span class="icon"><img src="pictures/password.png"/></span>
						<input type="password" name="Repeat_Password">	
						<label>Confirm Password</label>
					</div>
					<div class="remember-forgot">
						<label><input type="checkbox" name="check">Agree to terms and conditions</label>
					</div>
					<input type="submit" name="register" class="btn" value="Register">
					<div class="login-register">
						<p>Already have an account?<a href="#" class="login-link" style="font-weight:bold;font-size:20px;color:#fff;"> Login</a></p>
					</div>
				</form>
		</div>
    </div>

    <script src="registration_login.js"></script>
</body>

</html>