<?php

class ApiAuthentication{

    private $key = 999;

    function checkKey($keyIn){
        if($this->key === intval($keyIn)){
            return true;
        }else{
            return false;
        }
    }

}