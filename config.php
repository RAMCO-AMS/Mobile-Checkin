<?php
//API CONFIG
// PEM file is the cert file I use to validate certificate authenticity.
const PEM_FILE = 'cacert.pem';
// API URL is the same for every single API v2 request.
const API_URL = 'https://api.ramcoams.com/api/v2/';
// This is a fake, non-working API key, yours has to be substituted here.
const API_KEY = 'NAR-Stage-Fake-11bd0b401ae37118509d99949587f3ec0122e3de';

//MySQL Server CONFIG
$username = "user";
$password = "past";
$hostname = "localhost"; 
$myDB="db_name";

//Mobile Checkin Config
const USE_LOCAL_DATABASE=TRUE; // have you prepopulated a MySQL Database?
const ALLOW_RECHECK=TRUE; //allow people to check in multiple times
const DEBUG_MODE=1; // extra error reporting
const SUCCESS_TIMEOUT_SECONDS =1;   //how quickly the page redirects after a successful checkin
const FAIL_TIMEOUT_SECONDS=3;  //how long the page waits to return after a failed check in
const REDIRECT= TRUE;  // if the page redirects to the page to scan another badege
const PRINTING= FALSE;  // Experimental: Used for testing printing badges
const ACCEPT_SAVVYCARD=TRUE; // Experimental: Checks Array 

if (DEBUG_MODE){
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
};

//TBC: Do Meeting/Class Lookup to map this to HTML Radio Button
//GUID OF MEETING
const MEETING_ID="ca9ac760-a563-488e-b8ae-658c3aa77573";


//mapping of savvy cards to NRDS ID's
$savvy_card_id = array(
    
    "http://www.savvycard.com/go/3ypdkl1" => "084001677", //David Conroy
  
);



?>
