<?php
//API CONFIG
// PEM file is the cert file I use to validate certificate authenticity.
const PEM_FILE = 'cacert.pem';
// API URL is the same for every single API v2 request.
const API_URL = 'https://api.ramcoams.com/api/v2/';
// This is a fake, non-working API key, yours has to be substituted here.
const API_KEY = '';

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
    "http://savvycard.com/go/z1xu052" => "279545559",      // deborah - ALL SET
    "http://www.savvycard.com/go/e1ehewy" => "279536055", // Marty D. Nash - No QR Code on Savvy Card
    "http://www.savvycard.com/go/vng8zzv" => "729525837", // Leticia oliver - No QR Code on Savvy Card
    "http://www.savvycard.com/go/ev0zg70" => "277030309", // Joseph Penalver - NO QR Code on Savvy Card
    "http://www.savvycard.com/go/lcsuj15" => "277041119", //David Garcia - Cant Find Miami Assoc Savvy Card
    "http://www.savvycard.com/go/3ypdkl1" => "084001677", //David Conroy
    "http://www.savvycard.com/go/ybl8wfe" => "NO NRDS", //Daud Power
    "http://www.savvycard.com/go/sc04hl8" => "NO NRDS", //David Etheridge
//    "" => "81692795", // Teresa Kinney - NO QR Code on Savvy Card
);



?>
