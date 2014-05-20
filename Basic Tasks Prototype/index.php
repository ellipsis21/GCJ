<html>
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
	</head>
	<body>
		<div class = "header"><a href="index.php"><img class="logo" src = "images/logo.png" /></a></div>
		<p class = "subheader">An easy way gather data from student groups!</p>
			<form id="myform" name="input" action="signin.php" enctype='multipart/form-data' method="post" style = "display: inline-block; text-align: center;">
				<input type='text' name='username' class='textbox' placeholder='Username' autocapitalize="off" required>
				<input type='password' name='password' class='textbox' placeholder='Password' required>
				<div><a class="main" onclick="document.getElementById('myform').submit();">Sign In</a>
				<a class="secondary" href="signup.html">Sign Up</a></div>
			</form>
		</div>
	</body>
</html>
