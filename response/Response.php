<?php

class Response
{

    function getSuccessResponse($data){
        echo json_encode(array("success" => true, "data" => $data));
    }

    function getFailedResponse($message){
        echo json_encode(array("success" => false, "message" => $message));
    }

}