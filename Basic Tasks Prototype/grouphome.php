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
		<p><a href = "home.php">Home</a> - <a href = "message.php">Questions</a></p>
		<h2><?php echo $groupname?></h2>
		<div><a href='question.php?groupid=<?php echo $GroupId ?>'>Ask Question to Members</div>
		<div><a href='announcement.php?groupid=<?php echo $GroupId ?>'>Send Announcement to Members</div>
		<div><a href='admin.php?groupid=<?php echo $GroupId ?>'>Invite Admin</div>
		<div><a href='manage.php?groupid=<?php echo $GroupId ?>'>Manage Members</div>
		<div><a href='quitgroup.php?groupid=<?php echo $GroupId ?>'>Quit Group</div>
	</body>
</html>