<?php
	session_start(); 
	require "twilio-php-latest/Services/Twilio.php";
	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$GroupId = $_GET['gId'];
	$qId = $_GET['qId'];
	$UserId = $_SESSION['UserId'];
	$result = mysqli_query($con,"SELECT * FROM Users WHERE UserId=$UserId");
	$row = mysqli_fetch_array($result);
	$name = $row["Name"]; 
	$result = mysqli_query($con,"SELECT * FROM Responses WHERE QuestionId=$qId");
	$responders = [];
	while($row = mysqli_fetch_array($result)) {
		$responders[] = $row['Phone']; 
	}
	$account_sid = 'ACe45cbecec1c4d969f362becc4dae5ce1'; 
	$auth_token = '2920745a17eb488e173b7ffe2310f958'; 
	$client = new Services_Twilio($account_sid, $auth_token); 
	$result = mysqli_query($con,"SELECT * FROM Members WHERE GroupId=$GroupId");
	$body = "$name sent a reminder to answer the question previous question!";
	while($row = mysqli_fetch_array($result)) {
		if (!in_array($row['Phone'], $responders)) {
			$sms = $client->account->messages->sendMessage("+17542108538", $row['Phone'], $body);
		}
	}
	mysqli_close($con);
	header("Location: questions.php?groupid=$GroupId&reminder");
?>