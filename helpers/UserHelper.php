<?php

require_once('../response/Response.php');

class UserHelper{

    private $response;

    public function __construct(){
        $this->response = new Response();
    }

    function updateUser($db, $username, $password, $email){
        $SQL_UPDATE_USER = "UPDATE users SET username='$username' , password='$password', userEmail='$email'
                            WHERE username = '$username'";

        if($this->checkIfUserExists($db, $username)){
            // Performs the query and checks if successful.
            if(mysqli_query($db->getConnection(), $SQL_UPDATE_USER)){
                $this->response->getSuccessResponse("Updated user account");
            }else{
                $this->response->getFailedResponse("Failed to update user account.");
            }
        }else{
            $this->response->getFailedResponse("Account with that username doesn't exists.");
        }
    }

    function createUser($db, $username, $password, $email){
        // Check if the user account already exists.
        if($this->checkIfUserExists($db, $username)){
            $this->response->getFailedResponse("Account with that username or password already exists.");
        }else{
            // Create SQL query.
            $SQL_CREATE_USER = "INSERT INTO users (username, password, userEmail) VALUES ('$username', '$password', '$email')";

            // Performs the query and checks if successful.
            if(mysqli_query($db->getConnection(), $SQL_CREATE_USER)){
                $this->response->getSuccessResponse("Created user account");
            }else{
                $this->response->getFailedResponse("Failed to create new account.");
            }
        }
    }

    function getUserID($db, $username){
        $SQL_GET_USERID = "SELECT userID FROM users WHERE username = '$username'";
        $result = $db->getConnection()->query($SQL_GET_USERID);
        $userID = $result->fetch_assoc();
        return $userID['userID'];
    }

    function loginUser($db, $username, $password){
        // Create SQL query
        $SQL_LOGIN_USER = "SELECT * FROM users WHERE (username, password) = ('$username', '$password')";
        // Gets the result from the query
        $result = $db->getConnection()->query($SQL_LOGIN_USER);

        // Checks if the user exists.
        if($result->num_rows > 0){
            return $result->fetch_assoc();
        }else{
            return false;
        }
    }

    function checkIfUserExists($db, $username){
        // Create SQL query
        $SQL_SEARCH_USER = "SELECT * FROM users WHERE username = '$username'";
        // Gets the result from the query.
        $result = $db->getConnection()->query($SQL_SEARCH_USER);

        // Checks if the user exists or not.
        if($result->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }
}