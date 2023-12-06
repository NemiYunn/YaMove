<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Notification extends Main{
    
    public function viewNotificationCount()
    {
        $sqlSelect = "SELECT * from reservation WHERE resStatus =2 ;";
        $notCount = $this->connResult->query($sqlSelect);
        $nor = $notCount->num_rows;
        return($nor);
    }

    public function reservationCount()
    {
        $sqlSelect = "SELECT * from reservation WHERE resStatus =2 ;";
        $notCount = $this->connResult->query($sqlSelect);
        $nor = $notCount->num_rows;
        return($nor);
    }

    // countNotification( changed duty assign for conductor)
    public function condNotification()
    {
        if (isset($_SESSION['YAMOVE_CON_ID'])) {
            $empId = $_SESSION['YAMOVE_CON_ID'];
        }

        $sqlSelect = "SELECT * from duty_change t1 INNER JOIN curr_duty t2 ON t1.dId = t2.Id
        WHERE newEmpId='$empId' AND DATE(t1.recTime) = CURDATE()  AND dcStatus = 1
        ORDER BY aId DESC;";
        
        $notCount = $this->connResult->query($sqlSelect);
        $nor = $notCount->num_rows;
        return($nor);
    }

     // countNotification( changed duty assign for driver)
     public function drvNotification()
     {
        if (isset($_SESSION['YAMOVE_DRIVER_ID'])) {
            $empId = $_SESSION['YAMOVE_DRIVER_ID'];
        }  
 
         $sqlSelect = "SELECT * from duty_change t1 INNER JOIN curr_duty t2 ON t1.dId = t2.Id
         WHERE newEmpId='$empId' AND DATE(t1.recTime) = CURDATE()  AND dcStatus = 1
         ORDER BY aId DESC;";
         
         $notCount = $this->connResult->query($sqlSelect);
         $nor = $notCount->num_rows;
         return($nor);
     }

  

    // reachLevelNotifyCount(sk)
    public function reachLevelNotifyCount()
    {
        $sqlSelectItem = "SELECT partNo, stock_level FROM item";
        $itemQuery = $this->connResult->query($sqlSelectItem);

        $count = 0;

        while ($item = $itemQuery->fetch_assoc()) {
            $partNo = $item['partNo'];
            $stockLevel = $item['stock_level'];

            $sqlSelectRemain = "SELECT partNo, SUM(remain) AS totalRemain
                            FROM restock
                            WHERE partNo = '$partNo'
                            GROUP BY partNo
                            HAVING totalRemain <= $stockLevel";

            $remainQuery = $this->connResult->query($sqlSelectRemain);

            if ($remainQuery->num_rows > 0) {
                $count++;
            }
        }
        return $count;
    }

    
    public function lateReturnsNotifyCount()
    {
        $sqlSelect = "SELECT * from issue_tool WHERE issueTlStatus =1  AND issueTime <= DATE_SUB(NOW(), INTERVAL 1 DAY);";
        $notCount = $this->connResult->query($sqlSelect);
        $nor = $notCount->num_rows;
        return($nor);
    }
    
    //breakdowns+maintenance+lateReturns (particular tech)
    public function bmrNotifyCount()
    {
        if (isset($_SESSION['YAMOVE_TECH_ID'])) {
            $empId = $_SESSION['YAMOVE_TECH_ID'];
        }
        // edit for get all B M LR
        $sqlSelect = "SELECT * from issue_tool WHERE issueTlStatus =1  AND empId='$empId' AND  issueTime <= DATE_SUB(NOW(), INTERVAL 1 DAY);";
        $notCount = $this->connResult->query($sqlSelect);
        $nor1 = $notCount->num_rows;

        $sqlSelect1 = "SELECT * from break_assign WHERE baStatus =3  AND techId='$empId';";
        $notCount1 = $this->connResult->query($sqlSelect1);
        $nor2 = $notCount1->num_rows;

        $sqlSelect2 = "SELECT * from mnt_assign WHERE maStatus =3  AND techId='$empId';";
        $notCount2 = $this->connResult->query($sqlSelect2);
        $nor3 = $notCount2->num_rows;

        $nor = $nor1 + $nor2 + $nor3;
        return($nor);
    }

    public function lateReturnsNotifyCountTech()
    {
        if (isset($_SESSION['YAMOVE_TECH_ID'])) {
            $empId = $_SESSION['YAMOVE_TECH_ID'];
        }

        $sqlSelect = "SELECT * from issue_tool WHERE issueTlStatus =1 AND empId='$empId' AND issueTime <= DATE_SUB(NOW(), INTERVAL 1 DAY);";
        $notCount = $this->connResult->query($sqlSelect);
        $nor = $notCount->num_rows;
        return($nor);
    }

    public function breakdownNotifyCountTech()
    {
        if (isset($_SESSION['YAMOVE_TECH_ID'])) {
            $empId = $_SESSION['YAMOVE_TECH_ID'];
        }

        $sqlSelect = "SELECT * from break_assign WHERE baStatus =3 AND techId='$empId';";
        $notCount = $this->connResult->query($sqlSelect);
        $nor = $notCount->num_rows;
        return($nor);
    }

    public function maintenanceNotifyCountTech()
    {
        if (isset($_SESSION['YAMOVE_TECH_ID'])) {
            $empId = $_SESSION['YAMOVE_TECH_ID'];
        }

        $sqlSelect = "SELECT * from mnt_assign WHERE maStatus =3 AND techId='$empId';";
        $notCount = $this->connResult->query($sqlSelect);
        $nor = $notCount->num_rows;
        return($nor);
    }


    //fmnNotification --> should change later for other notifes (brk + mntnc)
    public function fmnNotification()
    {
        //brk
        $sqlSelect = "SELECT * from breakdown WHERE brkStatus =2;";
        $notCount = $this->connResult->query($sqlSelect);
        $nor1 = $notCount->num_rows;
        //ended
        $sqlSelect2 = "SELECT * from break_assign WHERE baStatus =1;";
        $notCount2 = $this->connResult->query($sqlSelect2);
        $nor2 = $notCount2->num_rows;

        //mnt
        $sqlSelect3 = "SELECT * from high_maintenance WHERE mntStatus =2;";
        $notCount3 = $this->connResult->query($sqlSelect3);
        $nor3 = $notCount3->num_rows;
        //ended
        $sqlSelect4 = "SELECT * from mnt_assign WHERE maStatus =1;";
        $notCount4 = $this->connResult->query($sqlSelect4);
        $nor4 = $notCount4->num_rows;

        $nor = $nor1 + $nor2 + $nor3 +$nor4;
        return($nor);
    }

    //breakdownsCount
    public function breakdownsCount()
    {
        $sqlSelect = "SELECT * from breakdown WHERE brkStatus =2;";
        $notCount = $this->connResult->query($sqlSelect);
        $nor1 = $notCount->num_rows;
        //ended
        $sqlSelect2 = "SELECT * from break_assign WHERE baStatus =1;";
        $notCount2 = $this->connResult->query($sqlSelect2);
        $nor2 = $notCount2->num_rows;

        $nor = $nor1 + $nor2;
        return ($nor);
    }

    //maintenanceCount
    public function maintenanceCount()
    {
        $sqlSelect = "SELECT * from high_maintenance WHERE mntStatus =2;";
        $notCount = $this->connResult->query($sqlSelect);
        $nor1 = $notCount->num_rows;
        //ended
        $sqlSelect2 = "SELECT * from mnt_assign WHERE maStatus =1;";
        $notCount2 = $this->connResult->query($sqlSelect2);
        $nor2 = $notCount2->num_rows;

        $nor = $nor1 + $nor2 ;
        return ($nor);
    }



}