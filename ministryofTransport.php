<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta bane="viewport" content="width=device-width,initial-scale=1.0">
    <link href="ministryofTransport.css" rel="stylesheet">
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

    <div class="wrapper">
        <?php
            if(isset($_POST["register"])){
                $Owner = $_POST["Owner"];
				$Dealer = $_POST["Dealer"];
				$Email = $_POST["Email"];
				$Issuedate = $_POST["Issuedate"];
				$Expirydate = $_POST["Expirydate"];

                $errors = array();
                if(empty($Owner) OR empty($Dealer) OR empty($Email) OR empty($Issuedate) OR empty($Expirydate)){
                    array_push($errors,"All fields are required");
                }
                if(!filter_var($Email,FILTER_VALIDATE_EMAIL)){
                    array_push($errors,"Invalid email");
                }
                if($Issuedate >= $Expirydate){
                    array_push($errors,"Invalid date");
                }
                if(count($errors)>0){
                    foreach ($errors as $error){
                        echo "<div class = 'alert alert-danger'>$error</div>";
                    }
                }else{
                    require_once("admin_connect.php");
                    $sql = "INSERT INTO car_num_entries (Owner,Dealer,Email,Issuedate,Expirydate) values(?,?,?,?,?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepare = mysqli_stmt_prepare($stmt,$sql);
                    if($prepare){
                        mysqli_stmt_bind_param($stmt,"sssss",$Owner,$Dealer,$Email,$Issuedate,$Expirydate);
                        mysqli_stmt_execute($stmt);
                        echo "<div class = 'alert alert-success'>You have registered successfully</div>";
                    }else{
                        die("Something went wrong");
                    }
                }
            }
        ?>
        <div class="form-box register">
				<h2>Gray Card Registration</h2>
				<form action="ministryofTransport.php" method="post">
					<div class="input-box">
						<input type="text" name="Owner" required>
						<label>Name of car owner</label>
					</div>
                    <div class="input-box">
						<input type="text" name="Dealer" required>
						<label>Name of Dealer</label>
					</div>
					<div class="input-box">
						<span class="icon"><img src="pictures/email.png"/></span>
						<input type="email" name="Email" required>
						<label>Car owner's Email</label>
					</div>
					<div class="input-box">
						<input type="date" name="Issuedate" required>
					</div>
                    <div class="input-box">
						<input type="date" name="Expirydate" required>	
					</div>
					<input type="submit" name="register" class="btn" value="Register">
				</form>
		</div>
    </div>

    <script src="registration_login.js"></script>
</body>

</html>