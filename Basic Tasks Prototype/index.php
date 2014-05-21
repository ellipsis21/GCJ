<?php
    $con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $message = "";
    if (isset($_POST['username']) and $_POST['password']) {
		$username = mysqli_real_escape_string($con, $_POST['username']);
		$password = mysqli_real_escape_string($con, $_POST['password']);

		$result = mysqli_query($con,"SELECT * FROM Users WHERE Username = '$username' AND Password = '$password'");
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
?>

<html>
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
	</head>
	<body>
		<div class="outer">
		<div class="middle">
		<div class="inner">
		<div class = "header"><a href="index.php"><img class="logo" src = "images/logo.png" /></a></div>
		<p class = "subheader">An easy way gather data from student groups!</p>
			<div class="warning"><?php echo $message ?></div>
			<form id="myform" name="input" action="index.php" enctype='multipart/form-data' method="post" style = "display: inline-block; text-align: center;">
				<input type='text' name='username' class='textbox' placeholder='Username' autocapitalize="off" required>
				<input type='password' name='password' class='textbox' placeholder='Password' required>
				<div><a class="main" onclick="document.getElementById('myform').submit();">Sign In</a>
				<a class="secondary" href="signup.html">Sign Up</a></div>
			</form>
		</div>
		</div>
		</div>
	</body>
</html>
