<?php
//page between send.php and message.php (maybe replaces message,php)
    require "twilio-php-latest/Services/Twilio.php";
    session_start(); 
    $con=mysqli_connect("ggreiner.com","ggreiner_g","volley3","ggreiner_247");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
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
    if(isset($_GET["response$count"])  && $_GET["img"] != empty){
        $url= "http://ggreiner.com/cs247/bp/" . $_GET["img"];
    }
//GCJ still need to add numbers may need to use sandbox numbers with free account 
     // Step 4: make an array of people we know, to send them a message. 
    // Feel free to change/add your own phone number and name here.
    $people;
    if(isset($_GET["userId"]) && $_GET["cat"])){
        $cat= $_GET["cat"];
        $user= $_GET["userId"];
        $result = mysqli_query($con,"SELECT * FROM Friends WHERE CatId= $cat AND UserId=$user");
        while($row = mysqli_fetch_array($result)) {
            $number= $row['Phone'];
            $name= $row['FirstName'];
            $people['$number']= $name; //GCJ should I have put the ''?
        }
    }

  //  $people = array(
  //      "+16502836850" => "JC",
  //      "+17143308621" => "Greg"
  //  );

    // Step 5: Loop over all our friends
    foreach ($people as $number => $name) {
        if($url != empty){
            $sms = $client->account->messages->sendMessage("+17542108538", $number, $body, $url);
        } else {
            $sms = $client->account->messages->sendMessage("+17542108538", $number, $body);
        }
        // Display a confirmation message on the screen
        echo " Sent message to $name ";
    }
