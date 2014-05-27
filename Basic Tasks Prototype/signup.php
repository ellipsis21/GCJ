<?php
    $con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

	$name = mysqli_real_escape_string($con, $_POST['name']);
	$phone = mysqli_real_escape_string($con, $_POST['phonenum']);
	$password = mysqli_real_escape_string($con, $_POST['password']);

	$result = mysqli_query($con,"INSERT INTO Users (Name, Phone, Password) VALUES('$name', '$phone', '$password')");

	$result = mysqli_query($con,"SELECT UserId FROM Users WHERE Phone = '$phone'");
	$row = mysqli_fetch_array($result);
	$UserId = $row["UserId"];

	mysqli_close($con);

	session_start(); 
	$_SESSION['UserId'] = $UserId;
	$_SESSION['NewUser'] = True;

	header("Location: home.php");

?>