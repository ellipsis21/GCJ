<?php 

	session_start(); 
	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$GroupId = $_GET['groupid'];
	$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Groups WHERE GroupId='$GroupId'"));
	$groupname = $result['Name'];

?>
<html>
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
	</head>
	<body>
		<div class = "main-header"><a href="home.php"><img class="logo" src = "images/logo.png" /></a></div>
		<h2><?php echo $groupname?></h2>
		<div><a class="group-1" href='questions.php?groupid=<?php echo $GroupId ?>'>Ask Question to Members</a></div>
		<div><a class="group-2" href='announcement.php?groupid=<?php echo $GroupId ?>'>Send Announcement to Members</a></div>
		<div><a class="group-3" href='admin.php?groupid=<?php echo $GroupId ?>'>Invite Admin</a></div>
		<div><a class="group-4" href='manage.php?groupid=<?php echo $GroupId ?>'>Manage Members</a></div>
		<div><a class="question-1" href='quitgroup.php?groupid=<?php echo $GroupId ?>'>Quit Group</a></div>
	</body>
</html>