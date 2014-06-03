<?php
	session_start(); 
	require "twilio-php-latest/Services/Twilio.php";
	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$GroupId = $_POST['gId'];
	$QuestionId = $_POST['qId'];
	$msg = $_POST['message'];


	$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Members WHERE GroupId=$GroupId"));
	$GroupName = $result["Name"];
	$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Questions WHERE QuestionId=QuestionId"));
	$Question = $result["Question"];

	$UserId = $_SESSION['UserId'];
	$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Users WHERE UserId='$UserId'"));
	$UserName = $result["Name"];

	$curUrl = "http://ggreiner.com/cs247/bp/results.php?qId=$QuestionId&share";

	$account_sid = 'ACe45cbecec1c4d969f362becc4dae5ce1'; 
	$auth_token = '2920745a17eb488e173b7ffe2310f958'; 
	$client = new Services_Twilio($account_sid, $auth_token); 

	$result = mysqli_query($con,"SELECT * FROM Members WHERE GroupId=$GroupId");
	$body = "[ $UserName sent you Result Summary for $Question on TellMeNow ]\n\n";
	$body .= "$msg\n\n";
	$body .= $curUrl;

	while($row = mysqli_fetch_array($result)) {
		$sms = $client->account->messages->sendMessage("+17542108538", $row['Phone'], $body);
	}
	mysqli_close($con);
	header("Location: results.php?qId=$QuestionId");
?>