<?php 

	session_start(); 
	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$GroupId = $_GET['groupid'];
	$UserId = $_SESSION['UserId'];
	$result = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM Users Where UserId = $UserId"));
	$phone = $result["Phone"];

	mysqli_query($con, "DELETE FROM Members WHERE GroupId = '$GroupId' AND Phone = $phone");


	$result = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM Members WHERE GroupId = '$GroupId' AND Status = 1"));
	if ($result == null) {
		mysqli_query($con, "DELETE FROM Groups WHERE GroupId = '$GroupId'");
		mysqli_query($con, "DELETE FROM Members WHERE GroupId = '$GroupId'");
	}
	
	mysqli_close($con);

	header("Location: home.php");

?>