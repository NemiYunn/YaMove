<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Roster extends Main{

    public function addNewRoster($empId,$years,$month,$day1,$day2,$day3,$day4,$day5,$day6,$day7,$day8,$day9,$day10,
    $day11,$day12,$day13,$day14,$day15,$day16,$day17,$day18,$day19,$day20,$day21,$day22,$day23,$day24,$day25,$day26,
    $day27,$day28,$day29,$day30,$day31){
        //lets create a new route ID 
        $rosId = new AutoNumberModule();
        $ID = $rosId->number('rosId', 'roster', 'Ros');
      
        $schedules = '{"01":"'.$day1.'","02":"'.$day2.'","03":"'.$day3.'","04":"'.$day4.'","05":"'.$day5.'","06":"'.$day6.'","07":"'.$day7.'"
            ,"08":"'.$day8.'","09":"'.$day9.'","10":"'.$day10.'","11":"'.$day11.'","12":"'.$day12.'","13":"'.$day13.'","14":"'.$day14.'"
            ,"15":"'.$day15.'","16":"'.$day16.'","17":"'.$day17.'","18":"'.$day18.'","19":"'.$day19.'","20":"'.$day20.'","21":"'.$day21.'"
            ,"22":"'.$day22.'","23":"'.$day23.'","24":"'.$day24.'","25":"'.$day25.'","26":"'.$day26.'","27":"'.$day27.'","28":"'.$day28.'"
            ,"29":"'.$day29.'","30":"'.$day30.'","31":"'.$day31.'"}';

            $sqlViewRos = "SELECT * FROM roster WHERE months='$month' AND years='$years' AND empId='$empId';";
            $sqlQuery = $this->connResult->query($sqlViewRos);
            if($sqlQuery->num_rows == 0){
                $sqlAdd = "INSERT INTO roster VALUES ('$ID','$empId','$years','$month','$schedules',1);";
                $sqlQuery = $this->connResult->query($sqlAdd);
                // error checking section
                if($this->connResult->errno){
                    echo($this->connResult->error);
                    echo("Check SQL");
                    exit;
                }
                if($sqlQuery>0){
                    return "Roster added successfully!";
                } else {
                    return "Sorry! Failed to add Roster.";
            }
            }else{
                return "Roster has already been inserted!";
            }
                                                                                                                                                                                                                                                                                    
      
    // end of addNewRoute 
    }

    public function viewRosters()
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

        $month = date("F");
        $day = date("d");
        $year = date("Y");

        $sqlViewRos = "SELECT rosId,empId,years,months,
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.$day')) as schedule FROM roster WHERE months='$month' AND years='$year' AND rosStatus=1 ORDER BY rosId DESC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlViewRos);
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
                <th scope="col" id="rosId">Roster id</th>
                <th scope="col" id="empId">Employee Id</th>
                <th scope="col" id="role">Role</th>
                <th scope="col" id="date">Date</th>
                <th scope="col" id="schedule">Schedule No</th>
                <th scope="col" class="no-print">VIEW</th>
                <th scope="col" class="no-print">DELETE</th>
            </tr>
        </thead>
        <tbody>
        ');

        $nor = $sqlQuery->num_rows;

        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {

                $sqlRole = "SELECT login_role from emp_login WHERE login_id='$rec[empId]';";
                $empRole = $this->connResult->query($sqlRole);
                $recd = $empRole->fetch_assoc();
                $role = $recd['login_role'];

                // put data into table
                echo ("
                <tr>
                    <td>" . $rec['rosId'] . "</td>
                    <td>" . $rec['empId'] . "</td>
                    <td>" . $role. "</td>
                    <td>" . $rec['years'] .'-'. $rec['months'].'-'.$day."</td>
                    <td>" . $rec['schedule'] . "</td>
                    <td><button id=" . $rec['rosId'] . " class='btn btn-outline-success btn-sm no-print view_btn'>View</button></td>
                    <td><button id=" . $rec['rosId'] . " class='btn btn-outline-danger btn-sm no-print delete_btn'>Delete</button></td>
                </tr>
            ");
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
        $sqlViewRost = "SELECT rosId,empId,years,months,
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.$day')) as schedule FROM roster WHERE months='$month' AND years='$year' AND rosStatus=1 ORDER BY rosId DESC;";
        $sqlQuery = $this->connResult->query($sqlViewRost);
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
        // // end of viewRoutes
    }

    public function searchRoster(){
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

        $month = date("F");
        $day = date("d");
        $year = date("Y");

        $sqlSearch = "SELECT rosId,empId,years,months,
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.$day')) as schedule FROM roster WHERE months='$month' AND years='$year' 
        AND rosStatus=1 AND (rosId LIKE '%$key%' OR empId LIKE '%$key%' OR schedules LIKE '%$key%' ) 
        ORDER BY rosId DESC LIMIT $offset, $limit;";

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
                <th scope="col" id="rosId">Roster id</th>
                <th scope="col" id="empId">Employee Id</th>
                <th scope="col" id="role">Role</th>
                <th scope="col" id="date">Date</th>
                <th scope="col" id="schedule">Schedule No</th>
                <th scope="col" class="no-print">VIEW</th>
                <th scope="col" class="no-print">DELETE</th>
            </tr>
        </thead>
        <tbody>
        ');
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                $sqlRole = "SELECT login_role from emp_login WHERE login_id='$rec[empId]';";
                $empRole = $this->connResult->query($sqlRole);
                $recd = $empRole->fetch_assoc();
                $role = $recd['login_role'];
                // put data into table
                echo ("
                <tr>
                    <td>" . $rec['rosId'] . "</td>
                    <td>" . $rec['empId'] . "</td>
                    <td>" . $role. "</td>
                    <td>" . $rec['years'] .'-'. $rec['months'].'-'.$day."</td>
                    <td>" . $rec['schedule'] . "</td>
                    <td><button id=" . $rec['rosId'] . " class='btn btn-outline-success btn-sm no-print view_btn'>View</button></td>
                    <td><button id=" . $rec['rosId'] . " class='btn btn-outline-danger btn-sm no-print delete_btn'>Delete</button></td>
                </tr>
            ");
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
        $sqlViewRos = "SELECT rosId,empId,years,months,
        JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.$day')) as schedule FROM roster WHERE months='$month' AND years='$year' 
        AND rosStatus=1 AND (rosId LIKE '%$key%' OR empId LIKE '%$key%' OR schedules LIKE '%$key%' ) ORDER BY rosId DESC;";

        $sqlQuery = $this->connResult->query($sqlViewRos);
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
    // end of searchRoster
    }

    public function deleteRoster($rosId)
    {
        $sqlUpdate = "UPDATE roster SET rosStatus = 0 WHERE rosId='$rosId';";
        $sqlQuery = $this->connResult->query($sqlUpdate);
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if ($sqlQuery > 0) {
            return "Roster deleted successfully!";
        } else {
            return "Sorry! Failed to delete roster.";
        }
    }

    public function fetchRosters(){
        if(isset($_POST['rosId'])){
            $rosId = $_POST['rosId'];
        }

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
        FROM `roster` WHERE rosId='$rosId';";
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

    public function filterRoster(){
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

        $month = date("F");
        $day = date("d");
        $year = date("Y");

        $sqlViewRole = "SELECT empId,login_id,login_role FROM roster t1 INNER JOIN emp_login t2 ON t1.empId = t2.login_id 
        ORDER BY empId DESC";
        $sqlQuery = $this->connResult->query($sqlViewRole);
        
        $sqlSearch = "SELECT rosId,empId,years,months,JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.$day')) as schedule,
        login_id,login_role FROM roster t1 INNER JOIN emp_login t2 ON t1.empId = t2.login_id WHERE months='$month' 
        AND years='$year' AND rosStatus=1 AND login_role = '$key' ORDER BY rosId DESC LIMIT $offset, $limit;";

        $sqlQuery2 = $this->connResult->query($sqlSearch);

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
                <th scope="col" id="rosId">Roster id</th>
                <th scope="col" id="empId">Employee Id</th>
                <th scope="col" id="role">Role</th>
                <th scope="col" id="date">Date</th>
                <th scope="col" id="schedule">Schedule No</th>
                <th scope="col" class="no-print">VIEW</th>
                <th scope="col" class="no-print">DELETE</th>
            </tr>
        </thead>
        <tbody>
        ');
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery2->fetch_assoc()) {
                echo ("
                <tr>
                    <td>" . $rec['rosId'] . "</td>
                    <td>" . $rec['empId'] . "</td>
                    <td>" . $key. "</td>
                    <td>" . $rec['years'] .'-'. $rec['months'].'-'.$day."</td>
                    <td>" . $rec['schedule'] . "</td>
                    <td><button id=" . $rec['rosId'] . " class='btn btn-outline-success btn-sm no-print view_btn'>View</button></td>
                    <td><button id=" . $rec['rosId'] . " class='btn btn-outline-danger btn-sm no-print delete_btn'>Delete</button></td>
                </tr>
            ");
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
        $sqlViewRos = "SELECT rosId,empId,years,months,JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.$day')) as schedule,
        login_id,login_role FROM roster t1 INNER JOIN emp_login t2 ON t1.empId = t2.login_id WHERE months='$month'
        AND years='$year' AND rosStatus=1 AND login_role = '$key' ORDER BY rosId DESC;";

        $sqlQuery = $this->connResult->query($sqlViewRos);
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
    // end of searchRoster
    }
   

   

}

?>