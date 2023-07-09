<?php
	session_start();
	session_destroy();
	header("location: registration_login.php");
?>