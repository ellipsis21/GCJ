<?php
    $con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $message = "";
    if (isset($_POST['phone']) and $_POST['password']) {
		$phone = mysqli_real_escape_string($con, $_POST['phone']);
		$password = mysqli_real_escape_string($con, $_POST['password']);

		$result = mysqli_query($con,"SELECT * FROM Users WHERE Phone = '$phone' AND Password = '$password'");
		$row = mysqli_fetch_array($result);

		if ($row == null) {
			$message = "Login Failed";
		} else {
			session_start(); 
			$_SESSION['UserId'] = $row["UserId"];
			$_SESSION['NewUser'] = False;
			header("Location: home.php");
		}
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
		<div class="loginbuffer"></div>
		<div class="header"><a href="index.php"><img class="logo" src = "images/logo.png" /></a></div>
		<div class="subheader">An easy way gather data from student groups!</div>
		<div class="home-1">Send Questions</div>
		<div class="home-sub">Ask members using various question types</div>
		<div class="home-2">Get Responses</div>
		<div class="home-sub">Members receive a text with a quick response option</div>
		<div class="home-3">See Results</div>
		<div class="home-sub">Results organized into graphs based on question type</div>
		<div>
			<a class="main" href="signup.html">Sign Up</a>
			<a class="secondary" href="signin.html">Sign In</a>
		</div>
	</body>
</html>
