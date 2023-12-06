<?php

include_once('connection.php');
class Main{
    public function __construct(){
        $this->connObj = new Connection("localhost","root","","yamove_db");
        $this->connResult = $this->connObj->makeConnection();
        return($this->connResult);
    }
    
}

?>