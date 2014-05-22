<?php 
	session_start(); 
	require "twilio-php-latest/Services/Twilio.php";
	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$id = $_POST["id"];
	$GroupId = $_POST["group"];
	$question = $_POST["question"];
	$type = $_POST["type"];

	if(!empty($_FILES['pic']['name'])) {
		$uploaddir = 'images/';
		$num = rand();
		$name = $_FILES["pic"]["name"][$key];
		$uploadfile = "$uploaddir$num.jpg";
		if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploadfile)) {
			$picFile = $uploadfile;
		} else {
			echo "Possible file upload attack!\n";
		}
	}
	else $picFile = "";

	if(!empty($_FILES['video']['name'])) {
		$uploaddir = 'videos/';
		$num = rand();
		$name = $_FILES["video"]["name"][$key];
		$uploadfile = "$uploaddir$num.mov";
		if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile)) {
			$vidFile = $uploadfile;
		} else {
			$vidFile = "";
			echo "Possible file upload attack!\n";
		}
	}
	else $vidFile = "";
	if(!mysqli_query($con,"INSERT INTO Questions (Question, PicPath, VidPath, GroupId, UserId, Open, Type) VALUES ('$question', '$picFile', '$vidFile', $GroupId, $id, 1, '$type')")) echo "failure! " . mysqli_error($con);
	$responses = [];
	$needed = [];
	if ($type == 'MC') {
		for ($count = 1; $count <= 6; $count++) {
			if (isset($_POST["response$count"])) {
				$responses[$count-1] = $_POST["response$count"];
			}
		}
	}
	if ($type == 'YN') {
		$responses[0] = "yes";
		$responses[1] = "no";
	}
	if ($type == 'TD') {
		for ($count = 1; $count <= 6; $count++) {
			if (isset($_POST["date$count"])) {
				$date = $_POST["date$count"];
				if ($date != "") {
					$date = date("D, M jS", strtotime($date));
					$responses[$count-1] = $date." at ".$_POST["time$count"];
				}
				else $responses[$count-1] = "";
			}
		}
	}
	if ($type == 'TC') {
		for ($count = 1; $count <= 6; $count++) {
			if (isset($_POST["task$count"])) {
				$task = $_POST["task$count"];
				if ($task != "") {
					$responses[$count-1] = $_POST["task$count"]." (".$_POST["need$count"]." needed)";
					$needed[$count-1] = $_POST["need$count"];
				}
				else {
					$needed[$count-1] = 0;
					$responses[$count-1] = "";
				}
			}
		}
	}
	$query = mysqli_query($con,"SELECT * FROM Questions WHERE GroupId='$GroupId' AND UserId='$id' AND Open=1");
	if($questions = mysqli_fetch_array($query)) {
		$qId = $questions['QuestionId'];
		$count = 1;
		if ($type == 'TC') {
			foreach($responses as $response) {
				if ($response != "") {
					if(!mysqli_query($con,"INSERT INTO Options (QuestionId, OptionNum, OptionText, Max) VALUES ($qId, $count, '$response', ".$needed[$count-1].")")) echo "failure! " . mysqli_error($con);
				}
				$count++;
			}
		}
		else {
			foreach($responses as $response) {
				if ($response != "") {
					if(!mysqli_query($con,"INSERT INTO Options (QuestionId, OptionNum, OptionText, Max) VALUES ($qId, $count, '$response', 0)")) echo "failure! " . mysqli_error($con);
				}
				$count++;
			}
		}
		$account_sid = 'ACe45cbecec1c4d969f362becc4dae5ce1'; 
		$auth_token = '2920745a17eb488e173b7ffe2310f958'; 
		$client = new Services_Twilio($account_sid, $auth_token); 
	 
		$url = "";
		
		if($picFile != "") $url= "http://ggreiner.com/cs247/bp/" . $picFile;
		
		$vid = "";
		
		if($vidFile != "") $vid= "http://ggreiner.com/cs247/bp/" . $vidFile;
		
		$body= "";
		
		if($type != "TC") $body.=$question.": "; 
		if($url != "") $body.= $url;
		if($vid != "") $body.= "\n$vid";
		$body.= "\n\n";
		if ($type == 'YN') {
			$body.= "Respond 'y' for Yes and 'n' for No.\n\n";
		}
		else {
			for ($count = 0; $count < 6; $count++) {
				$num = $count+1;
				if($responses[$count] != "")$body.= "Respond $num for: " . $responses[$count] . " \n\n";
				
			}
		}

		$numbers = [];
		$userName = "";
		
		$result = mysqli_query($con,"SELECT * FROM Members WHERE GroupId=$GroupId");
		while($row = mysqli_fetch_array($result)) {
			$number = "+1".$row['Phone'];
			$numbers[] = $number; 
		}
		$result = mysqli_query($con,"SELECT * FROM Users WHERE UserId=$id");
		if ($row = mysqli_fetch_array($result)) {
			$userName = $row['Name'];
		}
		
		if ($type != 'TC')$body = "Question from $userName: \n\n".$body;
		else $body = "$userName wants you to sign up for a task: \n\n".$body;
		if ($type == 'TD') $body.= " (Enter every date that works in the format '1,3,5')";
		elseif ($type == 'YN') $body.= " (You can enter a comment after your response)";
		else $body .= " (You can enter a comment after your # response).";

		if (!empty($numbers)) {
			foreach ($numbers as $n) {
				$sms = $client->account->messages->sendMessage("+17542108538", $n, $body);
			}
		}
	}
	mysqli_close($con);
	header("Location: questions.php?groupid=$GroupId");
?>