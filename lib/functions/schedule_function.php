<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Schedules extends Main{

    // create new schedule
    public function addNewSchedule($rtNo,$schNo,$busNo,$stTime,$endTime,$ntStay){
        //lets create a new route ID 
        $schId = new AutoNumberModule();
        $ID = $schId->number('schId', 'schedules', 'Sch');

        $sqlRoute = "SELECT rtId from routes WHERE rtNo='$rtNo';";
        $sqlRt = $this->connResult->query($sqlRoute);
        $rec = $sqlRt->fetch_assoc();
        $rtId = $rec['rtId'];

       
            
         if($busNo !="none"){
            $sqlSchInsert = "INSERT INTO schedules VALUES ('$ID','$schNo','$stTime','$endTime','$ntStay',1 ,'$rtId','$busNo');";
            $sqlQuery = $this->connResult->query($sqlSchInsert);
        }else if($busNo =='none'){
            $busNew ="NULL";

            $sqlSchInsert = "INSERT INTO schedules VALUES ('$ID','$schNo','$stTime','$endTime','$ntStay',0 ,'$rtId','$busNew');";
            $sqlQuery = $this->connResult->query($sqlSchInsert);
        }
        // echo ($busId);
        // error checking section
        if($this->connResult->errno){
            echo($this->connResult->error);
            echo("Check SQL");
            exit;
        }
        if($sqlQuery>0){
            return "Schedule added successfully!";
        } else {
            return "Sorry! Failed to add schedule.";
        }
    }

    // viewSchedules
    public function viewSchedules()
    {
        $limit = 3;
        $links = 2;
        $page = 0;
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
        } else {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;

        $sqlViewScheds = "SELECT * FROM schedules t1 INNER JOIN routes t2 ON t1.routeId = t2.rtId WHERE t2.rtStatus = 1  ORDER BY schNo DESC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlViewScheds);
        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
        <table class="table table-bordered table-responsive-lg">
        <thead>
            <tr>
                <th scope="col" id="schNo">Schedule No</th>
                <th scope="col" id="route">Route</th>
                <th scope="col">Bus No</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time </th>
                <th scope="col">Night Stay</th>
                <th scope="col" class="no-print">UPDATE</th>
                <th scope="col" class="no-print">Manage Trips</th>
                <th scope="col" class="no-print">ACT/DEACT</th>
            </tr>
        </thead>
        <tbody>
        ');

    $nor = $sqlQuery->num_rows;

    if ($nor > 0) {
        while ($rec = $sqlQuery->fetch_assoc()) {
                if($rec['busNo'] != "NULL") {
                    $busNo = $rec['busNo'];
                }else{
                    $busNo = "Not added yet.";
                }
                
            // put data into table
            echo ("
                <tr>
                    <td>" . $rec['schNo'] . "</td>
                    <td>". $rec['rtStarts'] . ' - '. $rec['rtEnds'] . "</td>
                    <td>" . $busNo . "</td>
                    <td>" . $rec['startTime'] . "</td>
                    <td>" . $rec['endTime'] . "</td>
                    <td>" . $rec['nightStay'] . "</td>
                    <td><button id=" . $rec['schId'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>
                    <td><button id=" . $rec['schNo'] . " class='btn btn-outline-success btn-sm no-print manage_btn'>Manage Trips</button></td>");
                    if($rec['schStatus']==1){
                        echo("
                        <td><input type='checkbox' class='form-check-input chkS' name='toggleActive' id=" . $rec['schId'] ." role='switch' checked></td>
                    </tr>     ");
                    }else{
                        echo("
                        <td><input type='checkbox' class='form-check-input chkS' name='toggleActive' id=" . $rec['schId'] ." role='switch'></td>
                    </tr>     ");
                    }
            }
    } else {
        echo ('
                <tr><td>Data not found</td></tr>
            ');
    }
    echo ('
            </tbody>
            </table>
        ');

        // ..............pagination code.......................
        $sqlViewSch = "SELECT * FROM schedules t1 INNER JOIN routes t2 ON t1.routeId = t2.rtId WHERE t2.rtStatus = 1  ORDER BY schNo DESC; ";
        $sqlQuery = $this->connResult->query($sqlViewSch);
        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        $nor = $sqlQuery->num_rows;
        $total_records = $nor;
        $total_pages = ceil($total_records / $limit);
        // last page number
        $last = $total_pages;
        // start of range for links printing
        if (($page - $links) > 0) {
            $start = $page - $links;
        } else {
            $start = 1;
        }

        if (($page + $links) < $last) {
            $end = $page + $links;
        } else {
            $end = $last;
        }

        echo ('
            <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end no-print"> 
            ');

        if ($page == 1) {
            $active_class = "disabled";
            echo ('<li class="page-item ' . $active_class . '"><span class="page-link">&laquo;</i></span></li>');
        } else {
            $active_class = "active";
            $previous = $page - 1;
            echo ('<li class="page-item ' . $active_class . ' " id="' . $previous . '"><span class="page-link">&laquo;</i></span></li>');
        }

        if ($start > 1) {
            echo ('<li class="page-item" id="1"><span class="page-link">1</span></li>
                         <li class="page-item disabled"><span class="page-link">...</span></li>');
        }
        for ($i = $start; $i <= $end; $i++) {
            if ($page == $i) {
                $active_class = "active";
            } else {
                $active_class = "";
            }
            echo ('<li class="page-item ' . $active_class . '" id="' . $i . '"><span class="page-link">' . $i . '</span></li>');
        }
        if ($end < $last) {
            echo ('<li class="page-item disabled"><span class="page-link">...</span></li>
                        <li class="page-item" id="' . $last . '"><span class="page-link">' . $last . '</span></li>
                    ');
        }

        $active_class = ($page == $last) ? "disabled" : "";
        if ($page == $last) {
            echo ('<li class="page-item ' . $active_class . '"><span class="page-link">&raquo;</i></span></li>');
        } else {
            $next = $page + 1;
            echo ('<li class="page-item ' . $active_class . ' " id="' . $next . '"><span class="page-link">&raquo;</i></span></li>');
        }

        echo ('
                </ul>
                </nav>
                <button class="btn btn-primary no-print" id="btn_back" style="position:absolute; left:10px;bottom:10px;"> Back </button>
            ');
    }

    public function searchScheduleData(){
        $limit = 3;
        $links = 2;
        $page = 0;
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
        } else {
            $page = 1;
        }

        if(isset($_POST['key'])){
            $key=$_POST['key'];
        }else{
            $key="";
        }

        $offset = ($page - 1) * $limit;


        $sqlSearch = "SELECT * FROM schedules t1 INNER JOIN routes t2 ON t1.routeId = t2.rtId WHERE  t2.rtStatus = 1  AND (t1.schNo LIKE '%$key%' OR t1.startTime LIKE '%$key%' OR t1.endTime LIKE '%$key%' OR t1.nightStay LIKE '%$key%' OR t2.rtStarts LIKE '%$key%' OR t2.rtEnds LIKE '%$key%' ) ORDER BY schNo DESC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlSearch);

        // error checking section 
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo (
        '
        <table class="table table-bordered table-responsive-lg">
        <thead>
            <tr>
                <th scope="col" id="schNo">Schedule No</th>
                <th scope="col" id="route">Route</th>
                <th scope="col">Bus No</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time </th>
                <th scope="col">Night Stay</th>
                <th scope="col" class="no-print">UPDATE</th>
                <th scope="col" class="no-print">Manage Trips</th>
                <th scope="col" class="no-print">ACT/DEACT</th>
            </tr>
        </thead>
        <tbody>
        ');

        $nor = $sqlQuery->num_rows;

        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                if($rec['busNo'] != "NULL") {
                    $busNo = $rec['busNo'];
                }else{
                    $busNo = "Not added yet.";
                }
                
                // put data into table
                echo ("
                <tr>
                <td>" . $rec['schNo'] . "</td>
                <td>". $rec['rtStarts'] . ' - '. $rec['rtEnds'] . "</td>
                <td>" . $busNo. "</td>
                <td>" . $rec['startTime'] . "</td>
                <td>" . $rec['endTime'] . "</td>
                <td>" . $rec['nightStay'] . "</td>
                <td><button id=" . $rec['schId'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>
                <td><button id=" . $rec['schNo'] . " class='btn btn-outline-success btn-sm no-print manage_btn'>Manage Trips</button></td>");
                if($rec['schStatus']==1){
                    echo("
                    <td><input type='checkbox' class='form-check-input chkS' name='toggleActive' id=" . $rec['schId'] ." role='switch' checked></td>
                </tr>     ");
                }else{
                    echo("
                    <td><input type='checkbox' class='form-check-input chkS' name='toggleActive' id=" . $rec['schId'] ." role='switch'></td>
                </tr>     ");
                }
        }
        } else {
            echo ('
                    <tr><td>Data not found</td></tr>
                ');
        }
        echo ('
                </tbody>
                </table>
            ');


        // ..............pagination code.......................
        $sqlViewBuses = "SELECT * FROM schedules t1 INNER JOIN routes t2 ON t1.routeId = t2.rtId WHERE  t2.rtStatus = 1  AND (t1.schNo LIKE '%$key%' OR t1.startTime LIKE '%$key%' OR t1.endTime LIKE '%$key%' OR t1.nightStay LIKE '%$key%' OR t2.rtStarts LIKE '%$key%' OR t2.rtEnds LIKE '%$key%' ) ORDER BY schNo DESC;";
        $sqlQuery = $this->connResult->query($sqlViewBuses);
        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        $nor = $sqlQuery->num_rows;
        $total_records = $nor;
        $total_pages = ceil($total_records / $limit);
        // last page number
        $last = $total_pages;
        // start of range for links printing
        if (($page - $links) > 0) {
            $start = $page - $links;
        } else {
            $start = 1;
        }

        if (($page + $links) < $last) {
            $end = $page + $links;
        } else {
            $end = $last;
        }

        echo ('
            <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end no-print"> 
            ');

        if ($page == 1) {
            $active_class = "disabled";
            echo ('<li class="page-items ' . $active_class . '"><span class="page-link">&laquo;</i></span></li>');
        } else {
            $active_class = "active";
            $previous = $page - 1;
            echo ('<li class="page-items ' . $active_class . ' " id="' . $previous . '"><span class="page-link">&laquo;</i></span></li>');
        }

        if ($start > 1) {
            echo ('<li class="page-items" id="1"><span class="page-link">1</span></li>
                         <li class="page-items disabled"><span class="page-link">...</span></li>');
        }
        for ($i = $start; $i <= $end; $i++) {
            if ($page == $i) {
                $active_class = "active";
            } else {
                $active_class = "";
            }
            echo ('<li class="page-items ' . $active_class . '" id="' . $i . '"><span class="page-link">' . $i . '</span></li>');
        }
        if ($end < $last) {
            echo ('<li class="page-items disabled"><span class="page-link">...</span></li>
                        <li class="page-items" id="' . $last . '"><span class="page-link">' . $last . '</span></li>
                    ');
        }

        $active_class = ($page == $last) ? "disabled" : "";
        if ($page == $last) {
            echo ('<li class="page-items ' . $active_class . '"><span class="page-link">&raquo;</i></span></li>');
        } else {
            $next = $page + 1;
            echo ('<li class="page-items ' . $active_class . ' " id="' . $next . '"><span class="page-link">&raquo;</i></span></li>');
        }

        echo ('
                </ul>
                </nav>
                <button class="btn btn-primary no-print" id="btn_back" style="position:absolute; left:10px;bottom:10px;"> Back </button>
            ');
    }

    public function fetchSchedule(){
        if(isset($_POST['schId'])){
            $schId = $_POST['schId'];
        }
        $sqlFetch = "SELECT * FROM schedules t1 INNER JOIN routes t2 ON t1.routeId = t2.rtId WHERE t1.schId = '$schId';";
        $sqlResult = $this->connResult->query($sqlFetch);
        // error checking
        if($this->connResult->errno){
            echo ($this->connResult->error);
            echo("check sql");
            exit;
        }
        $nor= $sqlResult->num_rows;
        if($nor>0){
            $rec = $sqlResult->fetch_assoc();
            echo json_encode($rec);
        }else{
            echo("no records found");
        }
    // end of fetch route data
    }

    public function scheduleUpdate($upSchId,$busUpNo,$stTimeUp,$endTimeUp, $ntStayUp){

        if($busUpNo !="none"){
            $busNo = $busUpNo;

            $sqlUpdate = "UPDATE schedules SET startTime='$stTimeUp',endTime='$endTimeUp',nightStay='$ntStayUp',busNo='$busNo',schStatus = 1 WHERE schId='$upSchId';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
            
        }else if($busUpNo == "none"){
            $busNo ="NULL";
            $sqlUpdate = "UPDATE schedules SET startTime='$stTimeUp',endTime='$endTimeUp',nightStay='$ntStayUp',busNo='$busNo',schStatus = 0 WHERE schId='$upSchId';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }
        
       
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if ($sqlQuery > 0) {
            return "Schedule Updated successfully!";
        } else {
            return "Sorry! Failed to update schedule.";
        }
    // end of update
    }

    public function actDeactSchedule($schId)
    {
        $sqlViewSh = "SELECT * FROM schedules WHERE schId='$schId' ; ";
        $sqlQuerySh = $this->connResult->query($sqlViewSh);
        $rec = $sqlQuerySh->fetch_assoc();
        // $rtStus = $rec['rtStatus'];

        if($rec['schStatus'] == 1){
            $sqlUpdate = "UPDATE schedules SET schStatus = 0 WHERE schId='$schId';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }else if($rec['schStatus'] == 0){
            $sqlUpdate = "UPDATE schedules SET schStatus = 1 WHERE schId='$schId';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }    
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if ($sqlQuery > 0) {
            return "schedule Status Changed successfully!";
        } else {
            return "Sorry! Failed to change schedule status.";
        }
    }

    public function viewRoutes()
    {
        $sqlViewBuses = "SELECT * FROM routes WHERE rtStatus = 1 ORDER BY rtId ;";
        $sqlQuery = $this->connResult->query($sqlViewBuses);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
         <option selected><i class="fa fa-map-marker" aria-hidden="true"></i>Select Route No :</option>
        ');
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                echo ("
            <option value='" . $rec['rtNo'] . "'> " . $rec['rtNo'] . "</option>
            ");
            }
        } else {
            echo ('
            <option value="">No data available.</option>
            ');
        }
    }

    public function viewBuses()
    {
        $sqlViewBuses = "SELECT busNo FROM bus t1 WHERE busStatus = 1 and busState ='onOperate' 
        and NOT EXISTS (SELECT busId FROM schedules t2 WHERE schStatus = 1 and t1.busNo=t2.busNo);";
        $sqlQuery = $this->connResult->query($sqlViewBuses);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
         <option value=""  selected>Select Bus No :</option>
         <option value="none" > None </option>
        ');
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                echo ("
            <option value='" . $rec['busNo'] . "'> " . $rec['busNo'] . "</option>
            ");
            }
        } else {
            echo ('
            <option value="">No Buses </option>
            ');
        }
    }


}

?>