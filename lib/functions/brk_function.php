<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Breakdown extends Main{
    // add new halt
    public function addBreakdown($issue){
        if (isset($_SESSION['YAMOVE_CON_ID'])) {
            $empId = $_SESSION['YAMOVE_CON_ID'];
        }
        //lets create a new route ID 
        $brkId = new AutoNumberModule();
        $ID = $brkId->number('brkId', 'breakdown', 'Brk');

        $sqlSelect = "SELECT * from duty_change WHERE newEmpId='$empId' AND DATE(recTime) = CURDATE();";
        $dc = $this->connResult->query($sqlSelect);
        $nor= $dc->num_rows;

        if($nor ==1){
            $rec = $dc->fetch_assoc();
            $dId = $rec['dId'];

            $sqlSelect1 = "SELECT * from curr_duty WHERE Id='$dId';";
            $dc1 = $this->connResult->query($sqlSelect1);
            $rec1 = $dc1->fetch_assoc();
            $schId = $rec1['schId'];
            $busId = $rec['newBusId'];
        }else if($nor ==0) {
            $sqlSelect2 = "SELECT * from curr_duty WHERE empId='$empId' AND DATE(recTime) = CURDATE(); ;";
            $dc2 = $this->connResult->query($sqlSelect2);
            $rec2 = $dc2->fetch_assoc();
            $schId = $rec2['schId'];
            $busId = $rec2['busId'];
        }
        $sqlBrkInsert = "INSERT INTO breakdown (brkId,issue,schId,conId,busId,brkStatus) 
        VALUES ('$ID','$issue','$schId','$empId','$busId',2);";
            $sqlQuery = $this->connResult->query($sqlBrkInsert);
            // error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("Check SQL");
                exit;
            }
            if ($sqlQuery > 0) {
                return 1;
            } else {
                return 0;
            }

    }



}
