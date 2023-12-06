<?php
//include the main connection
include_once('main.php');

class Entry extends Main{
    
    public function addEntry()
    {
        // this function automatically execute at specified time in the
        // task schedular and script .bat and .vbs file has inside autoScriptRunner folder
        $month = date("F");
        $day = date("d");
        $year = date("Y");
        // retreive duties from roster for the day
        $sqlViewOne = "SELECT empId,JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.$day')) as schNum
                         FROM roster WHERE months='$month' AND years='$year' AND rosStatus=1
                         ORDER BY schNum DESC;";
        $sqlQuery1 = $this->connResult->query($sqlViewOne);
        $nor1 = $sqlQuery1->num_rows;

        if ($nor1 > 0) {
            while ($rec1 = $sqlQuery1->fetch_assoc()) {
                $schNum = $rec1['schNum'];
                $emp = $rec1['empId'];

                $sqlRole = "SELECT login_role from emp_login WHERE login_id='$emp';";
                $empRole = $this->connResult->query($sqlRole);
                $recd = $empRole->fetch_assoc();
                $role = $recd['login_role'];

                $sqlViewTwo = "SELECT schId,schNo,busNo
                         FROM schedules WHERE schStatus=1 AND schNo= '$schNum' GROUP BY schNo;";
                $sqlQuery2 = $this->connResult->query($sqlViewTwo);

                // error checking section
                if ($this->connResult->errno) {
                    echo ($this->connResult->error);
                    echo ("check sql");
                    exit;
                }
                $nor = $sqlQuery2->num_rows;
                if ($nor > 0) {
                    while ($rec = $sqlQuery2->fetch_assoc()) {
                        // insert(auto upload) data into the table at 4am every day
                        $sqlDutyInsert = "INSERT INTO curr_duty(schId,empId,busId,dtStatus) VALUES ('$rec[schId]','$emp','$rec[busNo]',1);";
                        $sqlQuery = $this->connResult->query($sqlDutyInsert);
                    }
                } else {
                    echo"No such schedule found";
                }  
            }
        }
    }
    }
?>