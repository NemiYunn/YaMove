<?php

class Connection{
    private $server;
    private $user;
    private $password;
    private $database;

    // constructor
    public function __construct($server,$user,$password,$database){
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
    }
    // connection method
    public function makeConnection(){
        $conn = mysqli_connect($this->server,$this->user,$this->password,$this->database);
        $result = ($conn->errno)?null:$conn;
        return($result);
    }  
}

?>



