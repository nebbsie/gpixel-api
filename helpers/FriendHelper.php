<?php

require_once('../response/Response.php');

class FriendHelper{

    private $response;
    private $helper;

    public function __construct(){
        $this->response = new Response();
        $this->helper = new UserHelper();
    }

    function deleteFriend($db, $friendLink){
        $SQL_DELETE_FRIEND = "DELETE FROM friends WHERE friendLinkID = $friendLink";
        if(mysqli_query($db->getConnection(), $SQL_DELETE_FRIEND)){
            $this->response->getSuccessResponse("deleted friend link");
        }else{
            $this->response->getFailedResponse("failed to delete friend link");
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