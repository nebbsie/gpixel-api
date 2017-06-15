<?php

require_once ("UserHelper.php");
require_once ("../response/Response.php");

class LeaderboardHelper{

    private $response;
    private $helper;

    public function __construct(){
        $this->response = new Response();
        $this->helper = new UserHelper();
    }

    function getTop10SpecificTrack($db, $trackID){
        // Create the SQL
        $SQL_GET_TOP_SCORES_TRACK = "SELECT * FROM leaderboard WHERE trackID = $trackID ORDER BY score LIMIT 10";
        $result = $db->getConnection()->query($SQL_GET_TOP_SCORES_TRACK);

        if($result->num_rows > 0){
            $data = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            $this->response->getSuccessResponse($data);
        }else{
            $this->response->getFailedResponse("no scores for this track");
        }

    }

    function getTopScoreSpecificTrack($db, $username, $trackID){
        // Gets the userID from the username.
        $userID = $this->helper->getUserID($db, $username);
        // Create the SQL
        $SQL_GET_TOP_SCORES_TRACK = "SELECT * FROM leaderboard WHERE userID = $userID AND trackID = $trackID ORDER BY score LIMIT 1";

        $result = $db->getConnection()->query($SQL_GET_TOP_SCORES_TRACK);

        if($result->num_rows > 0 ){
            $data = $result->fetch_assoc();
            // Return JSON
            $this->response->getSuccessResponse($data);
        }else{
            $this->response->getFailedResponse("no scores currently saved for that track");
        }
    }

    function getTopScoreAllTracks($db, $username){
        // Gets the userID from the username.
        $userID = $this->helper->getUserID($db, $username);
        // Create the SQL
        $SQL_GET_TOP_SCORES = "SELECT * FROM leaderboard WHERE userID = $userID ORDER BY trackID,score";
        // Executes the SQL
        $result = $db->getConnection()->query($SQL_GET_TOP_SCORES);

        // Check if results have been returned.
        if($result->num_rows > 0 ){
            // Put the highest score for each track into the array.
            $data = array();
            $current = null;
            while($row = $result->fetch_assoc()){
                // Check if its the lowest score.
                if($current !== $row['trackID']){
                    $data[] = $row;
                }
                $current = $row['trackID'];
            }
            // Return JSON
            $this->response->getSuccessResponse($data);
        }else{
            $this->response->getFailedResponse("no scores currently saved.");
        }
    }

    function getAllScoresForTrack($db, $trackID){
        // Create SQL query
        $SQL_GET_ALL_SCORES = "SELECT * FROM leaderboard WHERE trackID = $trackID";
        // Store the result of the query
        $result = $db->getConnection()->query($SQL_GET_ALL_SCORES);
        // Check if the query returned a result
        if($result->num_rows > 0 ){
            // Put each object into the array and return to user
            $data = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            // Return JSON
            $this->response->getSuccessResponse($data);
        }else{
            $this->response->getFailedResponse("no scores currently saved.");
        }
    }

    function getAllScoresForUser($db, $username){
        $userID = $this->helper->getUserID($db, $username);
        $userIDInt = intval($userID);
        // Create SQL query
        $SQL_GET_ALL_SCORES = "SELECT * FROM leaderboard WHERE userID = $userIDInt";
        // Store the result of the query
        $result = $db->getConnection()->query($SQL_GET_ALL_SCORES);
        // Check if the query returned a result
        if($result->num_rows > 0 ){
            // Put each object into the array and return to user
            $data = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            // Return JSON
            $this->response->getSuccessResponse($data);
        }else{
            $this->response->getFailedResponse("no scores currently saved.");
        }
    }

    function getAllScores($db){
        // Create SQL query
        $SQL_GET_ALL_SCORES = "SELECT * FROM leaderboard";
        // Store the result of the query
        $result = $db->getConnection()->query($SQL_GET_ALL_SCORES);
        // Check if the query returned a result
        if($result->num_rows > 0 ){
            // Put each object into the array and return to user
            $data = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            // Return JSON
           $this->response->getSuccessResponse($data);
        }else{
            $this->response->getFailedResponse("no scores currently saved.");
        }
    }

    function addLeaderboardScore($db, $username, $map, $score){
        // Get the userID with the username
        $userID = $this->helper->getUserID($db, $username);
        $track = intval($map);
        $scoreInt = intval($score);
        $userIDInt = intval($userID);
        // Check if the userID is set.
        if(isset($userID)){
            // Create SQL query
            $SQL_SAVE_SCORE = "INSERT INTO leaderboard (userID, trackID, score) VALUES ($userID, $map, $score)";

            // Performs the query and checks if successful.
            if(mysqli_query($db->getConnection(), $SQL_SAVE_SCORE)){
                $this->response->getSuccessResponse("Saved new score");
            }else{
                $this->response->getFailedResponse("Failed to save score.");
            }
        }else{
            $this->response->getFailedResponse("Could not get userID");
        }
    }
}