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
	mysqli_close($con);
?>

<html>	
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="questions.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
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
			<h3>Task Assignment To: <?php echo $groupname ?></h3>
			<h3>Task Options</h3>
			<table align='center' style='text-align:center' cellpadding='5'>
			<tr>
				<th>Task</th>
				<th># Needed</th>
			</tr>
			<tr>
				<td><input type='text' name='task1' class='textbox2' style="text-align: center"/></td>
				<td><input type='tel' name='need1' class='textbox2' placeholder="1" style="text-align: center"/></td>
			</tr>
			<tr>
				<td><input type='text' name='task2' class='textbox2'  style="text-align: center"/></td>
				<td><input type='tel' name='need2' class='textbox2'  style="text-align: center"/></td>
			</tr>
			<tr id='response3' style="display:none;">
				<td><input type='text' name='task3' class='textbox2'  style="text-align: center"/></td>
				<td><input type='tel' name='need3' class='textbox2'  style="text-align: center"/></td>
			</tr>
			<tr id='response4' style="display:none;">
				<td><input type='text' name='task4' class='textbox2'  style="text-align: center"/></td>
				<td><input type='tel' name='need4' class='textbox2'  style="text-align: center"/></td>
			</tr>
			<tr id='response5' style="display:none;">
				<td><input type='text' name='task5' class='textbox2'  style="text-align: center"/></td>
				<td><input type='tel' name='need5' class='textbox2'  style="text-align: center"/></td>
			</tr>
			<tr id='response6' style="display:none;">
				<td><input type='text' name='task6' class='textbox2'  style="text-align: center"/></td>
				<td><input type='tel' name='need6' class='textbox2'  style="text-align: center"/></td>
			</tr>
			</table>
			<input type='hidden' name='group' value='<?php echo $GroupId ?>' />
			<input type='hidden' name='id' value='<?php echo $id ?>' />
			<input type='hidden' name='type' value='TC' />
			<input type='hidden' name='question' value='' />
			<a class='question-5'onclick='AddResOpt()' id='addop'>Add Option</a>
			<br>
			<div class='imagevideobar'><span id='image'><img class="ic" src = "images/image.png" /></span><input name = "pic" type="file" accept="image/*" capture="camera" class="hiddeninput" id="picinput" onchange="changeImageColor()">
			<span id='video' class='group'><img class="ic" src = "images/video.png" /></span><input name = "video" type="file" accept="video/*" capture="camera" class="hiddeninput" id='videoinput' onchange="changeVideoColor()">
			</div>
			<a class="question-1" onclick="document.getElementById('myform').submit();">Send</a>
		</form>
		<script>
			$("#image").click(function(){
				$("#picinput").trigger("click");
			});
			$("#video").click(function(){
				$("#videoinput").trigger("click");
			});
			function changeImageColor() {
				$("#image").css("background","#84CBC5");
			}
			function changeVideoColor() {
				$("#video").css("background","#84CBC5");
			}
		</script>
	</body>
</html>