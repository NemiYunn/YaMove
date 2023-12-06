<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Duty extends Main{
    
    public function viewDuties()
    {
        $limit = 4;
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

        $sqlViewOne = "SELECT * FROM curr_duty WHERE DATE(recTime) = CURDATE()
         ORDER BY schId DESC LIMIT $offset, $limit;";
        $sqlQuery1 = $this->connResult->query($sqlViewOne);
        $nor1 = $sqlQuery1->num_rows;

        echo ('
        <table class="table table-bordered table-responsive-lg" id="dutyT">
        <thead>
            <tr>
                <th scope="col">schedule No.</th>
                <th scope="col">EmpId</th>
                <th scope="col">Role</th>
                <th scope="col">Bus No.</th>
                <th scope="col" class="no-print">CHANGE DUTY</th>
            </tr>
        </thead>
        <tbody>
        ');
        if ($nor1 > 0) {
            while ($rec1 = $sqlQuery1->fetch_assoc()) {
                $busNo = $rec1['busId'];
                $emp = $rec1['empId'];
                $schId = $rec1['schId'];
                $status = $rec1['dtStatus'];

                $sqlRole = "SELECT login_role from emp_login WHERE login_id='$emp';";
                $empRole = $this->connResult->query($sqlRole);
                $recd = $empRole->fetch_assoc();
                $role = $recd['login_role'];

                $sqlViewTwo = "SELECT schNo
                         FROM schedules WHERE schId= '$schId';";
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
                        // put data into table
                        echo ("
                <tr>
                    <td>" . $rec['schNo'] . "</td>
                    <td>" . $emp . "</td>
                    <td>" . $role . "</td>
                    <td>" . $busNo . "</td>");

                    if ($status == 1) {
                        echo ("
                        <td><button id=" . $rec1['Id'] . " class='btn btn-outline-primary btn-sm no-print change-btn'>Change Duty</button></td>");
                    } else if($status == 0) {
                        echo ("
                        <td><button id=" . $rec1['Id'] . " class='btn btn-outline-success btn-sm no-print change-btn'>Changed</button></td>");
                    }
    
                    echo ("
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
        ');
            }
        }
        echo ('   
        </table>
    ');
        // ..............pagination code.......................
        $sqlViewOne = "SELECT * FROM curr_duty WHERE DATE(recTime) = CURDATE()
        ORDER BY schId DESC;";
        $sqlQuery1 = $this->connResult->query($sqlViewOne);
        $nor1 = $sqlQuery1->num_rows;
        // if ($nor1 > 0) {
        //     while ($rec1 = $sqlQuery1->fetch_assoc()) {
        //         $busNo = $rec1['busId'];
        //         $emp = $rec1['empId'];
        //         $schId = $rec1['schId'];
        //         $status = $rec1['dtStatus'];

        //         $sqlRole = "SELECT login_role from emp_login WHERE login_id='$emp';";
        //         $empRole = $this->connResult->query($sqlRole);
        //         $recd = $empRole->fetch_assoc();
        //         $role = $recd['login_role'];

        //         $sqlViewTwo = "SELECT schNo
        //                  FROM schedules WHERE schId= '$schId';";
        //         $sqlQuery2 = $this->connResult->query($sqlViewTwo);
        // // error checking section
        // if ($this->connResult->errno) {
        //     echo ($this->connResult->error);
        //     echo ("check sql");
        //     exit;
        // }
    

        $total_records = $nor1;
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
    // }}
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

        echo (
        '
                </ul>
                </nav>
            ');
    }//end view


    public function searchDuties()
    {
        $limit = 2;
        $links = 2;
        $page = 0;
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
        } else {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;

        if(isset($_POST['key'])){
            $key=$_POST['key'];
        }else{
            $key="";
        }

        $sqlSearch = "SELECT * FROM curr_duty t1 INNER JOIN schedules t2 ON t1.schId = t2.schId 
        WHERE DATE(t1.recTime) = CURDATE() AND
        (t1.empId LIKE '%$key%' OR t1.busId LIKE '%$key%' OR t2.schNo LIKE '%$key%')
         ORDER BY t1.schId DESC LIMIT $offset, $limit;";
        $sqlQuery1 = $this->connResult->query($sqlSearch);
        $nor1 = $sqlQuery1->num_rows;

        echo ('
        <table class="table table-bordered table-responsive-lg" id="dutyT">
        <thead>
            <tr>
                <th scope="col">schedule No.</th>
                <th scope="col">EmpId</th>
                <th scope="col">Role</th>
                <th scope="col">Bus No.</th>
                <th scope="col" class="no-print">CHANGE DUTY</th>
            </tr>
        </thead>
        <tbody>
        ');
        if ($nor1 > 0) {
            while ($rec1 = $sqlQuery1->fetch_assoc()) {
                $busNo = $rec1['busId'];
                $emp = $rec1['empId'];
                $schId = $rec1['schId'];
                $status = $rec1['dtStatus'];

                $sqlRole = "SELECT login_role from emp_login WHERE login_id='$emp';";
                $empRole = $this->connResult->query($sqlRole);
                $recd = $empRole->fetch_assoc();
                $role = $recd['login_role'];

                $sqlViewTwo = "SELECT schNo
                         FROM schedules WHERE schId= '$schId';";
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
                        // put data into table
                        echo ("
                <tr>
                    <td>" . $rec['schNo'] . "</td>
                    <td>" . $emp . "</td>
                    <td>" . $role . "</td>
                    <td>" . $busNo . "</td>");

                    if ($status == 1) {
                        echo ("
                        <td><button id=" . $rec1['Id'] . " class='btn btn-outline-primary btn-sm no-print change-btn'>Change Duty</button></td>");
                    }else if($status == 0) {
                        echo ("
                        <td><button id=" . $rec1['Id'] . " class='btn btn-outline-success btn-sm no-print change-btn'>Changed</button></td>");
                    }
    
                    echo ("
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
        ');
            }
        }
        echo ('   
        </table>
    ');
        // ..............pagination code.......................
        $sqlViewOne = "SELECT * FROM curr_duty t1 INNER JOIN schedules t2 ON t1.schId = t2.schId 
        WHERE DATE(t1.recTime) = CURDATE() AND
        (t1.empId LIKE '%$key%' OR t1.busId LIKE '%$key%' OR t2.schNo LIKE '%$key%')
         ORDER BY t1.schId DESC;";
        $sqlQuery1 = $this->connResult->query($sqlViewOne);
        $nor1 = $sqlQuery1->num_rows;
        // if ($nor1 > 0) {
        //     while ($rec1 = $sqlQuery1->fetch_assoc()) {
        //         $busNo = $rec1['busId'];
        //         $emp = $rec1['empId'];
        //         $schId = $rec1['schId'];
        //         $status = $rec1['dtStatus'];

        //         $sqlRole = "SELECT login_role from emp_login WHERE login_id='$emp';";
        //         $empRole = $this->connResult->query($sqlRole);
        //         $recd = $empRole->fetch_assoc();
        //         $role = $recd['login_role'];

        //         $sqlViewTwo = "SELECT schNo
        //                  FROM schedules WHERE schId= '$schId';";
        //         $sqlQuery2 = $this->connResult->query($sqlViewTwo);
        // // error checking section
        // if ($this->connResult->errno) {
        //     echo ($this->connResult->error);
        //     echo ("check sql");
        //     exit;
        // }
    

        $total_records = $nor1;
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
    // }}
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

        echo (
        '
                </ul>
                </nav>
            ');
    }


    public function getAttendance() {
        $sqlFetch = "SELECT empId FROM attendance WHERE attStatus = 1 AND DATE(attTime) = CURDATE();";
        $sqlResult = $this->connResult->query($sqlFetch);
        
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
    

    public function fetchDuty($dId){
       
        $sqlFetch = "SELECT * FROM curr_duty WHERE Id ='$dId';";
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
    // end of fetch Duty data
    }


    public function getFreeEmps($dId)
    {
        $month = date("F");
        $day = date("d");
        $year = date("Y");

        $sqlFetch = "SELECT login_role FROM emp_login t1 INNER JOIN
         curr_duty t2 ON t1.login_id = t2.empId WHERE t2.Id = '$dId';";
        $sqlResult = $this->connResult->query($sqlFetch);
        $recd = $sqlResult->fetch_assoc();
        if($recd['login_role']=="driver"){
            $sqlViewDrivers = "SELECT t1.empId FROM roster t1 INNER JOIN attendance t2 ON t1.empId = t2.empId 
            INNER JOIN emp_login t3 ON t2.empId=t3.login_id WHERE t1.months='$month' AND t1.years='$year' AND t1.rosStatus=1 AND t2.attStatus=1 AND
            DATE(t2.attTime) = CURDATE() AND JSON_UNQUOTE(JSON_EXTRACT(t1.schedules,'$.$day'))= 'RL' AND t3.login_role='driver'
            AND t1.empId NOT IN (SELECT newEmpId FROM duty_change WHERE DATE(recTime) = CURDATE() ) ORDER BY empId DESC;";
            $sqlQuery = $this->connResult->query($sqlViewDrivers);
        }else if($recd['login_role']=="conductor"){
            $sqlViewConductors = "SELECT t1.empId FROM roster t1 INNER JOIN attendance t2 ON t1.empId = t2.empId 
            INNER JOIN emp_login t3 ON t2.empId=t3.login_id WHERE t1.months='$month' AND t1.years='$year' AND t1.rosStatus=1 AND t2.attStatus=1 AND
            DATE(t2.attTime) = CURDATE() AND JSON_UNQUOTE(JSON_EXTRACT(t1.schedules,'$.$day'))= 'RL' AND t3.login_role='conductor'
            AND t1.empId NOT IN (SELECT newEmpId FROM duty_change WHERE DATE(recTime) = CURDATE() ) ORDER BY empId DESC;";
            $sqlQuery = $this->connResult->query($sqlViewConductors);
        }

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
        <option selected> Select New Emp :</option>
       ');
       $nor = $sqlQuery->num_rows;
       if ($nor > 0) {
           while ($rec = $sqlQuery->fetch_assoc()) {
               echo ("
           <option value='" . $rec['empId'] . "'> " . $rec['empId'] . "</option>
           ");
           }
       } else {
           echo ('
           <option value="">No Free Emps</option>
           ');
       }      
    }

    //view free buses
    public function viewFreeBuses($dId)
    {
        $sqlViewBuses = "SELECT busNo FROM bus t1 WHERE busStatus = 1 and busState ='onOperate' and 
        NOT EXISTS (SELECT busId FROM schedules t2 WHERE schStatus = 1 and t1.busNo=t2.busNo) AND 
        busNo NOT IN (SELECT newBusId FROM duty_change WHERE DATE(recTime) = CURDATE() 
        AND newBusId = t1.busNo);";
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


    // saveChangedDuty
    public function saveChangedDuty($Id, $empId, $busNo)
    {
        // check if all are same to the values of curr duty
        $sqlView = "SELECT * FROM  curr_duty WHERE DATE(recTime) = CURDATE() AND empId = '$empId'
        AND busId='$busNo';";
        $sqlQuerySelect = $this->connResult->query($sqlView);

        if ($sqlQuerySelect->num_rows == 0) {
            // check for dupplicate rows in duty change
            $sqlViewDuplicates = "SELECT * FROM duty_change WHERE DATE(recTime) = CURDATE() 
            AND newEmpId = '$empId'
            AND newBusId='$busNo';";
            $sqlQueryDup = $this->connResult->query($sqlViewDuplicates);

            if ($sqlQueryDup->num_rows == 0) {

                //check old bus id = new bus d
                // get the old bus value of changed row
                $sqlViewBuses = "SELECT busId FROM curr_duty WHERE DATE(recTime) = CURDATE() 
                AND Id='$Id';";
                $sqlQueryBus = $this->connResult->query($sqlViewBuses);
                $rec = $sqlQueryBus->fetch_assoc();
                $oldBusId = $rec['busId'];

                if ($oldBusId == $busNo) {
                    //if so just insert the row and update status

                    $sqlNewDutyInsert = "INSERT INTO duty_change(newEmpId,newBusId,dcStatus,dId	) VALUES ('$empId','$busNo',1,'$Id');";
                    $sqlQuery = $this->connResult->query($sqlNewDutyInsert);

                    // roster emp duty record set to 0 (either his duty change bcs of absence
                    // or his bus changed bcs of maintenance )
                    $sqlUpdate = "UPDATE curr_duty SET dtStatus = 0 WHERE Id = '$Id';";
                    $sqlQuery1 = $this->connResult->query($sqlUpdate);

                    // error checking section
                    if ($this->connResult->errno) {
                        echo ($this->connResult->error);
                        echo ("Check SQL");
                        exit;
                    }
                    if (($sqlQuery > 0 && $sqlQuery1 > 0)) {
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    //else ->  insert and update empid with bus that affected row and
                    $sqlNewDutyInsert = "INSERT INTO duty_change(newEmpId,newBusId,dcStatus,dId	) VALUES ('$empId','$busNo',1,'$Id');";
                    $sqlQuery = $this->connResult->query($sqlNewDutyInsert);

                    $sqlUpdate = "UPDATE curr_duty SET dtStatus = 0 WHERE Id = '$Id';";
                    $sqlQuery1 = $this->connResult->query($sqlUpdate);

                    //get other row that is same as old bus id from curr
                    $sqlViewBus = "SELECT * FROM curr_duty WHERE DATE(recTime) = CURDATE() 
                        AND busId='$oldBusId' AND dtStatus=1;";
                    $sqlQueryDup2 = $this->connResult->query($sqlViewBus);

                    if ($sqlQueryDup2->num_rows > 0) {
                        $recd = $sqlQueryDup2->fetch_assoc();

                        // check if all are same values
                        $sqlView2 = "SELECT * FROM  duty_change WHERE DATE(recTime) = CURDATE() AND newEmpId ='$recd[empId]'
                                 AND newBusId='$busNo';";
                        $sqlQuerySelect2 = $this->connResult->query($sqlView2);

                        if ($sqlQuerySelect2->num_rows == 0) {
                            //insert that row to duty change with new bus and old emp id
                            $sqlNewDutyInsert2 = "INSERT INTO duty_change(newEmpId,newBusId,dcStatus,dId) VALUES ('$recd[empId]','$busNo',1,'$recd[Id]');";
                            $sqlQuery3 = $this->connResult->query($sqlNewDutyInsert2);

                            //update that row in curr
                            $sqlUpdate2 = "UPDATE curr_duty SET dtStatus = 0 WHERE Id ='$recd[Id]';";
                            $sqlQuery2 = $this->connResult->query($sqlUpdate2);

                            if ($this->connResult->errno) {
                                echo ($this->connResult->error);
                                echo ("Check SQL");
                                exit;
                            }

                            if (($sqlQuery > 0 && $sqlQuery1 > 0 && $sqlQuery3 > 0 && $sqlQuery2 > 0)) {
                                return 1;
                            } else {
                                return 0;
                            }
                        }
                    }
                }
            }
        }
    }




    public function saveChangedBusDuty($Id, $busNo){
        // check newbusId=oldBusId
        
    }


    // viewChangedDuties
    public function viewChangedDuties()
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

        $sqlViewOne = "SELECT * FROM duty_change t1 INNER JOIN curr_duty t2 
        ON t1.dId = t2.Id INNER JOIN emp_login t3 ON t2.empId= t3.login_id
        WHERE DATE(t1.recTime) = CURDATE()
        ORDER BY aId DESC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlViewOne);
        $nor = $sqlQuery->num_rows;

         // error checking section
         if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }

        echo ('
        <table class="table table-bordered table-responsive-lg" id="dutyCh">
        <thead>
            <tr>
                <th scope="col">schedule No.</th>
                <th scope="col">Role</th>
                <th scope="col">Prev EmpId >> New EmpId</th>
                <th scope="col">Prev Bus No. >> New BusNo</th>
            </tr>
        </thead>
        <tbody>
        ');
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                $oldBusNo = $rec['busId'];
                $newBusNo = $rec['newBusId'];
                $oldEmp = $rec['empId'];
                $newEmp = $rec['newEmpId'];
                $role = $rec['login_role'];
                $schId = $rec['schId'];

                $sqlSchNo = "SELECT * FROM schedules WHERE schId = '$schId';";
                $sqlQuerySch = $this->connResult->query($sqlSchNo);
                $recS = $sqlQuerySch->fetch_assoc();
                $schNo = $recS['schNo'];
                        // put data into table
                        echo ("
                <tr>
                    <td>" . $schNo . "</td>
                    <td>" . $role . "</td>");
                    if($oldEmp == $newEmp){
                        echo(" <td>" . $oldEmp . "</td>");
                    }else{
                        echo(" <td>" . $oldEmp . " >> ".$newEmp ."</td>");
                    }
                    if($oldBusNo == $newBusNo){
                        echo(" <td>" . $oldBusNo . "</td>");
                    }else{
                        echo(" <td>" . $oldBusNo . " >> " .$newBusNo. "</td>");
                    }
    
                    echo ("
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
        ');
            
        
        echo ('   
        </table>
    ');
        // ..............pagination code.......................
        $sqlViewOne = "SELECT * FROM duty_change t1 INNER JOIN curr_duty t2 
        ON t1.dId = t2.Id INNER JOIN emp_login t3 ON t2.empId= t3.login_id
        WHERE DATE(t1.recTime) = CURDATE()
        ORDER BY t1.aId DESC;";
        $sqlQuery1 = $this->connResult->query($sqlViewOne);
        $nor1 = $sqlQuery1->num_rows;

        $total_records = $nor1;
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

        echo (
        '
                </ul>
                </nav>
            ');
    }//end view
    
}
