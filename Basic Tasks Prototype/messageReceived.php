<?php
 
    // start the session
    session_start();
 

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
    


    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    //can have Responce after php code depending on cost of texts
?> 