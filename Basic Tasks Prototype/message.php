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
		<p><a href = "login.php">Home</a> - <a href = "login.php">Questions</a></p>
		<h2 style="text-align: center;">Open Questions</h2>
			<?php
			if (isset($_GET["remove"])){
				$remove = intval($_GET['remove']);
				if(!mysqli_query($con,"DELETE FROM UQuestions WHERE PID=$remove")) echo "failure! " . mysqli_error($con);
			}
			if (isset($_POST["question"])){
				$question = $_POST["question"];
				$category = intval($_POST["category"]);
				$id = intval($_POST["id"]);
				$responses = [];
				for ($count = 1; $count <= 6; $count++) {
					if (isset($_POST["response$count"])) {
						$responses[$count-1] = $_POST["response$count"];
					}
				}

				if(!empty($_FILES['pic']['name'])) {
					$uploaddir = 'images/';
					$uploadfile = $uploaddir . basename($_FILES['pic']['name']);

					if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploadfile)) {
						$picFile = $uploadfile;
					} else {
						echo "Possible file upload attack!\n";
					}
				}
				else $picFile = "";

				if(!empty($_FILES['video']['name'])) {
					$uploaddir = 'videos/';
					$uploadfile = $uploaddir . basename($_FILES['video']['name']);

					if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile)) {
						$vidFile = $uploadfile;
					} else {
						$vidFile = "";
						echo "Possible file upload attack!\n";
					}
				}
				else $vidFile = "";
				if(!mysqli_query($con,"INSERT INTO UQuestions (Question, Response1, Response2, Response3, Response4, Response5, Response6, PicPath, VidPath, UserId, CatId) VALUES ('$question', '".$responses[0]."', '".$responses[1]."', '".$responses[2]."', '".$responses[3]."', '".$responses[4]."', '".$responses[5]."', '$picFile', '$vidFile', $id, $category)")) echo "failure! " . mysqli_error($con);
			}
			$id = $_SESSION['id'];
			$result = mysqli_query($con,"SELECT * FROM UQuestions WHERE UserId=$id");
			$count = 1;
			while($row = mysqli_fetch_array($result)) {
				$cat = $row['CatId'];
				$res = mysqli_query($con,"SELECT * FROM Categories WHERE PID=$cat");
				$ro = mysqli_fetch_array($res);
				$category = $ro['FirstName'];
				echo "<h3>Question $count to $category:</h3>".$row['Question']."<br><br>\n";
				echo "Response Options: <br>\n";
				for ($i = 0; $i < 6; $i++) {
					$num = $i + 1;
					if ($row['Response'.$num] != "") echo "$num: ".$row['Response'.$num]."<br>\n";
				}
				echo "<br>";
				if ($row['PicPath'] != "") {
					echo "Associated Picture: <br>\n";
					$pic = $row['PicPath'];
					echo "<img src = '$pic' style='max-width:100%' />\n";
				}
				if ($row['VidPath'] != "") {
					echo "Associated Video: <br>\n";
					$vid = $row['VidPath'];
					echo '<video width="320" height="240" controls><source src="'.$vid.'" type="video/mp4">Your browser does not support the video tag.</video>';
				}
				echo "<br><br>";
				echo "<input type='button' class='removebut' value = 'Close Question' onclick=\"location.href='?remove=".$row['PID']."'\"/>\n";
				echo "<br><br><br>";
				$count++;
			}
			?>
	</body>
</html>