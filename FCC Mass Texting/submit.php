<?php 
    // Include Twilio.
    require "Services/Twilio.php";

    $AccountSid = "AC9b03e5c270144f8f42153124ab753cc9";
    $AuthToken = "4668a7ec09197f6859da82039204e5be";
    $client = new Services_Twilio($AccountSid, $AuthToken);

    print "<html><head><script src='js/jquery-1.8.3.min.js'></script><script src='js/global.js'></script><link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'><link rel='stylesheet' type='text/css' href='css/global.css'></head><body><div class='results_page'>";
 
    // MYSQL connection.
    $mysqli = new mysqli("localhost","fcc","foundation", "mtexting");

    // Check said connection.
    if ($mysqli->connect_errno)
    {
        //notify myself of the error and let the user know I'm on it.
        print "An error has occured. No messages have been sent, and Brian has been notified. Please do not try to re-send your message until Brian fixes me.";
        $sms = $client->account->sms_messages->create('+15134297369', '+15133773401', "MYSQL connection error..." . $mysqli->connect_errno); 
    }

    //Overwrite the user friendly names with the database friendly ones.
    if($_POST['group'] == "Foundation General"){
        $group = 'foundation';
    }
    elseif($_POST['group'] == "Hamilton Small Group"){
        $group = 'hamiltonsg';
    }
    elseif($_POST['group'] == "Trenton Small Group"){
        $group = 'trentonsg';
    }
    elseif($_POST['group'] == "Men's Small Group"){
        $group = 'menssg';
    }
    elseif($_POST['group'] == "Core 311"){
        $group = 'core311';
    }
    elseif($_POST['group'] == "Softball"){
        $group = 'softball';
    }
    elseif($_POST['group'] == "Help Desk Volunteers"){
        $group = 'helpdesk';
    }
    elseif($_POST['group'] == "EPIC Youth"){
        $group = 'epic';
    }
    elseif($_POST['group'] == "Brian Only [Test]"){
        $group = 'brian_test';
    }
    elseif($_POST['group'] == "Duane Only [Test]"){
        $group = 'duane_test';
    }
    elseif($_POST['group'] == "Scott Only [Test]"){
        $group = 'scott_test';
    }
    elseif($_POST['group'] == "Jeff Only [Test]"){
        $group = 'jeff_test';
    }
    elseif($_POST['group'] == "Jared Only [Test]"){
        $group = 'jared_test';
    }
    elseif($_POST['group'] == "Worship Team"){
        $group = 'worship';
    }
    else {
        //notify myself of the error and let the user know I'm on it.
        print "An error has occured. No messages have been sent, and Brian has been notified. Please do not try to re-send your message until Brian fixes me.";
        $sms = $client->account->sms_messages->create('+15134297369', '+15133773401', "group not detected..." . print_r($_POST, false)); 
    }


    $result = $mysqli->query("SELECT * FROM numbers WHERE section = '". $group . "'");

    if($result->num_rows > 0) {

        // initilize our array.
        $numbers = array();

        // For each member of the group...
        for($i = 0;  $i < $result->num_rows; $i++)
        {
            $row = $result->fetch_assoc();
            $sms = $client->account->sms_messages->create('+15134297369', $row['phone_number'], $_POST['message']); 
            $numbers[$i] = $row['phone_number'];
        }
        $result->close();
        print "Your message was successfully sent to " . $i . " people.</div> <br><br><button class='shownums'> Show All Recipients</button>";
    }
    else {
        print "<h2>No one is signed up for that group, and no messages have been sent. Sorry!</h2>";
    }

    $mysqli->close();

    print "<div class='number_list' style='display:none;'><table>";
    for($j=0; $j<count($numbers); $j++){
        if(($j+1)%2 == 0) { print "<tr class='even'>";}
        else { print "<tr class='odd'>";}
        
        print "<td>". $numbers[$j]."</td></tr>";
    }        
    print_r($numbers, true);

    print "</table></div></body></html>";
