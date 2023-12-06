<?php
//include the main connection
include_once('main.php');

class AutoNumberModule extends Main{

    public function number($recId,$tblName,$string){
        // lets query the db table
        $sql= "SELECT $recId FROM $tblName ORDER BY $recId DESC LIMIT 1;";
        $sqlResult = $this->connResult->query($sql);

        // error checking section
        if($this->connResult->errno){
            echo($this->connResult->error);
            echo("check SQL");
            exit;
        }

        $nor = $sqlResult->num_rows;

        if($nor>0){
            $rec = $sqlResult->fetch_assoc();
            $len = $rec[$recId];
            // 0001...
            $number = substr($len,3); 
            // 1...
            $number++;
            // 2...
            $id = str_pad($number,4,'0',STR_PAD_LEFT);
            // 0002...
            $id = $string.$id;
        }
        else{
            $id = $string."0001";
        }
        return($id);    }
}

?>










