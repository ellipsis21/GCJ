<html>
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="questions.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
	</head>
	<body>
	<div class = "main-header"><a href="home.php"><img class="logo" src = "images/logo.png" /></a></div>
<?php
	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$GroupId = $_GET['groupid'];
	$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Groups WHERE GroupId='$GroupId'"));
	$groupname = $result['Name'];
	
	$query = mysqli_query($con,"SELECT * FROM Questions WHERE GroupId='$GroupId' AND Open=1");
	if($questions = mysqli_fetch_array($query)) {
		$qId = $questions['QuestionId'];
		$q = $questions['Question'];
		echo "<h2>Open Question</h2>\n";
		echo "<h3>$q</h3>\n";
		echo '<a class="question-1" href="results.php?qId='.$qId.'">Results</a>';
		echo '<a class="question-2" href="reminder.php?qId='.$qId.'&gId='.$GroupId.'">Send Reminder</a>';
		echo '<a class="question-5" href="close.php?qId='.$qId.'&gId='.$GroupId.'" style="margin:20px">Close Poll</a>';
		echo "<div class='buffer'></div>";
	}
	else {
?>
		<h3>Choose a Question Type</h3>
		<a class="question-1" href="question-1.php?groupid=<?php echo $GroupId ?>">Multiple Choice</a>
		<a class="question-2" href="question-2.php?groupid=<?php echo $GroupId ?>">Yes/No</a>
		<a class="question-3" href="question-4.php?groupid=<?php echo $GroupId ?>">Date Choice</a>
		<div class='buffer'></div>
<?php }
 ?>
	<div class='group-home'><div class='home' onclick="location.href='grouphome.php?groupid=<?php echo $GroupId;?>';"><img class='navicon' src='images/home.png'/> GROUP HOME</div><div class='all' onclick="location.href='home.php';"><img class='navicon' src='images/group.png'/> ALL GROUPS </div> </div>
	<div class="warningmessage">Reminder sent!</div>
	<?php
		if (isset($_GET['reminder'])) {
			echo '<script> $(".warningmessage").fadeIn().delay(3600).fadeOut(); </script>';
		}
	?>
	</body>
</html>
<?php mysqli_close($con); ?>