<?php 

	session_start(); 
	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$groupid = $_GET['groupid'];
	$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Groups WHERE GroupId='$groupid'"));
	$groupname = $result['Name'];
	$warning = "";

	if (isset($_POST['admin'])) {
		$username = $_POST['admin'];
		$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Users WHERE Username='$username'"));
		if ($result) {
			$adminid = $result['UserId'];
			$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Admins WHERE UserId='$adminid' and GroupId = '$groupid'"));
			if (!$result) {
				mysqli_query($con, "INSERT INTO Admins (GroupId, UserId) VALUES ('$groupid', '$adminid')");
			}
		} else {
			$warning = "Username not found. Try again!";
		}
	}
?>
<html>
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
	</head>
	<body>
		<p><a href = "home.php">Home</a> - <a href = "message.php">Questions</a></p>

		<h3> List of admins for <?php echo $groupname ?> </h3>
		<?php 
			$result = mysqli_query($con,"SELECT * FROM Admins NATURAL JOIN Users WHERE GroupId = '$groupid'");
			while ($row =  mysqli_fetch_array($result)) {
				echo "<div>".$row['Name']."(".$row['Username'].")"."</div>";
			}
		?>



		<h3> Add a user to be a group admin </h3>
		<?php echo "<form id='myform' name='input' action='admin.php?groupid=".$groupid."' enctype='multipart/form-data' method='post' style = 'display: inline-block; text-align: center;'>"?>
			<input type='text' name='admin' class='textbox' required placeholder='Username' maxlength='10'/>
			<input type="submit" class="subbut" value="Add Admin"/>
		</form>
		<div> <?php echo $warning ?> </div>

	</body>
</html>