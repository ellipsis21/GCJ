<?php 

session_start(); 
$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$cat = $_POST['category'];

$name = $_SESSION['name'];
$category = $_POST['category'];
$result = mysqli_query($con,"SELECT * FROM Persons WHERE FirstName='$name'");
$row = mysqli_fetch_array($result);
$id = $row["PID"];
if(!mysqli_query($con,"INSERT INTO Categories (FirstName, UserId) VALUES ('$category', $id)")) echo "failure! " . mysqli_error($con);

?>
<html>
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
	</head>
	<body>
		<h2 style="text-align: center;">Add friends to <?php echo $cat ?>!</h2>
		<form id="myform" name="input" action="login.php" enctype='multipart/form-data' method="post" style = "display: inline-block; text-align: center;">
			<input type='text' name='numbers' class='textbox' placeholder='10 digit numbers seperated by commas'/>
			<input type='hidden' name='category' value='<?php echo $cat ?>'/>
			<input type="submit" class="subbut" value="Add"/>
		</form>
	</body>
</html>