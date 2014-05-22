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
            $questioner= $column['UserId'];
            if(!mysqli_query($con,"INSERT INTO Responses (QuestionID, Phone, Response) VALUES ('$qId', '$number', '$message')")) echo "failure! " . mysqli_error($con);
            
            // In case of multiple text messages by the same person
            $result5 = mysqli_query($con,"SELECT * FROM Responses WHERE Phone = '$number'");
            $numRespPerPhone = mysql_num_rows($result5);

            if ($numRespPerPhone == 1) {
                $result2 = mysqli_query($con,"SELECT * FROM Users WHERE UserId='$questioner'");
                
                if($anotherRow = mysqli_fetch_array($result2)){
                    $originalSenderNumber= "+1".$anotherRow['Phone'];
                    
                    $result3 = mysqli_query($con,"SELECT * FROM Members WHERE GroupId=$GroupId");
                    $numberExpectedResp= mysql_num_rows($result3); 
                    
                    $result4 = mysqli_query($con,"SELECT COUNT(*) AS NumRespondents FROM Members WHERE Members.Phone IN (SELECT Phone FROM Responses WHERE QuestionID = $qId)");
                    $numResp = mysql_fetch_row($result4);
                    $numRespondents = $numResp["NumRespondents"];

                    if($numberExpectedResp and $numRespondents){
                        $body= "Your question got its first respondent!";
                        $sendMes= false;


                        if($numResp == 1) {
                            $sendMes= true;
                        }

                        if($numResp == round($numberExpectedResp/2)){
                            $body= "Half of your members replied.";
                            $sendMes= true;
                        }

                        if($numResp == $numberExpectedResp){
                            $sendMes= true;
                            $body= "All of your members replied!";
                        }

                        if ($sendMes) {
                            $account_sid = 'ACe45cbecec1c4d969f362becc4dae5ce1'; 
                            $auth_token = '2920745a17eb488e173b7ffe2310f958'; 
                            $client = new Services_Twilio($account_sid, $auth_token);
                            $body .= "\n To check results, visit http://ggreiner.com/cs247/bp/results.php?qId="+$qId;
                            $sms = $client->account->messages->sendMessage("+17542108538", $originalSenderNumber, $body);
                        }
                    }
                }
            }
        }
<<<<<<< HEAD
    }

    //header("content-type: text/xml");
=======
    }    

	mysqli_close($con);
    header("content-type: text/xml");
>>>>>>> a6ede1d42d5fece1079dd89a175015ef59cc743a
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    //can have Responce after php code depending on cost of texts
?> 