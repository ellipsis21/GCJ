<?php
    require "twilio-php-latest/Services/Twilio.php";
    session_start(); 
    $con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

	//get user responce
    $message= $_REQUEST['Body'];
    $number= $_REQUEST['From'];
	$number = substr($number, 2);
    //GCJ put responce in DB
    $res = mysqli_query($con,"SELECT * FROM Members WHERE Phone='$number'");
    //assumes phone number is unique
    if($row = mysqli_fetch_array($res)) {
        $GroupId= $row['GroupId'];
        $result = mysqli_query($con,"SELECT * FROM Questions WHERE GroupId=$GroupId AND Open=1");
        if($column = mysqli_fetch_array($result)) {
            $qId= $column['QuestionId'];
            // $questioner= $column['UserId'];
            if(!mysqli_query($con,"INSERT INTO Responses (QuestionID, Phone, Response) VALUES ('$qId', '$number', '$message')")) echo "failure! " . mysqli_error($con);
            // $result2 = mysqli_query($con,"SELECT * FROM Users WHERE UserId='$questioner'");
            // if($anotherRow = mysqli_fetch_array($result2)){
                // $originalSenderNumber= "+1".$row['Phone'];
                // $result3 = mysqli_query($con,"SELECT * FROM Members WHERE GroupId=$GroupId");
                // $numberExpectedResp= mysql_num_rows($result3); 
                // if($numberExpectedResp){
                    // $result4 = mysqli_query($con,"SELECT * FROM Responses WHERE QuestionID=$qId");
                    // $numResp= mysql_num_rows($result4); 
                    // if($numResp){
                        // $body= "Your question got its first responce!";
                        // $sendMes= false;
                        // if($numResp == 1) $sendMes= true;
                        // if($numResp == ($numberExpectedResp/2)){
                            // $body= "You have received half of your results"
                            // $sendMes= true;
                        // }
                        // if($numResp == $numberExpectedResp){
                            // $sendMes= true;
                            // $body= "All of your results are in!"
                        // }
                        // if($sendMes){
                            // $account_sid = 'ACe45cbecec1c4d969f362becc4dae5ce1'; 
                            // $auth_token = '2920745a17eb488e173b7ffe2310f958'; 
                            // $client = new Services_Twilio($account_sid, $auth_token); 
                            // $sms = $client->account->messages->sendMessage("+17542108538", $originalSenderNumber, $body);
                        // }
                    // }
                // }
            // }

        }
    }    

    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    //can have Responce after php code depending on cost of texts
?> 