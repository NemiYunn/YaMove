<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Foreman extends Main
{
    public function viewBreakdowns()
    {

        $sql = "SELECT * FROM breakdown WHERE brkStatus=2;";
        $result = $this->connResult->query($sql);

        $foundMatch = false; // Flag variable

        echo ('
    <table class="table table-bordered table-responsive-lg">
    <thead>
        <tr>
            <th scope="col">Bus No</th>
            <th scope="col">Issue</th>
            <th scope="col">ASSIGN</th>
        </tr>
    </thead>
    <tbody>
    ');
        while ($rec = $result->fetch_assoc()) {
            $foundMatch = true; // Set the flag to true
            // Put data into table
            echo ("
        <tr>
            <td>" . $rec['busId'] . "</td>
            <td>" . $rec['issue'] . "</td>
            <td><button id=" . $rec['brkId'] . " class='btn btn-outline-primary btn-sm no-print asgnBtn'>ASSIGN</button></td>
        </tr>");
        }

        echo ('
    </tbody>
    </table>
    ');

        if (!$foundMatch) {
            echo ('
        <p>No Breakdowns</p>
        ');
        }
    } //end


    //getTechies for both brk and mnt
    public function getTechies()
    {
        $sqlViewTechies = "SELECT * FROM emp_login WHERE login_role='technician' 
        AND login_status = 1 ;";
        $sqlQuery = $this->connResult->query($sqlViewTechies);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }

        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            echo ('
            <option selected disabled >Technicians :</option>
           ');
            while ($rec = $sqlQuery->fetch_assoc()) {

                $techId = $rec['login_id'];

                //break assign
                $sqlViewTechies1 = "SELECT *, (SELECT COUNT(*) FROM break_assign 
                WHERE techId = '$techId' AND (baStatus = 3 OR  baStatus = 2 OR baStatus = 1)) AS row_count1
                FROM break_assign
                WHERE techId = '$techId' AND (baStatus = 3 OR  baStatus = 2 OR baStatus = 1);
                ";
                $sqlQuery1 = $this->connResult->query($sqlViewTechies1);
                $nor1 = $sqlQuery1->num_rows;

                //maintenance assign
                $sqlViewTechies2 = "SELECT *, (SELECT COUNT(*) FROM mnt_assign 
                WHERE techId = '$techId' AND (maStatus = 3 OR  maStatus = 2 OR maStatus = 1)) AS row_count2
                FROM mnt_assign
                WHERE techId = '$techId' AND (maStatus = 3 OR  maStatus = 2 OR maStatus = 1);
                ";
                $sqlQuery2 = $this->connResult->query($sqlViewTechies2);
                $nor2 = $sqlQuery2->num_rows;

                $norr = $nor1 + $nor2;

                if ($norr > 0) {
                    $rec1 = $sqlQuery1->fetch_assoc();
                    $rec2 = $sqlQuery2->fetch_assoc();

                    $works = $rec1['row_count1'] + $rec2['row_count2'];
                    echo ("
                    <option value='" . $techId . "'> " .  $techId . ' - ' . $works . "</option>
                    ");
                } else {
                    echo ("
                    <option value='" .  $rec['login_id'] . "'> " .  $rec['login_id'] . ' - 0' . "</option>
                    ");
                }
            }
        } else {
            echo ('
            <option value="">No Technicians available.</option>
            ');
        }
    }

    public function asignTechnician($tech, $brkId)
    {
        if (isset($_SESSION['YAMOVE_FM_ID'])) {
            $fmnId = $_SESSION['YAMOVE_FM_ID'];
        }
        $sqlselect = "SELECT * FROM break_assign t1 INNER JOIN breakdown t2 ON t1.brkId = t2.brkId 
        WHERE t1.brkId='$brkId' AND t1.techId='$tech';";
        $sqlQuerySel = $this->connResult->query($sqlselect);
    
        // Check if the query was successful
        if (!$sqlQuerySel) {
            echo ($this->connResult->error);
            echo ("Check SQL");
            exit;
        }
    
        // Check the number of rows returned
        if ($sqlQuerySel->num_rows === 0) {
            $sqlBrkAssignInsert = "INSERT INTO break_assign (brkId,techId,fmnId,baStatus) 
                VALUES ('$brkId','$tech','$fmnId',3);";
            $sqlQuery = $this->connResult->query($sqlBrkAssignInsert);
    
            //change bus status
            $sqlBus = "SELECT * FROM breakdown WHERE brkId='$brkId';";
            $sqlQuery1 = $this->connResult->query($sqlBus);
            $rec1 = $sqlQuery1->fetch_assoc();
            $busId = $rec1['busId'];
    
            $sqlStateUpdate = "UPDATE bus SET busState = 'onMaintenance' WHERE busNo='$busId';";
            $sqlQuery2 = $this->connResult->query($sqlStateUpdate);
    
            $sqlBrkStatusUpdate = "UPDATE breakdown SET brkStatus = 1 WHERE brkId='$brkId';";
            $sqlQuery3 = $this->connResult->query($sqlBrkStatusUpdate);
    
            // error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("Check SQL");
                exit;
            }
    
            // Check if the update and insert queries were successful
            if ($sqlQuery && $sqlQuery2 && $sqlQuery3) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    

    public function viewCompletedBreakdowns()
    {

        $sql = "SELECT * FROM break_assign t1 INNER JOIN breakdown t2 ON t1.brkId = t2.brkId  WHERE t1.baStatus=1 ;";
        $result = $this->connResult->query($sql);

        $foundMatch = false; // Flag variable

        echo ('
    <table class="table table-bordered table-responsive-lg">
    <thead>
        <tr>
            <th scope="col">Completed Task</th>
            <th scope="col">CONFIRM</th>
        </tr>
    </thead>
    <tbody>
    ');
        while ($rec = $result->fetch_assoc()) {
            $foundMatch = true; // Set the flag to true

            $sql1 = "SELECT * FROM emp_reg  WHERE emp_id ='$rec[techId]' ;";
            $result1 = $this->connResult->query($sql1);
            $rec1 = $result1->fetch_assoc();

            // Put data into table
            echo ("
    <tr>
        <td> Technician ( Mr." . $rec1['emp_name'] . " ) has completed working on Bus no: "
                . $rec['busId'] . " . Check and confirm task completion.</td>
        <td><button id=" . $rec['Id'] . " class='btn btn-outline-info btn-sm no-print doneBtn'>CONFIRM</button></td>
    </tr>");
        }

        echo ('
    </tbody>
    </table>
    ');

        if (!$foundMatch) {
            echo ('
    <p>No Completed Tasks Yet</p>
    ');
        }
    } //end


    public function confirmBrkTask($baId)
    {

        if (isset($_SESSION['YAMOVE_FM_ID'])) {
            $fmnId = $_SESSION['YAMOVE_FM_ID'];
        }

        //change bus status
        $sqlSelect = "SELECT * FROM break_assign t1 INNER JOIN breakdown t2 ON t1.brkId = t2.brkId  WHERE Id='$baId';";
        $sqlQuery = $this->connResult->query($sqlSelect);
        $rec = $sqlQuery->fetch_assoc();

        $busId = $rec['busId'];

        $sqlStateUpdate = "UPDATE bus SET busState = 'onOperate' WHERE busNo='$busId';";
        $sqlQuery1 = $this->connResult->query($sqlStateUpdate);

        $sqlBrkStatusUpdate = "UPDATE breakdown SET brkStatus = 0 WHERE brkId='$rec[brkId]';";
        $sqlQuery2 = $this->connResult->query($sqlBrkStatusUpdate);

        $sqlBaStatusUpdate = "UPDATE break_assign SET baStatus = 0, checkedBy='$fmnId' WHERE Id='$baId';";
        $sqlQuery3 = $this->connResult->query($sqlBaStatusUpdate);

        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("Check SQL");
            exit;
        }
        if ($sqlQuery1 > 0 && $sqlQuery2 > 0 && $sqlQuery3 > 0) {
            return 1;
        } else {
            return 0;
        }
    }//end

    public function viewMaintenance()
    {

        $sql = "SELECT * FROM high_maintenance WHERE mntStatus=2;";
        $result = $this->connResult->query($sql);

        $foundMatch = false; // Flag variable

        echo ('
    <table class="table table-bordered table-responsive-sm">
    <thead>
        <tr>
            <th scope="col">Bus No</th>
            <th scope="col">ASSIGN</th>
        </tr>
    </thead>
    <tbody>
    ');
        while ($rec = $result->fetch_assoc()) {
            $foundMatch = true; // Set the flag to true
            // Put data into table
            echo ("
        <tr>
            <td>" . $rec['busId'] . "</td>
            <td><button id=" . $rec['mntId'] . " class='btn btn-outline-primary btn-sm no-print asgnBtn'>ASSIGN</button></td>
        </tr>");
        }

        echo ('
    </tbody>
    </table>
    ');

        if (!$foundMatch) {
            echo ('
        <p>No Maintenace</p>
        ');
        }
    } //end


    //asignTechnician for Maintenance
    public function asignMntTechnician($tech, $mntId)
    {
        if (isset($_SESSION['YAMOVE_FM_ID'])) {
            $fmnId = $_SESSION['YAMOVE_FM_ID'];
        }
        $sqlselect = "SELECT * FROM mnt_assign t1 INNER JOIN high_maintenance t2 ON t1.mntId = t2.mntId 
        WHERE t1.mntId='$mntId' AND t1.techId='$tech';";
        $sqlQuerySel = $this->connResult->query($sqlselect);
    
        // Check if the query was successful
        if (!$sqlQuerySel) {
            echo ($this->connResult->error);
            echo ("Check SQL");
            exit;
        }
    
        // Check the number of rows returned
        if ($sqlQuerySel->num_rows === 0) {
            $sqlMntAssignInsert = "INSERT INTO mnt_assign (mntId,techId,fmnId,maStatus) 
                VALUES ('$mntId','$tech','$fmnId',3);";
            $sqlQuery = $this->connResult->query($sqlMntAssignInsert);
    
            //change bus status
            $sqlBus = "SELECT * FROM high_maintenance WHERE mntId='$mntId';";
            $sqlQuery1 = $this->connResult->query($sqlBus);
            $rec1 = $sqlQuery1->fetch_assoc();
            $busId = $rec1['busId'];
    
            $sqlStateUpdate = "UPDATE bus SET busState = 'onMaintenance' WHERE busNo='$busId';";
            $sqlQuery2 = $this->connResult->query($sqlStateUpdate);
    
            $sqlMntStatusUpdate = "UPDATE high_maintenance SET mntStatus = 1 WHERE mntId='$mntId';";
            $sqlQuery3 = $this->connResult->query($sqlMntStatusUpdate);
    
            // error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("Check SQL");
                exit;
            }
    
            // Check if the update and insert queries were successful
            if ($sqlQuery && $sqlQuery2 && $sqlQuery3) {
                return 1;
            } else {
                return 0;
            }
        }
    }//end

    public function viewCompletedMaintenance()
    {

        $sql = "SELECT * FROM mnt_assign t1 INNER JOIN high_maintenance t2 ON t1.mntId = t2.mntId  WHERE t1.maStatus=1 ;";
        $result = $this->connResult->query($sql);

        $foundMatch = false; // Flag variable

        echo ('
    <table class="table table-bordered table-responsive-lg">
    <thead>
        <tr>
            <th scope="col">Completed Task</th>
            <th scope="col">CONFIRM</th>
        </tr>
    </thead>
    <tbody>
    ');
        while ($rec = $result->fetch_assoc()) {
            $foundMatch = true; // Set the flag to true

            $sql1 = "SELECT * FROM emp_reg  WHERE emp_id ='$rec[techId]' ;";
            $result1 = $this->connResult->query($sql1);
            $rec1 = $result1->fetch_assoc();

            // Put data into table
            echo ("
    <tr>
        <td> Technician ( Mr." . $rec1['emp_name'] . " ) has completed working on Bus no: "
                . $rec['busId'] . " . Check and confirm task completion.</td>
        <td><button id=" . $rec['Id'] . " class='btn btn-outline-info btn-sm no-print doneBtn'>CONFIRM</button></td>
    </tr>");
        }

        echo ('
    </tbody>
    </table>
    ');

        if (!$foundMatch) {
            echo ('
    <p>No Completed Tasks Yet</p>
    ');
        }
    } //end


    public function confirmMntTask($maId)
    {

        if (isset($_SESSION['YAMOVE_FM_ID'])) {
            $fmnId = $_SESSION['YAMOVE_FM_ID'];
        }

        //change bus status
        $sqlSelect = "SELECT * FROM mnt_assign t1 INNER JOIN high_maintenance t2 ON t1.mntId = t2.mntId  WHERE Id='$maId';";
        $sqlQuery = $this->connResult->query($sqlSelect);
        $rec = $sqlQuery->fetch_assoc();

        $busId = $rec['busId'];

        $sqlStateUpdate = "UPDATE bus SET busState = 'onOperate' WHERE busNo='$busId';";
        $sqlQuery1 = $this->connResult->query($sqlStateUpdate);

        $sqlMntStatusUpdate = "UPDATE high_maintenance SET mntStatus = 0 WHERE mntId='$rec[mntId]';";
        $sqlQuery2 = $this->connResult->query($sqlMntStatusUpdate);

        $sqlMaStatusUpdate = "UPDATE mnt_assign SET maStatus = 0, checkedBy='$fmnId' WHERE Id='$maId';";
        $sqlQuery3 = $this->connResult->query($sqlMaStatusUpdate);

        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("Check SQL");
            exit;
        }
        if ($sqlQuery1 > 0 && $sqlQuery2 > 0 && $sqlQuery3 > 0) {
            return 1;
        } else {
            return 0;
        }
    }//end


}
?>