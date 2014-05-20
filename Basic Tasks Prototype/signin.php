<?php
    $con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

	$username = mysqli_real_escape_string($con, $_POST['username']);
	$password = mysqli_real_escape_string($con, $_POST['password']);

	$result = mysqli_query($con,"SELECT * FROM Users WHERE Username = '$username' AND Password = '$password'");
	$row = mysqli_fetch_array($result);

	if ($row == null) {
		echo "Login failed.";
	} else {
		session_start(); 
		$_SESSION['UserId'] = $row["UserId"];
		$_SESSION['NewUser'] = False;
		header("Location: home.php");
	}

?>