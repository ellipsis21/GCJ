<?php 

session_start(); 
$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
	$GroupId = $_GET['groupid'];
	$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Groups WHERE GroupId='$GroupId'"));
	$groupname = $result['Name'];
	$id = $_SESSION["UserId"];
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
				document.getElementById("response" + count).style.display="table-row";
				count++;
				if (count > 6) document.getElementById("addop").style.display="none";
			}
		</script>
	</head>
	<body onload="scroll()">
		<form id="myform" name="messager" action="message.php" enctype="multipart/form-data" method="post" style = "display: inline-block; text-align: center;">
			<div class = "main-header"><a href="home.php"><img class="logo" src = "images/logo.png" /></a></div>
			<h3>Date/Time Question To: <?php echo $groupname ?></h3>
			<input type='text' id='question' name='question' class='textbox' placeholder='Question' />
			<h3>Date/Time Options</h3>
			<table align='center' style='text-align:center' cellpadding='5'>
			<tr>
				<th>Date</th>
				<th>Time</th>
			</tr>
			<tr>
				<td><input type='date' name='date1' class='datebox' /></td>
				<td><input type='text' name='time1' class='textbox2' placeholder="1pm"/></td>
			</tr>
			<tr>
				<td><input type='date' name='date2' class='datebox' /></td>
				<td><input type='text' name='time2' class='textbox2' /></td>
			</tr>
			<tr id='response3' style="display:none;">
				<td><input type='date' name='date3' class='datebox' /></td>
				<td><input type='text' name='time3' class='textbox2' /></td>
			</tr>
			<tr id='response4' style="display:none;">
				<td><input type='date' name='date4' class='datebox' /></td>
				<td><input type='text' name='time4' class='textbox2' /></td>
			</tr>
			<tr id='response5' style="display:none;">
				<td><input type='date' name='date5' class='datebox' /></td>
				<td><input type='text' name='time5' class='textbox2' /></td>
			</tr>
			<tr id='response6' style="display:none;">
				<td><input type='date' name='date6' class='datebox' /></td>
				<td><input type='text' name='time6' class='textbox2' /></td>
			</tr>
			</table>
			<input type='hidden' name='group' value='<?php echo $GroupId ?>' />
			<input type='hidden' name='id' value='<?php echo $id ?>' />
			<input type='hidden' name='type' value='TD' />
			<a class='question-5'onclick='AddResOpt()' id='addop'>Add Option</a>
			<br>
			<br><input name = "pic" type="file" accept="image/*" capture="camera" class="button">
			<br><input name = "video" type="file" accept="video/*" capture="camera" class="button2">
			<br><a class="question-1" onclick="document.getElementById('myform').submit();">Send</a>
		</form>
	</body>
</html>