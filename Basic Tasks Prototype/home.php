<?php 

	session_start(); 
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
		<p><a href = "home.php">Home</a> - <a href = "message.php">Questions</a></p>
		<h2 style="text-align: center;">Select/Create a Friend Category to Send To!</h2>
		<?php
			/*
			$name = "";
			if (isset($_POST['name'])) {
				$name = $_POST['name'];
				 $_SESSION['name'] = $name;
			}
			else $name = $_SESSION['name'];
			if (isset($_POST['number1'])) {
				$category = $_POST['category'];
				$all = array();
				for ($i = 1; $i <= 10; $i++) {
					$all[] = $_POST["number$i"];
				}
				$id = $_SESSION['id'];
				$result = mysqli_query($con,"SELECT * FROM Categories WHERE FirstName='$category' AND UserId=$id");
				$row = mysqli_fetch_array($result);
				$catId = $row["PID"];
				foreach ($all as $number) {
					trim($number);
					$num = 0;
					$result = mysqli_query($con,"SELECT * FROM Friends WHERE Phone='$number'");
					$num = mysqli_num_rows($result);
					if ($num == 0) {
						if ($number != "")
							if(!mysqli_query($con,"INSERT INTO Friends (FirstName, LastName, Phone, UserId, CatId) VALUES ('John', 'Doe', '+1$number', $id, $catId)")) echo "failure! " . mysqli_error($con);
							if(!mysqli_query($con,"INSERT INTO FCategories (Phone, UserId, CatId) VALUES ('+1$number', $id, $catId)")) echo "failure! " . mysqli_error($con);
					}
				}
			}
			if (isset($_GET['remove'])) {
				$remove = $_GET['remove'];
				$id = $_SESSION['id'];
				$result = mysqli_query($con,"SELECT * FROM Categories WHERE FirstName='$remove' AND UserId=$id");
				$row = mysqli_fetch_array($result);
				$catId = $row["PID"];
				$friends = mysqli_query($con,"SELECT * FROM Friends WHERE UserId=$id AND CatId=$catId");
				while($friend = mysqli_fetch_array($friends)) {
					$fid = $friend['PID'];
					if(!mysqli_query($con,"DELETE FROM Responses WHERE FriendId=$fid")) echo "failure! " . mysqli_error($con);
				}
				if(!mysqli_query($con,"DELETE FROM Friends WHERE UserId=$id AND CatId=$catId")) echo "failure! " . mysqli_error($con);
				if(!mysqli_query($con,"DELETE FROM Categories WHERE Firstname='$remove' AND UserId=$id")) echo "failure! " . mysqli_error($con);
				if(!mysqli_query($con,"DELETE FROM UQuestions WHERE UserId=$id AND CatId=$catId")) echo "failure! " . mysqli_error($con);
			}
			*/
			
			$UserId = $_SESSION['UserId'];
			echo $UserId;
			$result = mysqli_query($con,"SELECT * FROM Users WHERE UserId='$UserId'");
			if($row = mysqli_fetch_array($result)) {
				if ($_SESSION["NewUser"]) {
					echo '<p style="text-align: center;">Thanks for signing up, '.$row["Name"].'!</p>';
				} else {
					echo '<p style="text-align: center;">Welcome back '.$row["Name"].'!</p>';
				}

				$result = mysqli_query($con,"SELECT * FROM Groups NATURAL JOIN Admins WHERE UserId = '$UserId'");
				while ($row = mysqli_fetch_array($result)) {
					echo "<form><input type='button' class='catbut' value = '".$row['Name']."' onclick=\"location.href='send.php?cat=".$row['Name']."'\"/></form>\n";
			  	}
			}
		?>
		<div><a href="group.php">Create a new group</a></div>


	</body>
</html>