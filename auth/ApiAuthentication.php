<?php

class ApiAuthentication{

    // This is just for DEV purposes, in production a full auth system will be implemented.


    private $key = 999;

    function checkKey($keyIn){
        if($this->key === intval($keyIn)){
            return true;
        }else{
            return false;
        }
    }

}
