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
		<script language="javascript">
			var count = 2;
			function AddResOpt() {
				if (count > 10) alert("You can only add 10 numbers!");
				else {
					document.getElementById("number" + count).setAttribute('type','tel');
					document.getElementById("number" + count).focus();
					document.getElementById("number" + count).select();
					count++;
				}
			}
		</script>
	</head>
	<body>
		<h2 style="text-align: center;">Add friends to <?php echo $cat ?>!</h2>
		<form id="myform" name="input" action="login.php" enctype='multipart/form-data' method="post" style = "display: inline-block; text-align: center;">
			<input type='tel' name='number1' class='textbox' placeholder='10 digit numbers'/>
			<input type='hidden' id='number2' name='number2' class='textbox' placeholder='10 digit numbers'/>
			<input type='hidden' id='number3' name='number3' class='textbox' placeholder='10 digit numbers'/>
			<input type='hidden' id='number4' name='number4' class='textbox' placeholder='10 digit numbers'/>
			<input type='hidden' id='number5' name='number5' class='textbox' placeholder='10 digit numbers'/>
			<input type='hidden' id='number6' name='number6' class='textbox' placeholder='10 digit numbers'/>
			<input type='hidden' id='number7' name='number7' class='textbox' placeholder='10 digit numbers'/>
			<input type='hidden' id='number8' name='number8' class='textbox' placeholder='10 digit numbers'/>
			<input type='hidden' id='number9' name='number9' class='textbox' placeholder='10 digit numbers'/>
			<input type='hidden' id='number10' name='number10' class='textbox' placeholder='10 digit numbers'/>
			<input type='button' class='subbut' value = 'Add Number' onclick='AddResOpt()'/>
			<input type='hidden' name='category' value='<?php echo $cat ?>'/>
			<br>
			<input type="submit" class="subbut" value="Add"/>
		</form>
	</body>
</html>