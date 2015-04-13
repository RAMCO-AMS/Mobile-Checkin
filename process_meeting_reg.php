<?php
require_once 'config.php';
require_once 'functions.php';

//make sure we were sent a nrds ID (or savvy card url)
if (!empty($_POST)){
      $nrds=$_POST["nrds"];
} else {
    echo "no value sent for NRDS<br>";
};

// if we are accepting savvy card, check to see if the URL is mapped to a NRDS Number
if (ACCEPT_SAVVYCARD && isset($savvy_card_id["$nrds"] )){
    
    $nrds=$savvy_card_id["$nrds"];
    echo "Savvy Card Identified! NRDS:$nrds<br>";
    
}

// In this example, all contact GUIDS are mapped to a NRDS ID locally to save a few calls to the RAMCO API
if (USE_LOCAL_DATABASE && is_numeric($nrds)){
                
        try {
                $conn = new PDO("mysql:host=$hostname;dbname=$myDB", $username, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Connected successfully"; 
                $sql = "SELECT guid,first_name,last_name FROM contacts where NRDS=$nrds";
           
                foreach ($conn->query($sql) as $row) {
                        //found it 
                        $contact_id = $row['guid'];
                        $first_name= $row['first_name'];
                        $last_name= $row['last_name'];
                        echo "$first_name $last_name found in local database!<br>";
                        
                }
                                
                //kill connection to database
                $conn=null;
                    
        }
        catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
        }
                    
                        
}


//if we dont found contact ID with local database, check RAMCO API
if(!isset($contact_id)){    
    $contact_id = getContactIDFromNRDS($nrds);
    $first_name=$contact_id['Data'][0]['FirstName'];
    $last_name=$contact_id['Data'][0]['LastName'];
    $contact_id =$contact_id['Data'][0]['ContactId'];
}; 



 //if we find the contact, then see if they have any registrations 
if($contact_id){
   
    $meeting_registrations = getMeetingRegistrationFromContactID($contact_id);

    // if we find registrations, then mark them attended for our meeting
    if($meeting_registrations){
        //flag to check if correct registration is found
        $found=0;
           //iterate through all the registrations
        for ($i=0;$i<sizeof($meeting_registrations["Data"]);$i++){
            
            if ($meeting_registrations['Data'][$i]['cobalt_meetingid']['Value']==MEETING_ID){
                                    
                if (ALLOW_RECHECK){
                    //we've found the right meeting, and it doesnt matter if we've already checked in as allow recheck is true
                    //mark attended
                    mark_meeting_attended($meeting_registrations['Data'][$i]['cobalt_meetingregistrationId']);
                    $found=1;
                    print_badge($first_name,$last_name);
                    break;
                } else {
                    //we have found the meeting registration and the value of attended is false, so lets log them in             
                    if($meeting_registrations["Data"][$i]["cobalt_attendedmeeting"]=="false"){
                        mark_meeting_attended($meeting_registrations['Data'][$i]['cobalt_meetingregistrationId']);
                        $found=1;
                        print_badge($first_name,$last_name);
                            
                    } else {
                        //registration was found, but allow recheck is set to false. Therefore, this should error
                     print_error("You are already checked in!");
                     $found=-1;   
                    }
                }// close allow_recheck conditional
            } // close meeting registration id check
         } //close for loop
                        
        if ($found==0){
            //we found meeting registrations for this person, but not for the correct meeting.
            print_error("There are meeting registrations for $first_name, but not this meeting!");
                                        
        }
                
    } else {
        print_error("No Registrations  found");
    }
} else {

    print_error("Contact not found");

}


?>