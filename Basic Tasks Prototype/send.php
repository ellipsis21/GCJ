<?php 

session_start(); 
$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>

<html>	
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<script language="javascript">
			function scroll() {
				window.scrollTo(0,0);
			}
			var count = 3;
			function AddResOpt() {
				if (count > 6) alert("You can only add 6 options!");
				else {
					document.getElementById("response" + count).setAttribute('type','text');
					document.getElementById("response" + count).focus();
					document.getElementById("response" + count).select();
					count++;
				}
			}
		</script>
	</head>
	<body onload="scroll()">
<?php
	if(isset($_GET["cat"])) {
		$category = $_GET["cat"];
		$id = $_SESSION['id']; 
		echo '<p><a href = "login.php">Home</a> - <a href = "message.php">Questions</a></p>';
		echo "<h2>Get the Opinions of your Group: $category</h2>\n";
		$result = mysqli_query($con,"SELECT * FROM Categories WHERE FirstName='$category' AND UserId=$id");
		$row = mysqli_fetch_array($result);
		$catId = $row["PID"];
		echo '<form id="myform" name="messager" action="message.php" enctype="multipart/form-data" method="post" style = "display: inline-block; text-align: center;">';
		echo "<input type='hidden' id='hidden' name='hidden' class='textbox' placeholder='hidden' />\n";
		echo "<input type='text' id='question' name='question' class='textbox' placeholder='Question' />\n";
		echo "<input type='text' name='response1' class='textbox' placeholder='Response Option' />\n";
		echo "<input type='text' name='response2' class='textbox' placeholder='Response Option' />\n";
		echo "<input type='hidden' id='response3' name='response3' class='textbox' placeholder='Response Option' />\n";
		echo "<input type='hidden' id='response4' name='response4' class='textbox' placeholder='Response Option' />\n";
		echo "<input type='hidden' id='response5' name='response5' class='textbox' placeholder='Response Option' />\n";
		echo "<input type='hidden' id='response6' name='response6' class='textbox' placeholder='Response Option' />\n";
		echo "<input type='hidden' name='category' value='$catId' />\n";
		echo "<input type='hidden' name='id' value='$id' />\n";
		echo "<input type='button' class='subbut' value = 'Add Option' onclick='AddResOpt()'/>\n";
		echo "<br>";
		echo '<br><input name = "pic" type="file" accept="image/*" capture="camera" class="button">';
		echo '<br><input name = "video" type="file" accept="video/*" capture="camera" class="button2">';
		echo "<br><input type='submit' class='subbut' value = 'Submit' />\n";
		echo "</form>\n";
	}
?>
	</body>
</html>
<?php mysqli_close($con); ?>