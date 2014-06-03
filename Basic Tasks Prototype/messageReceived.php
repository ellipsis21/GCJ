<?php
    require "twilio-php-latest/Services/Twilio.php";
    session_start(); 
    $con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

	//get user responce
    $message= $_REQUEST['Body'];
    $number= $_REQUEST['From'];
	$number = substr($number, 2);
    //GCJ put responce in DB
    $res = mysqli_query($con,"SELECT * FROM Members WHERE Phone='$number'");

    //assumes phone number is unique
    if($row = mysqli_fetch_array($res)) {
		if ($message == "STOP") {
			$res = mysqli_query($con,"DELETE FROM Members WHERE Phone='$number'");
		}
		else {
			$GroupId= $row['GroupId'];
			$result = mysqli_query($con,"SELECT * FROM Questions WHERE GroupId=$GroupId AND Open=1");
			
			if($column = mysqli_fetch_array($result)) {
				$qId= $column['QuestionId'];
				if(!mysqli_query($con,"INSERT INTO Responses (QuestionID, Phone, Response) VALUES ('$qId', '$number', '$message')")) echo "failure! " . mysqli_error($con);
			}
		}
	}
    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    mysqli_close($con);

    //can have Responce after php code depending on cost of texts
?> 