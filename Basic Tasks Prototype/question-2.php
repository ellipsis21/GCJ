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
	</head>
	<body>
		<form id="myform" name="messager" action="message.php" enctype="multipart/form-data" method="post" style = "display: inline-block; text-align: center;">
			<div class = "main-header"><a href="home.php"><img class="logo" src = "images/logo.png" /></a></div>
			<h3>Yes/No Question To: <?php echo $groupname ?></h3>
			<textarea form="myform" id='question' name='question' class='textbox' placeholder='Question' rows='3'></textarea>
			<input type='hidden' name='group' value='<?php echo $GroupId ?>' />
			<input type='hidden' name='id' value='<?php echo $id ?>' />
			<input type='hidden' name='type' value='YN' />
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