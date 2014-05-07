<?php
//page between send.php and message.php (maybe replaces message,php)
    require "twilio-php-latest/Services/Twilio.php";
 
    $account_sid = 'ACe45cbecec1c4d969f362becc4dae5ce1'; 
    $auth_token = '2920745a17eb488e173b7ffe2310f958'; 
    $client = new Services_Twilio($account_sid, $auth_token); 
 
  
    $body= "";
    if (isset($_GET["question"])){
        $question = $_GET["question"];
        $body.=$question . " ";
    }
    for ($count = 1; $count <= 6; $count++) {
        if (isset($_GET["response$count"])) {
            if($_GET["response$count"] != "")$body.= "Respond $count for:" . $_GET["response$count"] . "  ";
        }
    }
    $url= "http://ggreiner.com/cs247/bp/" . $_GET["img"];

//GCJ still need to add numbers may need to use sandbox numbers with free account 
     // Step 4: make an array of people we know, to send them a message. 
    // Feel free to change/add your own phone number and name here.
    $people = array(
    //    "+14158675309" => "Curious George",
    //    "+14158675310" => "Boots",
    //    "+14158675311" => "Virgil",
    );
    echo $body;
    echo $url;

    // Step 5: Loop over all our friends
    foreach ($people as $number => $name) {
 
        $sms = $client->account->messages->sendMessage(
 
        // Step 6: Change the 'From' number below to be a valid Twilio number 
        // that you've purchased, or the (deprecated) Sandbox number
            "+17542108538", 
 
            // the number we are sending to - Any phone number 
            $number,
 
            // the sms body
            $body,
//GCJ want to allow for multiple meadia?
            // Step 7: Add a url to the image media you want to send
           // array("https://demo.twilio.com/owl.png", "https://demo.twilio.com/logo.png")
            //or just "https://demo.twilio.com/owl.png"

            $url
        );
 
        // Display a confirmation message on the screen
        echo "Sent message to $name";
    }
	
	echo "<script>window.location = 'message.php'</script>";
	
?>