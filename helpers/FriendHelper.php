<?php

require_once('../response/Response.php');

class FriendHelper{

    private $response;
    private $helper;

    // 0 Pending
    // 1 Friends
    // 2 Blocked

    public function __construct(){
        $this->response = new Response();
        $this->helper = new UserHelper();
    }

    function getAllFriends($db, $username){
        $userID = $this->helper->getUserID($db, $username);
        $SQL_GET_ALL_FRIENDS = "SELECT * FROM friends WHERE relationship = 1 AND  user1ID = $userID OR user2ID = $userID";

        $result = $db->getConnection()->query($SQL_GET_ALL_FRIENDS);
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
            $this->response->getFailedResponse("no friends found.");
        }
    }

    function deleteFriend($db, $friendLink){
        $SQL_DELETE_FRIEND = "DELETE FROM friends WHERE friendLinkID = $friendLink";
        if(mysqli_query($db->getConnection(), $SQL_DELETE_FRIEND)){
            $this->response->getSuccessResponse("deleted friend link");
        }else{
            $this->response->getFailedResponse("failed to delete friend link");
        }
    }

    function blockFriend($db, $friendLinkID){
        $SQL_BLOCK_USER = "UPDATE friends SET relationship=2 WHERE friendLinkID=$friendLinkID";
        if(mysqli_query($db->getConnection(), $SQL_BLOCK_USER)){
            $this->response->getSuccessResponse("blocked friend");
        }else{
            $this->response->getFailedResponse("failed to block friend");
        }
    }

    function acceptFriend($db, $friendLink){
        $SQL_ACCEPT_FRIEND = "UPDATE friends SET relationship=1 WHERE friendLinkID = $friendLink" ;
        if(mysqli_query($db->getConnection(), $SQL_ACCEPT_FRIEND)){
            $this->response->getSuccessResponse("accepted friend link");
        }else{
            $this->response->getFailedResponse("failed to accept friend link");
        }
    }

    function createFriendLink($db, $username, $friendID){
        $userID = $this->helper->getUserID($db, $username);
        $SQL_CREATE_FREIND_LINK = "INSERT INTO friends (user1ID, user2ID) VALUES ($userID, $friendID)";

        if(mysqli_query($db->getConnection(), $SQL_CREATE_FREIND_LINK)){
            $this->response->getSuccessResponse("created friend link");
        }else{
            $this->response->getFailedResponse("failed to create friend link");
        }
    }

}