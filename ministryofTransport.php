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
    <link rel="stylesheet" href="ministryofTransport.css" >
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
            </nav>
	</header>

        <?php
            if(isset($_POST["register"])){
                $Owner = $_POST["Owner"];
				$Dealer = $_POST["Dealer"];
				$Email = $_POST["Email"];
                $carReg = $_POST["carReg"];
				$Issuedate = $_POST["Issuedate"];
				$Expirydate = $_POST["Expirydate"];

                $errors = array();
                if(empty($Owner) OR empty($Dealer) OR empty($Email) OR empty($Issuedate) OR empty($Expirydate)){
                    array_push($errors,"All fields are required");
                }
				if(empty($Owner)){
					array_push($errors,"Owner required!");
				}
				else if(empty($Dealer)){
					array_push($errors,"Dealer required!");
				}
				else if(empty($Email)){
					array_push($errors,"Email required!");
				}
				else if(empty($Issuedate)){
					array_push($errors,"Issuedate required!");
				}
				else if(empty($Expirydate)){
					array_push($errors,"Expirydate required!");
				}
                else if(!filter_var($Email,FILTER_VALIDATE_EMAIL)){
                    array_push($errors,"Invalid email");
                }
                else if(!preg_match("/(\b((AD)|(CE)|(EN)|(ES)|(LT)|(NO)|(NW)|(OU)|(SU)|(SW))[0-9]{3}[A-Z]{2}\b)|(\b((AD)|(CE)|(EN)|(ES)|(LT)|(NO)|(NW)|(OU)|(SU)|(SW))[0-9]{4}[A-Z]{1}\b)/",$carReg)){
                    array_push($errors,"Invalid Registration Number");
                }
                else if($Issuedate >= $Expirydate){
                    array_push($errors,"Invalid date");
                }
                
				require_once("admin_connect.php");
				if(!empty($Owner) AND !empty($Dealer) AND !empty($Email) AND !empty($carReg) AND !empty($Issuedate) AND !empty($Expirydate)){
					$sql = "SELECT * FROM ministryofTransport WHERE carReg = '$carReg'";
					$result = mysqli_query($conn, $sql);
					$rowCount = mysqli_num_rows($result);
					if($rowCount > 0){
						array_push($errors, "<b>Car registration number already inputted</b>");
					}
				}
				
				if(count($errors)>0){
                    foreach ($errors as $error){
                        echo "$error";
                    }
                }else{
					if(!empty($Owner) AND !empty($Dealer) AND !empty($Email) AND !empty($carReg) AND !empty($Issuedate) AND !empty($Expirydate)){
							$sql = "INSERT INTO ministryofTransport (Owner,Dealer,Email,carReg,Issuedate,Expirydate) values(?,?,?,?,?,?)";
							$stmt = mysqli_stmt_init($conn);
							$prepare = mysqli_stmt_prepare($stmt,$sql);
							if($prepare){
								mysqli_stmt_bind_param($stmt,"ssssss",$Owner,$Dealer,$Email,$carReg,$Issuedate,$Expirydate);
								mysqli_stmt_execute($stmt);
								echo "<div class = 'alert alert-success'>You have registered successfully</div>";
							}else{
								die("Something went wrong");
							}
					}
                }
            }
        ?>
	<div class="wrapper">
        <div class="form-box register">
				<h2>Gray Card Registration</h2>
				<form action="ministryofTransport.php" method="post">
					<div class="input-box">
						<span class="icon"><img src="pictures/user.png" style="height:30px; width:30px;"/></span>
						<input type="text" name="Owner">
						<label>Name of car owner<span style="color: red;">*</span></label>
					</div>
                    <div class="input-box">
						<span class="icon"><img src="pictures/user.png" style="height:30px; width:30px;"/></span>
						<input type="text" name="Dealer">
						<label>Name of Dealer<span style="color: red;">*</span></label>
					</div>
					<div class="input-box">
						<span class="icon"><img src="pictures/email.png"/></span>
						<input type="email" name="Email">
						<label>Car owner's Email<span style="color: red;">*</span></label>
					</div>
                    <div class="input-box"> 
						<span class="icon"><img src="pictures/registration.png" style="width:30px;height:30px;"/></span>
						<input type="text" name="carReg">
						<label>Car Registration Number<span style="color: red;">*</span></label>
					</div>
					<div class="input-box">
						<input type="date" name="Issuedate">
						<label>Issued Date<span style="color: red;">*</span></label>
					</div>
                    <div class="input-box">
						<input type="date" name="Expirydate">	
						<label>Expiry Date<span style="color: red;">*</span></label>
					</div>
					<input type="submit" name="register" class="btn" value="Register">
                    <div class="logout" style="text-align:end;margin-top:15px;">
					    <a href="admin_logout.php" class="logout-link">Done</a>
				    </div>
				</form>
		</div>
    </div>

</body>

</html>