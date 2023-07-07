<?php
	$hostname = "localhost";
	$dbUser = "root";
	$dbPassword = "";
	$dbName = "road_agent";
	$conn = mysqli_connect($hostname, $dbUser, $dbPassword, $dbName);
	if(!$conn){
		die("Something went wrong!!");
	}
?>