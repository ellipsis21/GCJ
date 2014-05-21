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
		<div class = "main-header"><a href="home.php"><img class="logo" src = "images/logo.png" /></a></div>
		<?php
			if ($_SESSION["NewUser"]) {
				echo '<p>Thanks for signing up, '.$row["Name"].'!</p>';
			} else {
				echo '<p>Welcome back '.$row["Name"].'!</p>';
			}
		?>
		<h3>Select a group to manage:</h3>
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
			$result = mysqli_query($con,"SELECT * FROM Users WHERE UserId='$UserId'");
			if($row = mysqli_fetch_array($result)) {
				$result = mysqli_query($con,"SELECT * FROM Groups NATURAL JOIN Admins WHERE UserId = '$UserId'");
				$count = 1;
				while ($row = mysqli_fetch_array($result)) {
					echo "<a class='group-$count' href='grouphome.php?groupid=".$row['GroupId']."'><div>".$row['Name']."</div><a>";
					if ($count == 5) $count = 1;
					else $count++;
			  	}
			}
		?>
		<div><a class="question-1" href="group.php">Create a new group</a></div>

	</body>
</html>