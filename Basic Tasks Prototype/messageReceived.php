<?php
    session_start(); 
    $con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    // start the session
  //  session_start();
 

 	//example of session variable(dont worry about it for now)
    // get the session varible if it exists
    $counter = $_SESSION['counter'];
    // if it doesnt, user has not yet responded
    if(!strlen($counter)) {
        $counter = 0;         
    }
	$counter++;
	$_SESSION['counter'] = $counter;

	//example over

	//get user responce
    $message= $_REQUEST['Body'];
    $number= $_REQUEST['From'];

    //GCJ put responce in DB
    $res = mysqli_query($con,"SELECT * FROM Friends WHERE Phone='$number'");
    //assumes phone number is unique
    while($row = mysqli_fetch_array($res)) {
        $friendID= $row['PID'];
        $cat= $row['CatId'];
        $user= $row['UserId'];
        $result = mysqli_query($con,"SELECT * FROM UQuestion WHERE CatId= $cat AND UserId=$user");
        while($column = mysqli_fetch_array($result)) {
            $questionID= $column['PID'];
            if(!mysqli_query($con,"INSERT INTO Responses (Response, QuestionID, FriendID) VALUES ('$question', '$questionID', '$friendID')")) echo "failure! " . mysqli_error($con);
        }

    }


    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    //can have Responce after php code depending on cost of texts
?> 

<Response>
	<Message><?php echo "$message $number" ?> - message</Message>
</Response>