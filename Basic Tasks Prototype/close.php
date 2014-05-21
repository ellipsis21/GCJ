<?php

	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$qid = $_GET['qId'];
	
	mysqli_query($con,"UPDATE Questions SET Open=0 WHERE QuestionId=$qId");
	
	mysqli_close($con);
	$GroupId = $_GET['gId'];
	header("Location: questions.php?groupid=$GroupId");

?>