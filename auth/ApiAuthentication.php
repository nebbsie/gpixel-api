<?php

class ApiAuthentication{

    // This is just for DEV.


    private $key = 999;

    function checkKey($keyIn){
        if($this->key === intval($keyIn)){
            return true;
        }else{
            return false;
        }
    }

}