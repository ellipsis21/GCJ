<?php

	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	/*
	$result = mysqli_quety($con,"CREATE TABLE Users(UserId INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(UserId), Phone CHAR(10), Name VARCHAR(30), UNIQUE(Phone), Password VARCHAR(10))");
	$result = mysqli_query($con,"CREATE TABLE Groups(GroupId INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(GroupId), Name VARCHAR(50))");
	$result = mysqli_query($con,"CREATE TABLE Members(GroupId INT, Name VARCHAR(30), Phone CHAR(10), PRIMARY KEY(Phone, GroupId, Status TINYINT(1)))");

	STATUS 1 - Admin
	STATUS 0 - General Member
	STATUS 2 - Member who quit

	$result = mysqli_query($con,"CREATE TABLE Questions(QuestionId INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(QuestionId), Type CHAR(2), Question VARCHAR(200), PicPath VARCHAR(200), VidPath VARCHAR(200), GroupId INT, UserId INT, Open TINYINT(1))");
	$result = mysqli_query($con,"CREATE TABLE Options(QuestionId INT, OptionNum INT, OptionText VARCHAR(100), Max INT)");
	$result = mysqli_query($con,"CREATE TABLE Responses(QuestionId INT, Phone CHAR(10), Response VARCHAR(100))");
	*/


	/*
	$result = mysqli_query($con,"INSERT INTO Options (QuestionId, OptionNum, OptionText) VALUES (1, 1, 'Red')");
	$result = mysqli_query($con,"INSERT INTO Options (QuestionId, OptionNum, OptionText) VALUES (1, 2, 'Blue')");
	$result = mysqli_query($con,"INSERT INTO Options (QuestionId, OptionNum, OptionText) VALUES (1, 3, 'Yellow')");

	
	$result = mysqli_query($con,"INSERT INTO Questions(Type, Question, GroupId, UserId, Open) VALUES ('MC', 'What is your favorite Color?', 27, 1, 1)");
	if (!$result) {
		echo mysqli_error($con);
	}
	*/

	$result = mysqli_query($con, "SELECT * FROM Members WHERE GroupId = 54");

	while($row = mysqli_fetch_array($result)) {
	  print_r($row);
	}
	
	mysqli_close($con);
?>
