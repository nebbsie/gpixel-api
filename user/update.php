<?php
header('Content-Type: application/json');
require_once('../db/DatabaseConnection.php');
require_once('../auth/ApiAuthentication.php');
require_once('../response/Response.php');
require_once('../helpers/UserHelper.php');

$db = new DatabaseConnection();
$auth = new ApiAuthentication();
$response = new Response();
$userHelper = new UserHelper();
$password = $_POST['password'];
$username = $_POST['username'];
$email = $_POST['email'];
$apiKey = $_POST['apiKey'];


// Check if the user has sent in an API key.
if(isset($apiKey)){
    // Check if the API key is valid.
    if($auth->checkKey($apiKey)){
        // Check if the user has sent the required POST data.
        if(isset($username) && isset($password) && isset($email)){
            // Check if connected to the SQL database.
            if($db->connect()){
                // Connected and authenticated, attempt login.
                $userHelper->updateUser($db, $username, $password, $email);
            }else{
                $response->getFailedResponse("Could not connect to the database.");
            }
        }else{
            $response->getFailedResponse("You did not set the correct POST data.");
        }
    }else{
        $response->getFailedResponse("Authentication failed.");
    }
}else{
    $response->getFailedResponse("Authentication failed.");
}
