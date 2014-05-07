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
	$sql = "CREATE TABLE Responses(Response CHAR(100), FriendId INT, QuestionID Int)";

	if (mysqli_query($con,$sql)) {
	  echo "Table categories created successfully";
	} else {
	  echo "Error creating table: " . mysqli_error($con);
	}
	
	// $sql = "DELETE FROM Persons";

	// if (mysqli_query($con,$sql)) {
	  // echo "Table categories created successfully";
	// } else {
	  // echo "Error creating table: " . mysqli_error($con);
	// }
	
	// $result = mysqli_query($con,"SELECT * FROM Friends");

	// while($row = mysqli_fetch_array($result)) {
	  // print_r($row);
	  // echo "<br>";
	// }
	
	
?>