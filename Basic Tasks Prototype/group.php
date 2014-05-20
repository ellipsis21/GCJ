<?php
    $con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

	session_start(); 
	$userid = $_SESSION['UserId'];
	if (isset($_POST['groupname'])) {
		$groupname = $_POST['groupname'];
		if(!mysqli_query($con,"INSERT INTO Groups (Name) VALUES ('$groupname')")) echo "failure! " . mysqli_error($con);

		$result = mysqli_fetch_array(mysqli_query($con, "SELECT MAX(GroupId) FROM Groups"));
		$groupid = $result[0];

		for ($i = 1; $i <= $_POST['numMembers']; $i++) {
			$membername = $_POST["name$i"];
			$memberphone = $_POST["number$i"];
			if(!mysqli_query($con,"INSERT INTO Members (GroupId, Name, Phone) VALUES ('$groupid', '$membername', '$memberphone')")) echo "failure! " . mysqli_error($con);
		}

		if(!mysqli_query($con,"INSERT INTO Admins (GroupId, UserId) VALUES ('$groupid', '$userid')")) echo "failure! " . mysqli_error($con);
		//header("Location: home.php");
	}
?>


<html>
	<head>
		<title>CS 247 Basic Prototype</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />

		<script language="javascript">
			var count = 1;
			function AddResOpt() {
				count++;
				var newdiv = document.createElement('div');
				newdiv.setAttribute('class', 'member');
				newdiv.setAttribute('id','member'+count);
				newdiv.innerHTML = "<label>Member #"+count+"</label><input type='text' name='name"+count+"' class='textbox' placeholder='Member name'/><input type='tel' name='number"+count+"' class='textbox' placeholder='10 digit numbers'/>";

				document.getElementById('members').appendChild(newdiv);

				document.getElementById('numMembers').value = count;
			}
		</script>
	</head>

	<body>
		<form id="myform" name="input" action="group.php" enctype='multipart/form-data' method="post" style = "display: inline-block; text-align: center;">
			<h2>Enter your group name</h2>

			<input type='text' name='groupname' class='textbox' placeholder='Group Name' autocapitalize="off" required>

			<h2>Add members to your group!</h2>
			<div id = "members">
				<label> Member #1 </label>
				<input type='text' name='name1' class='textbox' placeholder='Member name'/>
				<input type='tel' name='number1' class='textbox' placeholder='10 digit numbers'/>
			</div>
			<input type='button' class='subbut' value = 'Add More Members' onclick='AddResOpt()'/>
			<input type='hidden' id='numMembers' name='numMembers' value='1'/>

			<input type="submit" class="subbut" value="Create Group"/>
		</form>

	</body>
</html>