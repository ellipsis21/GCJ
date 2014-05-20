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
	$result = mysqli_query($con,"CREATE TABLE Members(GroupId INT, Name VARCHAR(30), Phone CHAR(10), UNIQUE(Phone))");
	$result = mysqli_query($con,"CREATE TABLE Questions(QuestionId INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(QuestionId), Question VARCHAR(200), PicPath VARCHAR(200), VidPath VARCHAR(200), GroupId INT, UserId INT)");
	$result = mysqli_query($con,"CREATE TABLE Options(QuestionId INT, OptionNum INT, OptionText VARCHAR(100), Max INT)");
	$result = mysqli_query($con,"CREATE TABLE Responses(QuestionID INT, Phone CHAR(10), Response VARCHAR(100))");
	*/


	$result = mysqli_query($con,"SELECT * FROM Admins");
	
	while($row = mysqli_fetch_array($result)) {
	  print_r($row);
	  echo "<br>";
	}
	



?>