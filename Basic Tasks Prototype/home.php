<?php 

	session_start(); 
	if (!isset($_SESSION['UserId'])) header("Location: index.php");
	$UserId = $_SESSION['UserId'];
	if ($UserId == "") header("Location: index.php");
	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

?>
<html>
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
	</head>
	<body>
		<div class = "main-header"><a href="home.php"><img class="logo" src = "images/logo.png" /></a></div>
		<?php
			$result = mysqli_query($con,"SELECT * FROM Users WHERE UserId='$UserId'");
			if($row = mysqli_fetch_array($result)) {
				if ($_SESSION["NewUser"]) {
					echo "<div class='welcome'>Thanks for signing up, ".$row["Name"]."!</div>";
				} 
			}
		?>
		<h3>Select a student group</h3>
		<?php
			$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Users WHERE UserId='$UserId'"));
			$phone = $result["Phone"];

			if($phone) {
				$result = mysqli_query($con,"SELECT * From Groups WHERE GroupId in (SELECT GroupId from Members WHERE Phone = $phone and Status = 1)");


				if (mysqli_num_rows($result) == 0) {
					echo "<div class='nogroup'>You don't have any groups. <br/> Create one to get started.</div>";
				} else { 
					$count = 1;
					while ($row = mysqli_fetch_array($result)) {
						echo "<div><a class='group-$count' href='grouphome.php?groupid=".$row['GroupId']."'><div>".$row['Name']."</div><a></div>";
						if ($count == 5) $count = 1;
						else $count++;
				  	}
				}
			  	
			}
		?>
		<div><a class="question-1" href="group.php">Create a new group</a></div>

	</body>
</html>
<?php mysqli_close($con); ?>