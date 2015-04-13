<?php

function mark_meeting_attended($meeting_registration_guid){
                
                  $post['key'] = API_KEY;
                  $post['operation'] = 'updateEntity';
                  $post['entity'] = 'cobalt_meetingregistration';
                  $post['guid']= $meeting_registration_guid;
                  $post['AttributeValues'] = 'cobalt_attendedmeeting=true,cobalt_mobilecheckin=true';
                  $json = curl_request($post);
                  $updateRegistrations = json_decode($json,true);


                  if($updateRegistrations["ResponseCode"]==204){
                        print_success("Successfully checked in!");    
                                                        
                  }  else {
                        print_error("There was an issue marking them attended");
              }
    
    
}

function getMeetingRegistrationFromContactID($contact_id){
         
            $post = array();
            $post['key'] = API_KEY;
            $post['operation'] = 'GetEntities';
            $post['entity'] = 'cobalt_meetingregistration';
            $post['attributes'] = 'cobalt_meetingregistrationid,cobalt_Contactid,cobalt_meetingid,cobalt_attendedmeeting';
            $post['filter'] = "statecode<eq>0 and cobalt_contactid<eq>$contact_id";
            $json = curl_request($post);
            $registrations = json_decode($json,true);
             //print_r($registrations);
            if(isset($registrations['Data'])){
            
            return $registrations;
            }
            
            return 0;
            
            
            
}

function getContactIDFromNRDS($nrds){
    $post = array();
    $post['key'] = API_KEY;
    $post['operation'] = 'GetEntities';
    $post['entity'] = 'Contact';
    $post['filter'] = "cobalt_NRDSID<eq>$nrds";
    $post['attributes'] = 'ContactId,FirstName,LastName';
    $json = curl_request($post);
    $data = json_decode($json, true);


   if(isset($data['Data'][0]['ContactId'])){
        echo $data['Data'][0]['FirstName']." ".$data['Data'][0]['LastName']."'s contact record has been found via RAMCO API<br>";
        $contact_id=$data['Data'][0]['ContactId']; 
        return $data;

    } 
    

        return 0;                    

    
}
function print_error($message){
     echo $message."<br>";
     echo "<audio controls autoplay>
                        <source src=\"failure.m4a\" type=\"audio/mp4\" >
                </audio>";
                
    if(REDIRECT){
    
    echo "<meta http-equiv=\"refresh\" content=\"". FAIL_TIMEOUT_SECONDS, ";URL='barcode.html'\" />";
    }
}

function print_success($message){
    echo $message."<br>";
    echo "<audio controls autoplay>
                        <source src=\"success.m4a\" type=\"audio/mp4\" >
        </audio>";
    if(REDIRECT){
        echo "<meta http-equiv=\"refresh\" content=\"". SUCCESS_TIMEOUT_SECONDS .";URL='barcode.html'\" />";
    }
}

function print_badge($first_name,$last_name){
    
if(PRINTING==TRUE){        
    $myfile = fopen("namebadge.txt", "w");
    $txt = "\n\n\n\n   $first_name $last_name\n   \n";        
    //echo $txt;
    fwrite($myfile, $txt);
    fclose($myfile);
    $output2 = shell_exec("cat namebadge.txt | lpr -o orientation-requested=4 -o cpi=6 ");
    }
}


/**
 * Handles the sending of requests to the RAMCO AP
 */
function curl_request($post) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, API_URL);
    curl_setopt($curl, CURLOPT_PORT , 443);
    curl_setopt($curl, CURLOPT_POST, True);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_VERBOSE, False);
    curl_setopt($curl, CURLOPT_HEADER, False);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
    curl_setopt($curl, CURLOPT_CAINFO, PEM_FILE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $resp_data = curl_exec($curl);
    $resp_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl); 
    return $resp_data;
}

 /**
 * Prints out arrays slightly prettier clearing RAMCO API Meta deta a RAMCO API request.
 * @param array string $arr
 * @return null
 */
function pretty_print($arr){
  
                 echo "<pre>";
                 print_r($arr);
                 echo "</a>";

}



/**
 * Handles clearing RAMCO API Meta deta a RAMCO API request.
 * This allows custom variables in RAMCO to be accessed immediately via the API
 */
function clearCache(){
  
                    $post = array();
                    $post['key'] = API_KEY;
                    $post['operation'] = 'clearCache';
                    
                    $json = curl_request($post);
                    $data = json_decode($json,true);
                    

}
?>