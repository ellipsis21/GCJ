<?php 

	session_start(); 
	require "twilio-php-latest/Services/Twilio.php";
	$con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
	// Check connection
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$userid = $_SESSION['UserId'];
	$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Users WHERE UserId='$userid'"));
	$userphone = $result['Phone'];

	$groupid = $_GET['groupid'];
	$result = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM Groups WHERE GroupId='$groupid'"));
	$groupname = $result['Name'];

	if (isset($_GET['remove'])) {
		$memberphone = $_GET['remove'];
		mysqli_query($con, "DELETE FROM Members WHERE GroupId = '$groupid' AND Phone= '$memberphone'");
	}

	if (isset($_POST['name'])) {
		$membername = $_POST['name'];
		$memberphone = $_POST['number'];
		if (mysqli_query($con, "INSERT INTO Members(GroupId,Name,Phone,Status) VALUES ('$groupid','$membername','$memberphone',0)")) {
			$account_sid = 'ACe45cbecec1c4d969f362becc4dae5ce1'; 
			$auth_token = '2920745a17eb488e173b7ffe2310f958'; 
			$client = new Services_Twilio($account_sid, $auth_token); 
			$body = "$membername, you've been added to $groupname on TellMeNow. To unsubscribe, text STOP";
			$sms = $client->account->messages->sendMessage("+17542108538", $memberphone, $body);
		}
	}


	if (isset($_GET['admin'])) {
		$memberphone = $_GET['admin'];
		mysqli_query($con, "UPDATE Members SET Status = 1 WHERE Phone='$memberphone' AND GroupId='$groupid'");
		mysqli_error($con);
	}


	$result = mysqli_query($con,"SELECT * FROM Members WHERE GroupId='$groupid' ORDER BY Status");
	
	$curUrl = "http://ggreiner.com/cs247/bp/manage.php?groupid=$groupid&share";
	
	if (isset($_GET['share'])) {
		$heading = "Join Group: $groupname";
		$button = "Join Group";
		$action = "manage.php?groupid=$groupid&complete";
	}
	else {
		$heading = "Add a New Member";
		$button = "Add Member";
		$action = "manage.php?groupid=$groupid";
	}
?>
<html>
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="manage.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
	</head>
	<body>
		<div class = "main-header"><a href="home.php"><img class="logo" src = "images/logo.png" /></a></div>
		<?php if (isset($_GET['complete'])) { ?>
		<h3>Thank you for joining!</h3>
		<?php } ?>
		<?php if (!isset($_GET['complete'])) { ?>
		<h3><?php echo $heading ?></h3>
		<?php
		echo "<form id='myform' name='input' action='$action' enctype='multipart/form-data' method='post' style = 'display: inline-block; text-align: center;'>";
		?>
			<input type='text' name='name' class='textbox' required placeholder='Member name' maxlength='30'/>
			<input type='tel' name='number' class='textbox' required placeholder='10 digit numbers' maxlength='10'/>
			<a class="question-1" onclick="document.getElementById('myform').submit();"><?php echo $button ?></a>
		</form>
		<?php if (!isset($_GET['share'])) { ?>
		<div class='heading'>Or Share Access to Signup</div>
		<div class='subheading'>Send the following link to your members <br/> for them to add themselves to the group.</div>
		<input id="share" class="textbox" type="text" value="<?php echo $curUrl ?>" onFocus="this.selectionStart=0; this.selectionEnd=this.value.length;" onTouchEnd="this.selectionStart=0; this.selectionEnd=this.value.length;" onMouseUp="return false"/>

		<h3 style="text-align: center;">Current Members of <br/> <?php echo $groupname ?></h3>
		<?php
			echo "<table class='mytable' align='center' style='text-align:center' cellpadding='5'>\n";
			echo "<tr>\n";
			echo "<th>Name</th>\n";
			echo "<th>Phone</th>\n";
			echo "<th>Remove</th>\n";
			echo "<th>Make Admin</th>\n";
			echo "</tr>\n";
			while ($row = mysqli_fetch_array($result)) {
				echo "<tr>\n";
				echo "<td class='name'>".$row["Name"]."</td>";
				echo "<td class='phone'>".$row["Phone"]." </td>";
				if ($row["Status"] != 1) {
					echo "<td class='remove' onclick='removemem(\"".$row['Phone']."\",\"".$row["Name"]."\");'>";
					echo "x";
					echo "</td>";

					echo "<td class='admin' onclick='admin(\"".$row['Phone']."\",\"".$row["Name"]."\");'>";
					echo "O";
					echo "</td>";
				} else {
					echo "<td colspan='2' class='adm'>IS ADMIN</td>";
				}

				echo "</tr>\n";
			}
			echo "</table>\n";
			echo "<div class='buffer'></div>";
 	?>
	<div class='group-home'><div class='home' onclick="location.href='grouphome.php?groupid=<?php echo $groupid;?>';"><img class='navicon' src='images/home.png'/> GROUP HOME</div><div class='all' onclick="location.href='home.php';"><img class='navicon' src='images/group.png'/> ALL GROUPS </div> </div>
	
	<div class="box">
		<div class="confirmquestion"></div>
		<div><span id="yes">YES</span><span id="no">NO</span></div>
	</div>

	<script>
		$("#no").click(function() {
			$(".box").fadeOut();
		});

		function admin(phone, name) {
			console.log(name);
			var prompt = "Are you sure you want to make " + name + " admin? <br/> Admin privilege can't be revoked until the member quits.";
			$(".confirmquestion").text(prompt);
			$(".box").fadeIn();

			$("#yes").click(function() {
				location.href = "manage.php?groupid=" + <?php echo $groupid ?> + "&admin=" + phone;
			});
		}
		
		function removemem(phone, name) {
			var prompt = "Are you sure you want to remove " + name + "?";
			$(".confirmquestion").text(prompt);
			$(".box").fadeIn();

			$("#yes").click(function() {
				location.href = "manage.php?groupid=" + <?php echo $groupid ?> + "&remove=" + phone;
			});
		}
	</script>
	<?php } ?>
	<?php } ?>

	</body>
</html>
<?php mysqli_close($con); ?>