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

	$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Questions WHERE GroupId='$GroupId' and Open=1"));
	$open = true;
	if ($result == null) {
		$open = false;
	}

?>
<html>
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="grouphome.css">
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

	</head>
	<body>
		<div class = "main-header"><a href="home.php"><img class="logo" src = "images/logo.png" /></a></div>
		<div class = 'inst'>Group Panel for</div>
		<div class = 'groupname'><?php echo $groupname?></div>


		<div class='bigtile' id ='ask'><div class='icon'><img class="ic" src = "images/questicon.png" /></div><div class='label'><div class='buf2'></div>Ask<br/>Question</div></div>
		<div class='bigtile' id ='current'><div class='icon'><img class="ic" src = "images/graphicon.png" /></div><div class='label'><div class='buf2'></div>Current<br/>Question</div></div>

		<div id='secondline'>
			<div class='smalltile' id ='past' onclick="window.location='closed.php?groupid=<?php echo $GroupId ?>'"><div class='buf'></div>Past<br/>Questions</div>
			<div class='smalltile' id ='manage' onclick="window.location='manage.php?groupid=<?php echo $GroupId ?>'"><div class='buf'></div>Manage<br/>Members</div>
			<div class='smalltile' id ='quit' onclick="window.location='quitgroup.php?groupid=<?php echo $GroupId ?>'"><div class='buf'></div>Quit<br/>Group</div>
		</div>

		<div class="warningmessage"></div>

		<script>
			var open = <?php echo json_encode($open) ?>;
			var color = '#84CBC5';

			if (open) {
				$(".warningmessage").text("A group can have only one open question. To ask a new question, go to Current Question to close active poll.");
				$("#ask").click(function() {
					$(".warningmessage").fadeIn().delay(3600).fadeOut();
				});


				$("#current").css('background', color);
				$("#current").css('border', '2px solid #84CBC5');
				$("#current .ic").css('-webkit-filter', 'invert(100%)');
				$("#current").click(function() {
					window.location='questions.php?groupid=<?php echo $GroupId ?>';
				});


				$("#ask").css('background', 'white');
				$("#ask").css('border', '2px solid #D0D0D0');
				$("#ask").css('color', '#D0D0D0');
				$("#ask .ic").attr('src','images/questicon2.png');


				function react2() {
					$("#current .ic").css('-webkit-filter','none');
					$("#current").css('background','white');
					$("#current").css('color',color);
					console.log('weird');
				} 

				$("#current").mouseover(react2);
				$("#current").click(react2);

				$("#current").mouseout(function() {
					$("#current .ic").css('-webkit-filter','invert(100%)');
					$("#current").css('background',color);
					$("#current").css('color','white');
				});				
			} else {
				$(".warningmessage").text("This group has no open question at the moment. Go to Ask Question to create a new one.");

				$("#current").click(function() {
					$(".warningmessage").fadeIn().delay(3600).fadeOut();
				});



				$("#ask").css('background', color);
				$("#ask").css('border', '2px solid #84CBC5');
				$("#ask .ic").css('-webkit-filter','invert(100%)');
				$("#ask").click(function() {
					window.location='questions.php?groupid=<?php echo $GroupId ?>';
				});

				$("#current").css('background', 'white');
				$("#current").css('border', '2px solid #D0D0D0');
				$("#current").css('color', '#D0D0D0');
				$("#current .ic").attr('src','images/graphicon2.png');


				function react() {
					$("#ask .ic").css('-webkit-filter','none');
					$("#ask").css('background','white');
					$("#ask").css('color',color);
				} 

				$("#ask").mouseover(react);
				$("#ask").click(react);
				$("#ask").mouseout(function() {
					$("#ask .ic").css('-webkit-filter','invert(100%)');
					$("#ask").css('background',color);
					$("#ask").css('color','white');
				});				
			}
		</script>

	</body>
</html>