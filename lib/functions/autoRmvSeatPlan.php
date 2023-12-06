<?php
//include the main connection
include_once('main.php');

class EntrySP extends Main
{

    public function removeEntries()
    {
        // this function automatically execute at specified time in 
        // task schedular and script .bat and .vbs file has inside autoScriptRunner folder
        date_default_timezone_set('Asia/Colombo');
        $currentTimestamp = time();
        $twelveMinutesAgo = $currentTimestamp - (12 * 60); // 12 minutes ago in seconds
   
        $sqlUpdateSeatPlan = "DELETE FROM seat_plan  WHERE planStatus = 2 AND recordTime <= FROM_UNIXTIME($twelveMinutesAgo);";
        $sqlQuerySeat = $this->connResult->query($sqlUpdateSeatPlan);
       
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }

        if ($sqlQuerySeat > 0 ) {
            return "success";
        } else {
            return "Failed";
        }
    }
}
?>