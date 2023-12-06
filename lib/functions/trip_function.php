<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Trip extends Main{
    // add new trip
    public function addNewTrip($depFrom,$depAt,$arrTo,$arrAt,$schNo){
        //lets create a new trip ID 
        $trpId = new AutoNumberModule();
        $ID = $trpId->number('trpId', 'trip', 'Trp');

        $sqlSelect = "SELECT * from schedules WHERE schNo='$schNo';";
        $sch = $this->connResult->query($sqlSelect);
        $recd = $sch->fetch_assoc();
        $schId = $recd['schId'];

        $sqlSelect = "SELECT * from trip WHERE schId='$schId' AND departureAt = '$depAt' AND arriveAt='$arrAt';";
        $hl = $this->connResult->query($sqlSelect);
        $nor = $hl->num_rows;

        if ($nor == 0) {
            $sqlTrpInsert = "INSERT INTO trip VALUES ('$ID','$depFrom','$depAt','$arrTo','$arrAt',1,'$schId');";
            $sqlQuery = $this->connResult->query($sqlTrpInsert);
            // error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("Check SQL");
                exit;
            }
            if ($sqlQuery > 0) {
                return "Trip added successfully!";
            } else {
                return "Sorry! Failed to add Trip.";
            }
        }
    }

    public function viewTrips()
    {
        $limit = 3;
        $links = 2;
        $page = 0;
        $schNo = $_POST['schNo'];
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
        } else {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;

        $sqlSelect = "SELECT * from schedules WHERE schNo='$schNo';";
        $sch = $this->connResult->query($sqlSelect);
        $recd = $sch->fetch_assoc();
        $schId = $recd['schId'];

        $sqlViewTrips = "SELECT * FROM trip t1 INNER JOIN schedules t2 ON t1.schId = t2.schId  WHERE t1.trpStatus = 1 AND t2.schStatus = 1 AND t1.schId = '$schId' ORDER BY trpId DESC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlViewTrips);
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
                <th scope="col" id="trpId">Trip Id</th>
                <th scope="col" > Departure</th>
                <th scope="col" >Departure At</th>
                <th scope="col">Arrival</th>
                <th scope="col" id="sec">Arrival At</th>
                <th scope="col" class="no-print">UPDATE</th>
                <th scope="col" class="no-print">ACTIVE/DEACTIVE</th>
            </tr>
        </thead>
        <tbody>
        ');

    $nor = $sqlQuery->num_rows;

    if ($nor > 0) {
        while ($rec = $sqlQuery->fetch_assoc()) {
            // put data into table
            echo ( "
                <tr>
                    <td>" . $rec['trpId'] . "</td>
                    <td>" . $rec['departureFrom'] . "</td>
                    <td>" . $rec['departureAt'] . "</td>
                    <td>" . $rec['arriveTo'] . "</td>
                    <td>" . $rec['arriveAt'] . "</td>
                    <td><button id=" . $rec['trpId'] . " class='btn btn-outline-primary btn-sm no-print edit_Trpbtn'>Edit</button></td>");
                    if($rec['trpStatus']==1){
                        echo("
                        <td><input type='checkbox' class='form-check-input chkT' name='toggleActive' id=" . $rec['trpId'] ." role='switch' checked></td>
                    </tr>     ");
                    }else{
                        echo("
                        <td><input type='checkbox' class='form-check-input chkT' name='toggleActive' id=" . $rec['trpId'] ." role='switch'></td>
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
        $sqlViewtrp = "SELECT * FROM trip t1 INNER JOIN schedules t2 ON t1.schId = t2.schId  WHERE t1.trpStatus = 1 AND t2.schStatus = 1 AND t1.schId = '$schId' ORDER BY trpId DESC ; ";
        $sqlQuery = $this->connResult->query($sqlViewtrp);
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
        // end of viewTrips
    }

    public function searchTripData(){
        $limit = 3;
        $links = 2;
        $page = 0;
        $schNo=$_POST['schNo'];
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

        $sqlSelect = "SELECT * from schedules WHERE schNo='$schNo';";
        $sch = $this->connResult->query($sqlSelect);
        $recd = $sch->fetch_assoc();
        $schId = $recd['schId'];

        $sqlSearch = "SELECT * FROM trip t1 INNER JOIN schedules t2 ON t1.schId = t2.schId  WHERE t1.trpStatus = 1 AND t2.schStatus = 1 AND t1.schId = '$schId' AND (trpId LIKE '%$key%' OR departureFrom LIKE '%$key%' OR departureAt LIKE '%$key%' OR arriveTo LIKE '%$key%' OR arriveAt LIKE '%$key%' ) ORDER BY trpId DESC LIMIT $offset, $limit;";
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
            <th scope="col" id="trpId">Trip Id</th>
            <th scope="col" > Departure</th>
            <th scope="col" >Departure At</th>
            <th scope="col">Arrival</th>
            <th scope="col" id="sec">Arrival At</th>
            <th scope="col" class="no-print">UPDATE</th>
            <th scope="col" class="no-print">ACTIVE/DEACTIVE</th>
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
                <td>" . $rec['trpId'] . "</td>
                <td>" . $rec['departureFrom'] . "</td>
                <td>" . $rec['departureAt'] . "</td>
                <td>" . $rec['arriveTo'] . "</td>
                <td>" . $rec['arriveAt'] . "</td>
                <td><button id=" . $rec['trpId'] . " class='btn btn-outline-primary btn-sm no-print edit_Trpbtn'>Edit</button></td>");
                if($rec['trpStatus']==1){
                    echo("
                    <td><input type='checkbox' class='form-check-input chkT' name='toggleActive' id=" . $rec['trpId'] ." role='switch' checked></td>
                </tr>     ");
                }else{
                    echo("
                    <td><input type='checkbox' class='form-check-input chkT' name='toggleActive' id=" . $rec['trpId'] ." role='switch'></td>
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
        $sqlViewTrips = "SELECT * FROM trip t1 INNER JOIN schedules t2 ON t1.schId = t2.schId  WHERE t1.trpStatus = 1 AND t2.schStatus = 1 AND t1.schId = '$schId' AND (trpId LIKE '%$key%' OR departureFrom LIKE '%$key%' OR departureAt LIKE '%$key%' OR arriveTo LIKE '%$key%' OR arriveAt LIKE '%$key%' ) ORDER BY trpId DESC;";
        $sqlQuery = $this->connResult->query($sqlViewTrips);
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
    // end of searchTripData
    }

    public function fetchTrip(){
        $schNo = $_POST['schNo'];
        if(isset($_POST['trpId'])){
            $trpId = $_POST['trpId'];
        }
        $sqlSelect = "SELECT * from schedules WHERE schNo='$schNo';";
        $sch = $this->connResult->query($sqlSelect);
        $recd = $sch->fetch_assoc();
        $schId = $recd['schId'];

        $sqlFetch = "SELECT * FROM trip WHERE trpId ='$trpId' AND schId='$schId';";
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
    // end of fetch trip data
    }

    public function tripUpdate($trpUpId,$depFromUp, $depAtUp, $arrToUp, $arrAtUp,$schNo){
        $sqlSelect = "SELECT * from schedules WHERE schNo='$schNo';";
        $sch = $this->connResult->query($sqlSelect);
        $recd = $sch->fetch_assoc();
        $schId = $recd['schId'];

        $sqlUpdate = "UPDATE trip SET departureFrom='$depFromUp',departureAt ='$depAtUp', arriveTo='$arrToUp', arriveAt ='$arrAtUp' WHERE trpId='$trpUpId' AND schId='$schId';";
        $sqlQuery = $this->connResult->query($sqlUpdate);
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if ($sqlQuery > 0) {
            return "Trip Updated successfully!";
        } else {
            return "Sorry! Failed to update trip.";
        }
    // end of update
    }
    
    public function actDeactTrip($trpId, $schNo)
    {
        $sqlSelect = "SELECT * from schedules WHERE schNo='$schNo';";
        $sch = $this->connResult->query($sqlSelect);
        $recd = $sch->fetch_assoc();
        $schId = $recd['schId'];

        $sqlViewTp = "SELECT * FROM trip WHERE trpId='$trpId' ; ";
        $sqlQueryTp = $this->connResult->query($sqlViewTp);
        $rec = $sqlQueryTp->fetch_assoc();

        if($rec['trpStatus'] == 1){
            $sqlUpdate = "UPDATE trip SET trpStatus = 0 WHERE trpId ='$trpId' ;";
        $sqlQuery = $this->connResult->query($sqlUpdate);
        }else if($rec['rtStatus'] == 0){
            $sqlUpdate = "UPDATE trip SET trpStatus = 1 WHERE trpId ='$trpId' ;";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if ($sqlQuery > 0) {
            return "Trip Status Changed successfully!";
        } else {
            return "Sorry! Failed to change trip status.";
        }
    }

}
?>