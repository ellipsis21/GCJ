<html>
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
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
	if($questions = mysqli_fetch_array($query){
		$qId = $questions['QuestionId'];
		$q = $questions['Question'];
		echo "<h3>Open Question</h3>\n";
		echo "<h4>$q</h4>\n";
		echo '<a class="question-1" href="results.php?qId='.$qId.'">Results</a>\n';
	}
	else {
?>
		<h3>Choose a Question Type</h3>
		<a class="question-1" href="question-1.php?groupid=<?php echo $GroupId ?>">Multiple Choice</a>
		<a class="question-2" href="question-2.php?groupid=<?php echo $GroupId ?>">Yes/No</a>
		<a class="question-3" href="question-3.php?groupid=<?php echo $GroupId ?>">Task Assignment</a>
		<a class="question-4" href="question-4.php?groupid=<?php echo $GroupId ?>">Date Choice</a>
<?php } ?>
	</body>
</html>