<?php
    $con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

	session_start(); 
	$userid = $_SESSION['UserId'];
	if (isset($_POST['groupname'])) {
		// Insert new group
		$groupname = $_POST['groupname'];
		if(!mysqli_query($con,"INSERT INTO Groups (Name) VALUES ('$groupname')")) echo "failure! " . mysqli_error($con);

		$result = mysqli_fetch_array(mysqli_query($con, "SELECT MAX(GroupId) FROM Groups"));
		$groupid = $result[0];

		// Insert self into Members as Admin
		$result = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM Users WHERE UserId = '$userid'"));
		$name = $result["Name"];
		$phone = $result["Phone"];
		if(!mysqli_query($con,"INSERT INTO Members (GroupId, Name, Phone, Status) VALUES ('$groupid','$name','$phone', 1)")) echo "failure! " . mysqli_error($con);

		header("Location: manage.php?groupid=$groupid");
	}
	mysqli_close($con);
?>


<html>
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />

	</head>

	<body>
		<div class = "main-header"><a href="home.php"><img class="logo" src = "images/logo.png" /></a></div>
		<form id="myform" name="input" action="group.php" enctype='multipart/form-data' method="post" style = "display: inline-block; text-align: center;">
			<h3>Enter your group name</h3>

			<input type='text' name='groupname' class='textbox' placeholder='Group Name' autocapitalize="off" required>

			<a class="question-1" onclick="document.getElementById('myform').submit();">Create Group</a>
		</form>

	</body>
</html>