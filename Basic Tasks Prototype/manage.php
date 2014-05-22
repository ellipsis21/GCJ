<?php 

	session_start(); 
	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$userid = $_SESSION['UserId'];
	$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Users WHERE UserId='$userid'"));
	$userphone = $result['Phone'];


	$groupid = $_GET['groupid'];
	if (isset($_GET['remove'])) {
		$memberphone = $_GET['remove'];
		mysqli_query($con, "DELETE FROM Members WHERE GroupId = '$groupid' AND Phone= '$memberphone'");
	}

	if (isset($_POST['name'])) {
		$membername = $_POST['name'];
		$memberphone = $_POST['number'];
		mysqli_query($con, "INSERT INTO Members(GroupId,Name,Phone) VALUES ('$groupid','$membername','$memberphone')");
	}

	$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Groups WHERE GroupId='$groupid'"));
	$groupname = $result['Name'];
	$result = mysqli_query($con,"SELECT * FROM Members WHERE GroupId='$groupid'");

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
		<h3>Add a New Member</h3>
		<?php
		echo "<form id='myform' name='input' action='manage.php?groupid=".$groupid."' enctype='multipart/form-data' method='post' style = 'display: inline-block; text-align: center;'>";
		?>
			<input type='text' name='name' class='textbox' required placeholder='Member name'/>
			<input type='tel' name='number' class='textbox' required placeholder='10 digit numbers'/>
			<a class="question-1" onclick="document.getElementById('myform').submit();">Add Member</a>
		</form>

		<h3 style="text-align: center;">Current Members of <?php echo $groupname ?></h3>
		<?php
			echo "<table class='mytable' align='center' style='text-align:center' cellpadding='5'>\n";
			echo "<tr>\n";
			echo "<th>Name</th>\n";
			echo "<th>Number</th>\n";
			echo "<th>Remove</th>\n";
			echo "</tr>\n";
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>\n";
				echo "<td>".$row["Name"]."</td>";
				echo "<td>".$row["Phone"]." </td>";
				echo "<td>";
				if ($row["Phone"] != $userphone) {
					echo "<a href='manage.php?groupid=".$groupid."&remove=".$row['Phone']."'>x</a>";
				}
				echo "</td>";
				echo "</tr>\n";
			}
			echo "</table>\n";
			echo "<div class='buffer'></div>";
			echo "<a class='group-home' href='grouphome.php?groupid=".$groupid."'>Group Home</a>";
		?>
		


	</body>
</html>
<?php mysqli_close($con); ?>