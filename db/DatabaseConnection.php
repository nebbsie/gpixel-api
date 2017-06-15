<?php

class DatabaseConnection{

  private $serverName = "localhost";
  private $username = "root";
  private $password = "bellamy";
  private $databaseName = "gpixel";
  private $conn;

  function getConnection(){
      return $this->conn;
  }

  function connect(){
    $this->conn = new mysqli($this->serverName, $this->username, $this->password, $this->databaseName);
    if($this->conn -> connect_error){
      return false;
    }else{
      return true;
    }
  }
}
