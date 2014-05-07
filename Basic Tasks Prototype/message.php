<?php 
	session_start(); 
	require "twilio-php-latest/Services/Twilio.php";
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
		<meta name="viewport" content="width=device-width, target-densitydpi=high-dpi" />
	</head>
	<body>
		<p><a href = "login.php">Home</a> - <a href = "message.php">Questions</a></p>
		<h2 style="text-align: center;">Open Questions</h2>
			<?php
			if (isset($_GET["remove"])){
				$remove = intval($_GET['remove']);
				if(!mysqli_query($con,"DELETE FROM UQuestions WHERE PID=$remove")) echo "failure! " . mysqli_error($con);
				if(!mysqli_query($con,"DELETE FROM Responses WHERE QuestionID=$remove")) echo "failure! " . mysqli_error($con);
			}
			if (isset($_POST["question"])){
				$question = $_POST["question"];
				$category = intval($_POST["category"]);
				$res = mysqli_query($con,"SELECT * FROM UQuestions WHERE CatId = $category");
				if (mysqli_num_rows($res) > 0) {
					echo "<p>Sorry you can only have one open question per category! Please close a category's question before opening a new one!</p>";
				}
				else {
					$id = intval($_POST["id"]);
					$responses = [];
					for ($count = 1; $count <= 6; $count++) {
						if (isset($_POST["response$count"])) {
							$responses[$count-1] = $_POST["response$count"];
						}
					}

					if(!empty($_FILES['pic']['name'])) {
						$uploaddir = 'images/';
						$uploadfile = $uploaddir . basename($_FILES['pic']['name']);

						if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploadfile)) {
							$picFile = $uploadfile;
						} else {
							echo "Possible file upload attack!\n";
						}
					}
					else $picFile = "";

					if(!empty($_FILES['video']['name'])) {
						$uploaddir = 'videos/';
						$uploadfile = $uploaddir . basename($_FILES['video']['name']);

						if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile)) {
							$vidFile = $uploadfile;
						} else {
							$vidFile = "";
							echo "Possible file upload attack!\n";
						}
					}
					else $vidFile = "";
					if(!mysqli_query($con,"INSERT INTO UQuestions (Question, Response1, Response2, Response3, Response4, Response5, Response6, PicPath, VidPath, UserId, CatId) VALUES ('$question', '".$responses[0]."', '".$responses[1]."', '".$responses[2]."', '".$responses[3]."', '".$responses[4]."', '".$responses[5]."', '$picFile', '$vidFile', $id, $category)")) echo "failure! " . mysqli_error($con);
					// sleep(1);
					// $url = "sendTexts.php?question=".urlencode($question)."&response1=".urlencode($responses[0])."&response2=".urlencode($responses[1])."&response3=".urlencode($responses[2])."&response4=".urlencode($responses[3])."&response5=".urlencode($responses[4])."&response6=".urlencode($responses[5])."&img=".urlencode($picFile)."&vid=".urlencode($vidFile)."&userId=".urlencode($id)."&cat=".urlencode($category);
					// echo "<script>window.location = '$url'</script>";
					 $account_sid = 'ACe45cbecec1c4d969f362becc4dae5ce1'; 
						$auth_token = '2920745a17eb488e173b7ffe2310f958'; 
						$client = new Services_Twilio($account_sid, $auth_token); 
					 
						$url = "";
						
						if($picFile != "") $url= "http://ggreiner.com/cs247/bp/" . $picFile;
						
						$vid = "";
						
						if($vidFile != "") $vid= "http://ggreiner.com/cs247/bp/" . $vidFile;
						
						$body= "";
						
						$body.=$question . ": " . $url . "\n$vid\n\n";
						for ($count = 0; $count < 6; $count++) {
							$num = $count+1;
							if($responses[$count] != "")$body.= "Respond $num for:" . $responses[$count] . " \n\n";
							
						}
					//GCJ still need to add numbers may need to use sandbox numbers with free account 
						 // Step 4: make an array of people we know, to send them a message. 
						// Feel free to change/add your own phone number and name here.
						$people;
						$userName = "";
						
							$cat= $category;
							$user= $id;
							$result = mysqli_query($con,"SELECT * FROM Friends WHERE CatId= $cat AND UserId=$user");
							while($row = mysqli_fetch_array($result)) {
								$number= $row['Phone'];
								$name= $row['FirstName'];
								$people[]= $number; //GCJ should I have put the ''?
							}
							$result = mysqli_query($con,"SELECT * FROM Persons WHERE PID=$user");
							if ($row = mysqli_fetch_array($result)) {
								$userName = $row['FirstName'];
							}
						
						$body = "Question from $userName: \n\n".$body;
						$body .= " (You can enter a comment after your # response).";

					  //  $people = array(
					  //      "+16502836850" => "JC",
					  //      "+17143308621" => "Greg"
					  //  );

						// Step 5: Loop over all our friends
						foreach ($people as $n) {
							// if($url != ""){
								// $sms = $client->account->messages->sendMessage("+17542108538", $number, $body, $url);
							// } else {
								$sms = $client->account->messages->sendMessage("+17542108538", $n, $body);
							//}
							// Display a confirmation message on the screen
						}
				}
			}
			$id = $_SESSION['id'];
			$result = mysqli_query($con,"SELECT * FROM UQuestions WHERE UserId=$id");
			$count = 1;
			while($row = mysqli_fetch_array($result)) {
				$cat = $row['CatId'];
				$res = mysqli_query($con,"SELECT * FROM Categories WHERE PID=$cat");
				$ro = mysqli_fetch_array($res);
				$category = $ro['FirstName'];
				echo "<h3>Question $count to $category:</h3>".$row['Question']."<br><br>\n";
				echo "<a href='results.php?qId=".$row['PID']."'>Results</a> <br><br>\n";
				if ($row['PicPath'] != "") {
					echo "Associated Picture: <br>\n";
					$pic = $row['PicPath'];
					echo "<img src = '$pic' style='max-width:100%' />\n";
				}
				if ($row['VidPath'] != "") {
					echo "Associated Video: <br>\n";
					$vid = $row['VidPath'];
					echo '<video width="320" height="240" controls><source src="'.$vid.'" type="video/mp4">Your browser does not support the video tag.</video>';
				}
				echo "<br><br>";
				echo "<input type='button' class='removebut' value = 'Close Question' onclick=\"location.href='?remove=".$row['PID']."'\"/>\n";
				echo "<br><br><br>";
				$count++;
			}
			?>
	</body>
</html>