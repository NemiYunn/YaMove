<?php
session_start();

include_once('main.php');
// include_once('auto_no.php');

class Attendance extends Main
{
    public function markAttendance($nic)
    {
        // return($nic)
        date_default_timezone_set("Asia/colombo");
        $hour = date('H');
        $sqlViewAtt = "SELECT * FROM attendance WHERE nic='$nic' AND HOUR(attTime)= '$hour' AND  DATE(attTime) = CURDATE() ; ";
        $atten = $this->connResult->query($sqlViewAtt);
        $norr = $atten->num_rows;
        if ($norr < 1) {

            $sqlViewEmp = "SELECT * FROM emp_reg WHERE emp_nic='$nic' ; ";
            $emp = $this->connResult->query($sqlViewEmp);
            $nor = $emp->num_rows;

            if ($nor == 0) {
                return 1;
            } else if ($nor == 1) {
                $rec = $emp->fetch_assoc();
                $empId = $rec['emp_id'];
                $sqlInsert = "INSERT INTO attendance(empId,nic,attStatus) VALUES ('$empId','$nic',1) ;";
                $sqlQueryInsert = $this->connResult->query($sqlInsert);
            }
            // error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("Check SQL");
                exit;
            }
            if ($sqlQueryInsert > 0) {
                echo json_encode($rec);
            } else {
                return "Sorry! Failed .";
            }
        }else{
            return "Sorry! Failed .";
        }
    }

}

?>
    