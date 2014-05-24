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
				document.getElementById("response" + count).setAttribute('type','text');
				document.getElementById("response" + count).focus();
				document.getElementById("response" + count).select();
				count++;
				if (count > 6) document.getElementById("addop").style.display="none";
			}
		</script>
	</head>
	<body onload="scroll()">
		<form id="myform" name="messager" action="message.php" enctype="multipart/form-data" method="post" style = "display: inline-block; text-align: center;">
			<div class = "main-header"><a href="home.php"><img class="logo" src = "images/logo.png" /></a></div>
			<h3>Multiple Choice Question To: <?php echo $groupname ?></h3>
			<textarea form="myform" id='question' name='question' class='textbox' placeholder='Question' rows='3'></textarea>
			<h3>Response Options</h3>
			<input type='text' name='response1' class='textbox' placeholder='Response 1' />
			<input type='text' name='response2' class='textbox' placeholder='Response 2' />
			<input type='hidden' id='response3' name='response3' class='textbox' placeholder='Response 3' />
			<input type='hidden' id='response4' name='response4' class='textbox' placeholder='Response 4' />
			<input type='hidden' id='response5' name='response5' class='textbox' placeholder='Response 5' />
			<input type='hidden' id='response6' name='response6' class='textbox' placeholder='Response 6' />
			<input type='hidden' name='group' value='<?php echo $GroupId ?>' />
			<input type='hidden' name='id' value='<?php echo $id ?>' />
			<input type='hidden' name='type' value='MC' />
			<a class='question-5'onclick='AddResOpt()'>Add Option</a>
			<br>
			<br><div id='image'>ATTACH IMAGE</div><input name = "pic" type="file" accept="image/*" capture="camera" class="hiddeninput" id="picinput">
			<br><div id='video' class='group'>ATTACH VIDEO</div><input name = "video" type="file" accept="video/*" capture="camera" class="hiddeninput" id='videoinput'>
			<br><a class="question-1" onclick="document.getElementById('myform').submit();">Send</a>
		</form>
		<script>
			$("#image").click(function(){
				$("#picinput").trigger("click");
			});
			$("#video").click(function(){
				$("#videoinput").trigger("click");
			});
		</script>
	</body>
</html>