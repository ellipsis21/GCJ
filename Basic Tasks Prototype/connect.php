<?php

	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	/*
	$result = mysqli_quety($con,"CREATE TABLE Users(UserId INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(UserId), Phone CHAR(10), Name VARCHAR(30), Username VARCHAR(10), UNIQUE(UserName), Password VARCHAR(10))");
	$result = mysqli_query($con,"CREATE TABLE Groups(GroupId INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(GroupId), Name VARCHAR(30))");
	$result = mysqli_query($con,"CREATE TABLE Admins(GroupId INT, UserId INT)");
	$result = mysqli_query($con,"CREATE TABLE Members(GroupId INT, Name VARCHAR(30), Phone CHAR(10), PRIMARY KEY(Phone, GroupId))");
	$result = mysqli_query($con,"CREATE TABLE Questions(QuestionId INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(QuestionId), Question VARCHAR(200), PicPath VARCHAR(200), VidPath VARCHAR(200), GroupId INT, Open TINYINT(1))");
	$result = mysqli_query($con,"CREATE TABLE Options(QuestionId INT, OptionNum INT, OptionText VARCHAR(100), Max INT)");
	$result = mysqli_query($con,"CREATE TABLE Responses(QuestionId INT, Phone CHAR(10), Response VARCHAR(100))");
	*/


	//$result = mysqli_query($con,"CREATE TABLE Questions(QuestionId INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(QuestionId), Type CHAR(2), Question VARCHAR(200), PicPath VARCHAR(200), VidPath VARCHAR(200), GroupId INT, UserId INT)");
	//$result = mysqli_query($con,"DROP TABLE Responses");
	//$result = mysqli_query($con,"CREATE TABLE Responses(QuestionId INT, Phone CHAR(10), Response VARCHAR(100))");

	//if(!mysqli_query($con,"INSERT INTO// Questions (Type, Question, GroupId, UserId) VALUES ('MC', 'What is your favorite Color?', 27, 1)")) echo "failure! " . mysqli_error($con);

	//if (!$mysqli_query($con,"INSERT INTO Questions(Type, Question, GroupId, UserId, Open) VALUES ('MC', 'What is your favorite Color?', 27, 1, 1)")) echo mysqli_error($con);

	//if(!mysqli_query($con,"INSERT INTO// Questions (Type, Question, GroupId, UserId) VALUES ('MC', 'What is your favorite Color?', 27, 1)")) echo "failure! " . mysqli_error($con);

	//$result = mysqli_query($con,"DELETE FROM Options WHERE QuestionId = 1");

	//$result = mysqli_query($con,"DELETE FROM Responses WHERE QuestionId = 1");

	//$result = mysqli_query($con,"DROP TABLE Questions");

	//$result = mysqli_query($con,"CREATE TABLE Questions(QuestionId INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(QuestionId), Type CHAR(2), Question VARCHAR(200), PicPath VARCHAR(200), VidPath VARCHAR(200), GroupId INT, UserId INT, Open TINYINT(1))");

	/*
	$result = mysqli_query($con,"INSERT INTO Options (QuestionId, OptionNum, OptionText) VALUES (1, 1, 'Red')");
	$result = mysqli_query($con,"INSERT INTO Options (QuestionId, OptionNum, OptionText) VALUES (1, 2, 'Blue')");
	$result = mysqli_query($con,"INSERT INTO Options (QuestionId, OptionNum, OptionText) VALUES (1, 3, 'Yellow')");

	
	$result = mysqli_query($con,"INSERT INTO Questions(Type, Question, GroupId, UserId, Open) VALUES ('MC', 'What is your favorite Color?', 27, 1, 1)");
	if (!$result) {
		echo mysqli_error($con);
	}
	
	$result = mysqli_query($con,"INSERT INTO Responses (QuestionId, Response, Phone) VALUES (1, '2', '2222')");
	$result = mysqli_query($con,"INSERT INTO Responses (QuestionId, Response, Phone) VALUES (1, '2', '3333')");
	$result = mysqli_query($con,"INSERT INTO Responses (QuestionId, Response, Phone) VALUES (1, '2', '4444')");
	$result = mysqli_query($con,"INSERT INTO Responses (QuestionId, Response, Phone) VALUES (1, 'Hello! This is cool', '4444')");
	$result = mysqli_query($con,"INSERT INTO Responses (QuestionId, Response, Phone) VALUES (1, 'Much cool Much cool', '4444')");
	$result = mysqli_query($con,"INSERT INTO Responses (QuestionId, Response, Phone) VALUES (1, '2 Much cool Much cool', '4444')");

	
	*/
	$result = mysqli_query($con, "SELECT * FROM Responses");
	while($row = mysqli_fetch_array($result)) {
	  print_r($row);
	  echo "<br>";
	}
	



?>