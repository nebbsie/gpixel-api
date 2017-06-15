<?php

header('Content-Type: application/json');
require_once('../db/DatabaseConnection.php');
require_once('../auth/ApiAuthentication.php');
require_once('../response/Response.php');
require_once('../helpers/UserHelper.php');
require_once ('../helpers/LeaderboardHelper.php');

$db = new DatabaseConnection();
$auth = new ApiAuthentication();
$response = new Response();
$lbHelper = new LeaderboardHelper();
$track = $_POST['trackID'];
$apiKey = $_POST['apiKey'];


// Check if the user has sent in an API key.
if(isset($apiKey)){
    // Check if the API key is valid.
    if($auth->checkKey($apiKey)){
        // Check if the user has sent the required POST data.
        if(isset($track)){
            // Check if connected to the SQL database.
            if($db->connect()){
                // Connected and authenticated, attempt login.
                $lbHelper->getTop10SpecificTrack($db, $track);
            }else{
                echo $response->getFailedResponse("Could not connect to the database.");
            }
        }else{
            echo $response->getFailedResponse("You did not set the correct POST data.");
        }
    }else{
        echo $response->getFailedResponse("Authentication failed.");
    }
}else{
    echo $response->getFailedResponse("Authentication failed.");
}
