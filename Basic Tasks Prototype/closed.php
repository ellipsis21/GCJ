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
	
	$query = mysqli_query($con,"SELECT * FROM Questions WHERE GroupId='$GroupId' AND Open=0");
	$qIds = [];
	$qs = [];
	while($questions = mysqli_fetch_array($query)) {
		$qIds[] = $questions['QuestionId'];
		$qs[] = $questions['Question'];
	}
	if (count($qIds) != 0) {
		echo "<h3>Closed Questions for $groupname</h3>\n";
		for ($i = 0; $i < count($qIds); $i++) {
			$q = $qs[$i];
			$qId = $qIds[$i];
			echo "<div class='closedq'>$q</div>\n";
			echo '<a class="question-1" href="results.php?qId='.$qId.'">Results</a>';
			echo '<br>';
		}
	}
	else echo "<h3>$groupname has not asked any question before</h3>\n";
?>
	<div class="buffer"></div>
	<div class='group-home'><div class='home' onclick="location.href='grouphome.php?groupid=$GroupId';"><img class='navicon' src='images/home.png'/> GROUP HOME</div><div class='all' onclick="location.href='home.php';"><img class='navicon' src='images/group.png'/> ALL GROUPS </div> </div>
</html>
<?php mysqli_close($con); ?>