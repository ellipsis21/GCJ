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
	// $sql = "CREATE TABLE UQuestions(PID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(PID), Question CHAR(10),Response1 CHAR(30),Response2 CHAR(30),Response3 CHAR(30),Response4 CHAR(30),Response5 CHAR(30),Response6 CHAR(30),PicPath CHAR(100),VidPath CHAR(100),UserId INT, CatId INT)";

	// if (mysqli_query($con,$sql)) {
	  // echo "Table categories created successfully";
	// } else {
	  // echo "Error creating table: " . mysqli_error($con);
	// }
	
	$sql = "DELETE FROM UQuestions";

	if (mysqli_query($con,$sql)) {
	  echo "Table categories created successfully";
	} else {
	  echo "Error creating table: " . mysqli_error($con);
	}
	
	
?>