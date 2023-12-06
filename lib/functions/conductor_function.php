<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Conductor extends Main
{

    public function viewReservation()
    {
        $limit = 5;
        $links = 2;
        $page = 0;
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
        } else {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;

        date_default_timezone_set('Asia/Colombo');
        $Date = date("Y-m-d");
        $month = date("F");
        $day = date("d");
        $year = date("Y");
        // Set the current time
        $currentDateTime = new DateTime();
        $currentTime = $currentDateTime->format('H:i:s');

        if (isset($_SESSION['YAMOVE_CON_ID'])) {
            $empId = $_SESSION['YAMOVE_CON_ID'];
        }

        $sqlViewSch = "SELECT JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.$day')) as schNum
                         FROM roster WHERE months='$month' AND years='$year' AND rosStatus=1
                         AND empId='$empId';";
        $sqlQuery1 = $this->connResult->query($sqlViewSch);
        $rec1 = $sqlQuery1->fetch_assoc();
        $schNo = $rec1['schNum'];

        $sqlFetch = "SELECT * FROM schedules WHERE schNo ='$schNo';";
        $sqlQuery2 = $this->connResult->query($sqlFetch);
        
        if ($sqlQuery2->num_rows > 0) {
            $rec2 = $sqlQuery2->fetch_assoc();
            $schId = $rec2['schId'];

            $sqlViewTrp = "SELECT * FROM trip WHERE schId='$schId' AND
         TIME('$currentTime') BETWEEN departureAt AND arriveAt ;";
            $sqlQuery3 = $this->connResult->query($sqlViewTrp);

            if ($sqlQuery3->num_rows > 0) {
                $rec3 = $sqlQuery3->fetch_assoc();
                $trpId = $rec3['trpId'];

                // $sqlViewReser = "SELECT * FROM reservation t1 INNER JOIN seat_plan t2 ON (t1.trpId = t2.trpId AND t1.userId = t2.userId AND t1.resDate = t2.resDate)  
                //             WHERE t1.resDate = '$Date' AND t1.trpId = '$trpId' AND t1.resStatus = 1 AND t2.planStatus = 1 ORDER BY t1.resId DESC LIMIT $offset, $limit;";
                // $sqlQuery = $this->connResult->query($sqlViewReser);

                
                $sqlViewReser = "SELECT * FROM reservation  WHERE resDate = '$Date' AND trpId = '$trpId' 
                AND resStatus = 1 ORDER BY resId DESC LIMIT $offset, $limit;";
                $sqlQuery = $this->connResult->query($sqlViewReser);


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
                <th scope="col">User Id</th>
                <th scope="col">Trip Id</th>
                <th scope="col">Ref. No.</th>
                <th scope="col">SeatNo</th>
                <th scope="col" class="no-print">CHECK</th>
            </tr>
        </thead>
        <tbody>
        ');

                $nor = $sqlQuery->num_rows;

                if ($nor > 0) {
                    while ($rec = $sqlQuery->fetch_assoc()) {

                    $seatsArr = $rec['seats'];
                    $myArray = json_decode($seatsArr);

                    foreach ($myArray as $value) {
                        echo ("
                        <tr>
                            <td>" . $rec['userId'] . "</td>
                            <td>" . $rec['trpId'] . "</td>
                            <td>" . $rec['refNo'] . "</td>
                            <td>" . $value . "</td>
                            <td><button id=" . $rec['resId'] . " class='btn btn-outline-primary btn-sm no-print conBtn'>CHECK</button></td>");
                        }    
                    }
                } else {
                    echo ('
                <tr><td> Reservations Unavailable'.$empId.'and'.$trpId.'</td></tr>
            ');
                }
                echo ('
            </tbody>
            </table>
        ');

                // ..............pagination code.......................
                $sqlViewRes = "SELECT * FROM reservation  WHERE resDate = '$Date' AND trpId = '$trpId' 
                AND resStatus = 1 ORDER BY resId DESC;";
                $sqlQuery = $this->connResult->query($sqlViewRes);
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
            } else {
                echo "No reservation found on this trip!"; 
            }
        }else{
            echo "No reservation found on your schedule!";
        }
    }


    public function searchReservation()
    {
        $limit = 5;
        $links = 2;
        $page = 0;
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
        } else {
            $page = 1;
        }

        if (isset($_POST['key'])) {
            $key = $_POST['key'];
        } else {
            $key = "";
        }

        $offset = ($page - 1) * $limit;

        date_default_timezone_set('Asia/Colombo');
        $Date = date("Y-m-d");
        $month = date("F");
        $day = date("d");
        $year = date("Y");
        // Set the current time
        $currentDateTime = new DateTime();
        $currentTime = $currentDateTime->format('H:i:s');

        if (isset($_SESSION['YAMOVE_CON_ID'])) {
            $empId = $_SESSION['YAMOVE_CON_ID'];
        }

        $sqlViewSch = "SELECT JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.$day')) as schNum
                         FROM roster WHERE months='$month' AND years='$year' AND rosStatus=1
                         AND empId='$empId';";
        $sqlQuery1 = $this->connResult->query($sqlViewSch);
        $rec1 = $sqlQuery1->fetch_assoc();
        $schNo = $rec1['schNum'];

        $sqlFetch = "SELECT * FROM schedules WHERE schNo ='$schNo';";
        $sqlQuery2 = $this->connResult->query($sqlFetch);
        $rec2 = $sqlQuery2->fetch_assoc();
        $schId = $rec2['schId'];

        $sqlViewTrp = "SELECT * FROM trip WHERE schId='$schId' AND
         TIME('$currentTime') BETWEEN departureAt AND arriveAt ;";
        $sqlQuery3 = $this->connResult->query($sqlViewTrp);
        $rec3 = $sqlQuery3->fetch_assoc();
        $trpId = $rec3['trpId'];


        $sqlSearch = "SELECT * FROM reservation WHERE resDate= '$Date' AND resStatus= 1 AND trpId = '$trpId' AND (refNo LIKE '%$key%' OR JSON_CONTAINS(seats, '\"$key\"'))  ORDER BY resId DESC LIMIT $offset, $limit;";
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
                <th scope="col">User Id</th>
                <th scope="col">Trip Id</th>
                <th scope="col">Ref. No.</th>
                <th scope="col">SeatNo</th>
                <th scope="col" class="no-print">CHECK</th>
            </tr>
        </thead>
        <tbody>
        ');

        $nor = $sqlQuery->num_rows;

        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                // put data into table
               
                    $seatsArr = $rec['seats'];
                    $myArray = json_decode($seatsArr);

                    foreach ($myArray as $value) {
                        echo ("
                        <tr>
                            <td>" . $rec['userId'] . "</td>
                            <td>" . $rec['trpId'] . "</td>
                            <td>" . $rec['refNo'] . "</td>
                            <td>" . $value . "</td>
                            <td><button id=" . $rec['resId'] . " class='btn btn-outline-primary btn-sm no-print conBtn'>CHECK</button></td>");
                        }    
                    }
                } else {
                    echo ('
                <tr><td> Reservations Unavailable</td></tr>
            ');
        }
        echo ('
                </tbody>
                </table>
            ');


        // ..............pagination code.......................
        $sqlViewBus = "SELECT * FROM reservation WHERE resDate= '$Date' AND resStatus= 1 AND trpId = '$trpId' AND (refNo LIKE '%$key%' OR JSON_CONTAINS(seats, '\"$key\"'))  ORDER BY resId DESC;";
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
    }

    public function confirmReservation($id)
    {

        $sqlStateUpdate = "UPDATE reservation SET resStatus = 0 WHERE resId='$id';";
        $sqlQuery = $this->connResult->query($sqlStateUpdate);
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if ($sqlQuery > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function viewRoster(){
      
        if (isset($_SESSION['YAMOVE_CON_ID'])) {
            $empId = $_SESSION['YAMOVE_CON_ID'];
        }

        date_default_timezone_set('Asia/Colombo');
        $month = date("F");
        $year = date("Y");

        $sqlFetch = " SELECT empId,years,months, 
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.01')) as 'day1',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.02')) as 'day2',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.03')) as 'day3',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.04')) as 'day4',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.05')) as 'day5',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.06')) as 'day6',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.07')) as 'day7',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.08')) as 'day8',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.09')) as 'day9',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.10')) as 'day10',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.11')) as 'day11',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.12')) as 'day12',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.13')) as 'day13',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.14')) as 'day14',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.15')) as 'day15',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.16')) as 'day16',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.17')) as 'day17',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.18')) as 'day18',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.19')) as 'day19',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.20')) as 'day20',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.21')) as 'day21',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.22')) as 'day22',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.23')) as 'day23',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.24')) as 'day24',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.25')) as 'day25',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.26')) as 'day26',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.27')) as 'day27',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.28')) as 'day28',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.29')) as 'day29',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.30')) as 'day30',
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.31')) as 'day31'
        FROM `roster` WHERE empId='$empId' AND years ='$year' AND months ='$month';";
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
    // end of fetch roster
    }

    // viewNotifications
    public function viewNotifications()
    {
        if (isset($_SESSION['YAMOVE_CON_ID'])) {
            $empId = $_SESSION['YAMOVE_CON_ID'];
        }

        $sqlSelect = "SELECT * from duty_change t1 INNER JOIN curr_duty t2 ON t1.dId = t2.Id
        INNER JOIN schedules t3 ON t2.schId = t3.schId
        WHERE newEmpId='$empId' AND DATE(t1.recTime) = CURDATE()
        ORDER BY aId DESC;";

        $notCount = $this->connResult->query($sqlSelect);
        $nor = $notCount->num_rows;
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
                        <th scope="col">Message</th>
                        <th scope="col" class="no-print">CHECK</th>
                    </tr>
                </thead>
                <tbody>
        ');
        if($nor>0){
            while ($rec = $notCount->fetch_assoc()) {
                if (($rec['newEmpId'] != $rec['empId']) && ($rec['newBusId'] != $rec['busId'])) {
                    $msg = "<center>Hi..! You have assign to a new duty for today.<br>
                     Your current shedule No. is " . $rec['schNo'] . " and <br>
                     Your current Bus Number is ".$rec['newBusId']."</center>";
                }else if(($rec['newEmpId']==$rec['empId']) && ($rec['newBusId']!=$rec['busId'])){
                    $msg="<center>Hi..!
                    Your current shedule No. is ".$rec['schNo']." and <br>
                    new Bus has been assigned for your journey today.<br>
                     Your Bus Number is ".$rec['newBusId']."</center>";
                }else if(($rec['newEmpId']!=$rec['empId']) && ($rec['newBusId']==$rec['busId'])){
                    $msg="<center>Hi..! You have assign to a new duty for today.<br>
                    Your current shedule No. is ".$rec['schNo']." and <br>
                     Your Bus Number is ".$rec['newBusId']."</center>";
                }
    
                echo ("
                            <tr style='background-color:F7F3F2'>
                                <td> <font face = 'Verdana' size = '3'>" . $msg . "</font></td>");
                                if($rec['dcStatus']==1){
                                    echo("<td><button id=" . $rec['aId'] . " class='btn btn-outline-primary btn-sm no-print conBtn'>ACCEPT</button></td>");
                                }else if($rec['dcStatus']==0){
                                    echo("<td><button id=" . $rec['aId'] . " class='btn btn-outline-success btn-sm no-print conBtn'>ACCEPTED</button></td>");
                                }
                     echo("</tr>
                     ");
            }
        } else {
                    echo ('
                            <tr><td> No newly assigned duties!</td></tr>
                        ');
             }
        echo ('
                </tbody>
                </table>
            ');
        }
        
    // confirmDuty
    public function confirmDuty($aId){

        $sqlStateUpdate = "UPDATE duty_change SET dcStatus = 0 WHERE aId='$aId';";
        $sqlQuery = $this->connResult->query($sqlStateUpdate);
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if($sqlQuery>0){
           echo 1;
        } else {
            echo 0;
        }
    }


    // viewTrips
    public function viewTrips()
{
    date_default_timezone_set('Asia/Colombo');
    $Date = date("Y-m-d");
    $month = date("F");
    $day = date("d");
    $year = date("Y");
    // Set the current time
    $currentDateTime = new DateTime();
    $currentTime = $currentDateTime->format('H:i:s');

    if (isset($_SESSION['YAMOVE_CON_ID'])) {
        $empId = $_SESSION['YAMOVE_CON_ID'];
    }

    // check schNo for the day
    $sqlViewSch = "SELECT JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.$day')) as schNum
    FROM roster WHERE months='$month' AND years='$year' AND empId='$empId';";
    $sqlQuery = $this->connResult->query($sqlViewSch);
    $rec = $sqlQuery->fetch_assoc();
    $schNo = $rec['schNum'];

    // if you are on a free day
    if ($schNo == "RL") {
        // check whether you are in the duty_change table today
        $sqlViewDuty = "SELECT * FROM duty_change WHERE DATE(recTime) = CURDATE()
        AND newEmpId ='$empId' ORDER BY recTime DESC LIMIT 1;";
        $sqlQuery1 = $this->connResult->query($sqlViewDuty);
        $rec1 = $sqlQuery1->fetch_assoc();

        $nor = $sqlQuery1->num_rows;
        // if yes, get schId of current duty and get trip details
        if ($nor == 1) {
            $sqlViewTrp = "SELECT * FROM trip t1 INNER JOIN schedules t4 ON 
            t1.schId=t4.schId INNER JOIN curr_duty t2 ON t1.schId = t2.schId 
            INNER JOIN duty_change t3 ON t2.Id= t3.dId
            WHERE t3.newEmpId='$empId' AND t3.dcStatus=0;";

            $sqlQuery2 = $this->connResult->query($sqlViewTrp);
            $trips = array(); // Array to store the trips

            while ($rec2 = $sqlQuery2->fetch_assoc()) {
                $trips[] = $rec2; // Store each trip record in the array
            }

            if (!empty($trips)) {
                $busId = $rec1['newBusId']; // Use the first record's busId

                echo ('
                <table class="table table-bordered table-responsive-lg">
                <thead>
                    <tr>
                        <th scope="col">Bus No.</th>
                        <th scope="col">sch No.</th>
                        <th scope="col">Departure From >> Arrive To</th>
                        <th scope="col">Departure At >> Arrive At</th>
                    </tr>
                </thead>
                <tbody>
                ');

                foreach ($trips as $trip) {
                    echo ("
                        <tr>
                            <td>" . $busId . "</td>
                            <td>" . $trip['schNo'] . "</td>
                            <td>" . $trip['departureFrom'] . " >> " . $trip['arriveTo'] . "</td>
                            <td>" . $trip['departureAt'] . " >> " . $trip['arriveAt'] . "</td>
                        </tr>
                    ");
                }

                echo ('
                </tbody>
                </table>
                ');
            } else {
                echo ("Check whether you have newly assigned duties");
            }
        } else {
            echo ("Check whether you have newly assigned duties");
        }
    } else {
        // if you are in the roster
        $sqlViewTrp = "SELECT * FROM trip t1 INNER JOIN schedules t2 ON t1.schId = t2.schId 
        INNER JOIN roster t3 ON t2.schNo= JSON_UNQUOTE(JSON_EXTRACT(t3.schedules,'$.$day'))
        WHERE t3.months='$month' AND t3.years='$year' AND t3.empId='$empId';";

        $sqlQuery2 = $this->connResult->query($sqlViewTrp);
        $trips = array(); // Array to store the trips

        while ($rec2 = $sqlQuery2->fetch_assoc()) {
            $trips[] = $rec2; // Store each trip record in the array
        }

        if (!empty($trips)) {
            // check whether data for your Id in duty_change(newBusId)
            $sqlViewBus = "SELECT * FROM duty_change WHERE DATE(recTime) = CURDATE()
            AND newEmpId ='$empId' ORDER BY recTime DESC LIMIT 1;";
            $sqlQuery3 = $this->connResult->query($sqlViewBus);
            $nor3 = $sqlQuery3->num_rows;

            if ($nor3 == 1) {
                $rec3 = $sqlQuery3->fetch_assoc();
                $busId = $rec3['newBusId'];
            } else {
                // if not, get bus id from the schedule table
                $busId = $trips[0]['busNo']; // Use the first record's busNo
            }

            echo ('
            <table class="table table-bordered table-responsive-lg">
            <thead>
                <tr>
                    <th scope="col">Bus No.</th>
                    <th scope="col">sch No.</th>
                    <th scope="col">Departure From >> Arrive To</th>
                    <th scope="col">Departure At >> Arrive At</th>
                </tr>
            </thead>
            <tbody>
            ');

            foreach ($trips as $trip) {
                echo ("
                    <tr>
                        <td>" . $busId . "</td>
                        <td>" . $trip['schNo'] . "</td>
                        <td>" . $trip['departureFrom'] . " >> " . $trip['arriveTo'] . "</td>
                        <td>" . $trip['departureAt'] . " >> " . $trip['arriveAt'] . "</td>
                    </tr>
                ");
            }

            echo ('
            </tbody>
            </table>
            ');
        } else {
            echo ('
            <table class="table table-bordered table-responsive-lg">
            <thead>
                <tr>
                    <th scope="col">Bus No.</th>
                    <th scope="col">sch No.</th>
                    <th scope="col">Departure From >> Arrive To</th>
                    <th scope="col">Departure At >> Arrive At</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> No Trips available today! Enjoy your rest day..!</td>
                </tr>
            </tbody>
            </table>
            ');
        }
    }

    // error checking section
    if ($this->connResult->errno) {
        echo ($this->connResult->error);
        echo ("check sql");
        exit;
    }
}

    //getHalts
    public function getHalts()
    {
        if (isset($_SESSION['YAMOVE_CON_ID'])) {
            $empId = $_SESSION['YAMOVE_CON_ID'];
        }

        $sqlViewSched = "SELECT t1.schId
        FROM curr_duty t1 LEFT JOIN duty_change t2 ON t1.Id = t2.dId
        WHERE (DATE(t1.recTime) = CURDATE() OR  DATE(t2.recTime) = CURDATE()) AND 
        (t1.empId ='$empId' OR t2.newEmpId ='$empId');";
        $sqlQuery = $this->connResult->query($sqlViewSched);
        $rec = $sqlQuery->fetch_assoc();
        
        $sqlViewRoute = "SELECT routeId
        FROM schedules WHERE schId='$rec[schId]';";
        $sqlQuery1 = $this->connResult->query($sqlViewRoute);
        $rec1 = $sqlQuery1->fetch_assoc();

        $sqlViewHalts = "SELECT *
        FROM halt WHERE rtId='$rec1[routeId]';";
        $sqlQuery2 = $this->connResult->query($sqlViewHalts);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }

        $nor = $sqlQuery2->num_rows;
        if ($nor > 0) {
            echo ('
            <option selected disabled >Halts :</option>
           ');
            while ($rec2 = $sqlQuery2->fetch_assoc()) {

                    echo ("
                    <option value='" . $rec2['hltId'] . "'> " .  $rec2['hltName'] . "</option>
                    ");
                }
            
        } else {
            echo ('
            <option value="">No Halts available.</option>
            ');
        }
    }


    //addLocation
    public function addLocation($halt)
    {
        if (isset($_SESSION['YAMOVE_CON_ID'])) {
            $empId = $_SESSION['YAMOVE_CON_ID'];
        }

        $sqlViewSched = "SELECT t1.schId
        FROM curr_duty t1 LEFT JOIN duty_change t2 ON t1.Id = t2.dId
        WHERE (DATE(t1.recTime) = CURDATE() OR  DATE(t2.recTime) = CURDATE()) AND 
        (t1.empId ='$empId' OR t2.newEmpId ='$empId');";
        $sqlQuery = $this->connResult->query($sqlViewSched);
        $rec = $sqlQuery->fetch_assoc();
        $schId= $rec['schId'];

        $sqlViewLoc = "SELECT * FROM curr_location
        WHERE DATE(recTime) = CURDATE() AND 
        schId='$schId';";
        $sqlQuery1 = $this->connResult->query($sqlViewLoc);
        $rec1 = $sqlQuery1->fetch_assoc();
        $nor1 = $sqlQuery1->num_rows;
        if($nor1>0){
            $prevHalt = $rec1['hltId'];
        }
        if ($nor1 > 0) {
            // get the prev halt and compare
            if($prevHalt > $halt){
                $newHalt = $prevHalt;
            }else{
                $newHalt = $halt;
            }
            $hltQuery = "UPDATE curr_location SET hltId = '$halt' 
            WHERE schId ='$schId' AND  DATE(recTime) = CURDATE();";
            $sqlQuery2 = $this->connResult->query($hltQuery);
        } else {
            $newHalt = $halt;

            $hltQuery = "INSERT INTO curr_location(schId,hltId) VALUES ('$schId','$halt') ;";
            $sqlQuery2 = $this->connResult->query($hltQuery);
        }

        // get bus
        $sqlViewBus = "SELECT t1.busId,t2.newBusId
        FROM curr_duty t1 LEFT JOIN duty_change t2 ON t1.Id = t2.dId
        WHERE (DATE(t1.recTime) = CURDATE() OR  DATE(t2.recTime) = CURDATE()) AND 
        t1.schId ='$schId';";
        $sqlQuery3 = $this->connResult->query($sqlViewBus);
        $rec3 = $sqlQuery3->fetch_assoc();
        if( $rec3['newBusId'] == NULL){
            $bus = $rec3['busId'];
        }else if($rec3['busId']== $rec3['newBusId']){
            $bus = $rec3['busId'];
        }else{
            $bus = $rec3['newBusId'];
        }

        // get halt distance
        $sqlViewHaltDis = "SELECT * FROM halt
        WHERE hltId='$newHalt';";
        $sqlQuery4 = $this->connResult->query($sqlViewHaltDis);
        $rec4 = $sqlQuery4->fetch_assoc();
        $dist = $rec4['hltDis'];

        //update bus kms
        $BusUpQuery = "UPDATE bus SET busKms = busKms + $dist 
            WHERE busNo ='$bus';";
        $sqlQuery5 = $this->connResult->query($BusUpQuery);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
    
        if ($sqlQuery2 > 0 && $sqlQuery5 > 0) {
            return 1;
        } else {
            return 0;
        }
    }


    public function getEmpId(){
       
        if (isset($_SESSION['YAMOVE_CON_ID'])) {
            $empId = $_SESSION['YAMOVE_CON_ID'];
        }

        $sqlFetch = "SELECT * FROM emp_reg WHERE emp_id ='$empId';";
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
    }



}//end of class