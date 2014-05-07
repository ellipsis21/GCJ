<?php

	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	// $result = mysqli_query($con,"SELECT * FROM Friends");
	  // while($row = mysqli_fetch_array($result)) {
		// echo "FirstName: ".$row['FirstName']." LastName: ".$row['LastName']." Phone: ".$row['Phone']." UserId: ".$row['UserId']." CatId: ".$row['CatId']."<br>";
	  // }
	
	// Create table
	// $sql = "CREATE TABLE FCategories(PID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(PID), Phone CHAR(10), UserID INT, CatID INT)";

	// if (mysqli_query($con,$sql)) {
	  // echo "Table categories created successfully";
	// } else {
	  // echo "Error creating table: " . mysqli_error($con);
	// }
	
	// $sql = "DELETE FROM Responses";

	// if (mysqli_query($con,$sql)) {
	  // echo "Table categories created successfully";
	// } else {
	  // echo "Error creating table: " . mysqli_error($con);
	// }
	
	// if(!mysqli_query($con,"INSERT INTO Responses (Response, QuestionId, FriendId) VALUES ('1 COMMENT', 14, 64)")) echo "failure! " . mysqli_error($con);
	// if(!mysqli_query($con,"INSERT INTO Responses (Response, QuestionId, FriendId) VALUES ('2 COMMENT', 14, 65)")) echo "failure! " . mysqli_error($con);
	// if(!mysqli_query($con,"INSERT INTO Responses (Response, QuestionId, FriendId) VALUES ('3 COMMENT', 14, 66)")) echo "failure! " . mysqli_error($con);
	// if(!mysqli_query($con,"INSERT INTO Responses (Response, QuestionId, FriendId) VALUES ('3 COMMENT', 14, 67)")) echo "failure! " . mysqli_error($con);
	// if(!mysqli_query($con,"INSERT INTO Responses (Response, QuestionId, FriendId) VALUES ('3 COMMENT', 14, 68)")) echo "failure! " . mysqli_error($con);
	// if(!mysqli_query($con,"INSERT INTO Responses (Response, QuestionId, FriendId) VALUES ('2 COMMENT', 14, 69)")) echo "failure! " . mysqli_error($con);
	// if(!mysqli_query($con,"INSERT INTO Responses (Response, QuestionId, FriendId) VALUES ('3 COMMENT', 14, 70)")) echo "failure! " . mysqli_error($con);
	// if(!mysqli_query($con,"INSERT INTO Responses (Response, QuestionId, FriendId) VALUES ('2 COMMENT', 14, 71)")) echo "failure! " . mysqli_error($con);
	// if(!mysqli_query($con,"INSERT INTO Responses (Response, QuestionId, FriendId) VALUES ('1 COMMENT', 14, 72)")) echo "failure! " . mysqli_error($con);
	
	$result = mysqli_query($con,"SELECT * FROM Friends");

	while($row = mysqli_fetch_array($result)) {
	  print_r($row);
	  echo "<br>";
	}
	
	
?>