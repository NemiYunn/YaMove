<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Buses extends Main{
    
    public function viewBuses()
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

        $sqlViewBuses = "SELECT * FROM bus ORDER BY busId DESC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlViewBuses);
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
                <th scope="col" id="busNo">Bus No</th>
                <th scope="col">Bus Grade</th>
                <th scope="col">Bus Category</th>
                <th scope="col">Bus State</th>
                <th scope="col" class="no-print">VIEW</th>
                <th scope="col" class="no-print">UPDATE</th>
                <th scope="col" class="no-print">CHANGE STATE</th>
                <th scope="col" class="no-print">ACT/DEACT</th>
            </tr>
        </thead>
        <tbody>
        ');

    $nor = $sqlQuery->num_rows;

    if ($nor > 0) {
        while ($rec = $sqlQuery->fetch_assoc()) {
            // put data into table
            echo ("
                <tr>
                    <td>" . $rec['busNo'] . "</td>
                    <td>" . $rec['busGrade'] . "</td>
                    <td>" . $rec['busCatag'] . "</td>
                    <td>" . $rec['busState'] . "</td>
                    <td><button id=" . $rec['busId'] . " class='btn btn-outline-info btn-sm no-print view_btn'>View</button></td>
                    <td><button id=" . $rec['busId'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>
                    <td><button id=" . $rec['busId'] . " class='btn btn-outline-success btn-sm no-print state_btn'>Change State</button></td>");
                    if($rec['busStatus']==1){
                        echo("
                        <td><input type='checkbox' class='form-check-input chkB' name='toggleActive' id=" . $rec['busId'] ." role='switch' checked></td>
                    </tr>     ");
                    }else{
                        echo("
                        <td><input type='checkbox' class='form-check-input chkB' name='toggleActive' id=" . $rec['busId'] ." role='switch'></td>
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
        $sqlViewEmp = "SELECT * FROM bus ORDER BY busId DESC; ;";
        $sqlQuery = $this->connResult->query($sqlViewEmp);
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
            ');
    // end of viewBuses
    }

    public function addNewBus($busNo,$busType,$busGrade,$busCatag,$busSeats,$kms,$busState){
        //lets create a new bus ID 
        $busId = new AutoNumberModule();
        $ID = $busId->number('busId', 'bus', 'Bus');

        $sqlBusInsert = "INSERT INTO bus VALUES ('$ID','$busNo','$busType','$busGrade','$busCatag',$busSeats,$kms,'$busState',1);";
        $sqlQuery = $this->connResult->query($sqlBusInsert);
        // error checking section
        if($this->connResult->errno){
            echo($this->connResult->error);
            echo("Check SQL");
            exit;
        }
        if($sqlQuery>0){
            return 1;
        } else {
            return 0;
        }
    // end of addNewBus 
    }

    public function searchBusData(){
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


        $sqlSearch = "SELECT  * FROM bus WHERE  (busId LIKE '%$key%' OR busNo LIKE '%$key%' OR busType LIKE '%$key%' OR busGrade LIKE '%$key%' OR busSeats LIKE '%$key%' OR busKms LIKE '%$key%' OR busState LIKE '%$key%' OR busCategory LIKE '%$key%') ORDER BY busId DESC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlSearch);

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
                    <th scope="col" id="busNo">Bus No</th>
                    <th scope="col">Bus Grade</th>
                    <th scope="col">Bus State</th>
                    <th scope="col" class="no-print" id="view">VIEW</th>
                    <th scope="col" class="no-print">UPDATE</th>
                    <th scope="col" class="no-print">CHANGE STATE</th>
                    <th scope="col" class="no-print">ACT/DEACT</th>
                </tr>
            </thead>
            <tbody>
            ');

        $nor = $sqlQuery->num_rows;

        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                // put data into table
                echo ("
                    <tr>
                        <td>" . $rec['busNo'] . "</td>
                        <td>" . $rec['busGrade'] . "</td>
                        <td>" . $rec['busState'] . "</td>
                        <td><button id=" . $rec['busId'] . " class='btn btn-outline-info btn-sm no-print view_btn'>View</button></td>
                        <td><button id=" . $rec['busId'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>
                        <td><button id=" . $rec['busId'] . " class='btn btn-outline-success btn-sm no-print state_btn'>Change State</button></td>");
                        if($rec['busStatus']==1){
                            echo("
                            <td><input type='checkbox' class='form-check-input chkB' name='toggleActive' id=" . $rec['busId'] ." role='switch' checked></td>
                        </tr>     ");
                        }else{
                            echo("
                            <td><input type='checkbox' class='form-check-input chkB' name='toggleActive' id=" . $rec['busId'] ." role='switch'></td>
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
        $sqlViewBus = "SELECT  * FROM bus WHERE (busId LIKE '%$key%' OR busNo LIKE '%$key%' OR busType LIKE '%$key%' OR busGrade LIKE '%$key%' OR busSeats LIKE '%$key%' OR busKms LIKE '%$key%' OR busState LIKE '%$key%' OR busCategory LIKE '%$key%') ORDER BY busId DESC;";
        $sqlQuery = $this->connResult->query($sqlViewBus);
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
            ');
    // end of searchBusData
    }

    
    public function fetchBus(){
        if(isset($_POST['busId'])){
            $busId = $_POST['busId'];
        }

        $sqlFetch = "SELECT * FROM bus WHERE busId='$busId';";
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
    // end of fetch bus data
    }

    public function busUpdate($busId,$busType,$busGrade,$busCategory,$busSeats,$busKms,$busState){
        $sqlUpdate = "UPDATE bus SET busType='$busType',busGrade='$busGrade',busCatag='$busCategory',busSeats='$busSeats',busKms='$busKms',busState='$busState' WHERE busId='$busId';";
        $sqlQuery = $this->connResult->query($sqlUpdate);
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if($sqlQuery>0){
            return 1;
        } else {
            return 0;
        }
    // end of update
    }

    // public function actDeact($busId){
    //     $sqlUpdate = "UPDATE bus SET busStatus = 0 WHERE busId='$busId';";
    //     $sqlQuery = $this->connResult->query($sqlUpdate);
    //     //error checking section
    //     if ($this->connResult->errno) {
    //         echo ($this->connResult->error);
    //         echo ("check SQL");
    //         exit;
    //     }
    //     if($sqlQuery>0){
    //         return 1;
    //     } else {
    //         return 0;
    //     }
    // }

    public function actDeactBus($busId)
    {
        $sqlViewBs = "SELECT * FROM bus WHERE busId='$busId' ; ";
        $sqlQueryBs = $this->connResult->query($sqlViewBs);
        $rec = $sqlQueryBs->fetch_assoc();
        // $rtStus = $rec['rtStatus'];

        if($rec['busStatus'] == 1){
            $sqlUpdate = "UPDATE bus SET busStatus = 0 WHERE busId='$busId';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }else if($rec['busStatus'] == 0){
            $sqlUpdate = "UPDATE bus SET busStatus = 1 WHERE busId='$busId';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }
        
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if($sqlQuery>0){
            return 1;
        } else {
            return 0;
        }
    }


    public function changeBusState($busId,$value){
        if($value == "operate"){
            $sqlStateUpdate = "UPDATE bus SET busState = 'onOperate' WHERE busId='$busId';";
            $sqlQuery = $this->connResult->query($sqlStateUpdate);
        }
        else if($value == "maintenance"){
            $sqlStateUpdate = "UPDATE bus SET busState ='onMaintenance'  WHERE busId='$busId';";
            $sqlQuery = $this->connResult->query($sqlStateUpdate);
        }
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if($sqlQuery>0){
            return 1;
        } else {
            return 0;
        }
    }


    public function getCurrentStatus() {
        $sqlFetchStatus = "SELECT busNo FROM bus WHERE busState = 'onOperate' AND busStatus=1;";
        $sqlResult = $this->connResult->query($sqlFetchStatus);
        
        // error checking
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        
        $nor = $sqlResult->num_rows;
        
        if ($nor > 0) {
            $rows = array(); // Initialize an empty array to store the rows
            
            // Fetch all rows and store them in the $rows array
            while ($rec = $sqlResult->fetch_assoc()) {
                $rows[] = $rec;
            }
            
            echo json_encode($rows); // Encode the array of rows as JSON
        } else {
            echo ("no records found");
        }
    }

// end of the class
}


?>






