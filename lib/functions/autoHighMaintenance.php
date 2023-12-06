<?php
// session_start();
include_once('main.php');
include_once('auto_no.php');

class EntryHM extends Main
{

    public function insertHighMaintenance()
    {
        // this function automatically execute at specified time in 
        // task schedular and script .bat and .vbs file has inside autoScriptRunner folder
        date_default_timezone_set('Asia/Colombo');
       
        //select bus
        $sqlBuses = "SELECT * from bus WHERE busKms > 4700;";
        $sqlQuery = $this->connResult->query($sqlBuses);
        $nor = $sqlQuery->num_rows;

        if($nor>0){
            while ($rec = $sqlQuery->fetch_assoc()) {
                $busNo = $rec['busNo'];

                $sqlDupplicates = "SELECT * from high_maintenance WHERE busId='$busNo'
                AND DATE(dateTime) = CURDATE();";
                $sqlQuery1 = $this->connResult->query($sqlDupplicates);
                $nor1 = $sqlQuery1->num_rows;

                if($nor1 ==0){
                     //lets create a new mnt ID 
                    $mntId = new AutoNumberModule();
                    $ID = $mntId->number('mntId', 'high_maintenance', 'Mnt');

                    $sqlHMInsert = "INSERT INTO high_maintenance (mntId,busId,mntStatus)
                     VALUES ('$ID','$busNo',2);";
                    $sqlQuery2 = $this->connResult->query($sqlHMInsert);
                    // error checking section
                    if ($this->connResult->errno) {
                        echo ($this->connResult->error);
                        echo ("Check SQL");
                        exit;
                    }
                    if ($sqlQuery2 > 0 ) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            }
        }
    }//end




}
?>