<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Tech extends Main
{

    //viewLateReturns
    public function viewLateReturns()
    {
        if (isset($_SESSION['YAMOVE_TECH_ID'])) {
            $empId = $_SESSION['YAMOVE_TECH_ID'];
        }

        $sql = "SELECT t1.empId as empId, t2.Name as Name , t1.tolId as tolId,t1.qty as qty FROM issue_tool  t1 INNER JOIN tool t2 ON t1.tolId = t2.Id 
    WHERE t1.issueTlStatus=1  AND empId='$empId' AND t1.issueTime <= DATE_SUB(NOW(), INTERVAL 1 DAY);";

        $result = $this->connResult->query($sql);
        $count = $result->num_rows;

        $foundMatch = false; // Flag variable

        echo ('
    <table class="table table-bordered table-responsive-lg">
    <thead>
        <tr>
            <th scope="col">Tool Id</th>
            <th scope="col">Tool Name</th>
            <th scope="col">Quantity</th>
        </tr>
    </thead>
    <tbody>
    ');

        while ($rec = $result->fetch_assoc()) {
            $foundMatch = true; // Set the flag to true
            // Put data into table
            echo ("
        <tr>
            <td>" . $rec['tolId'] . "</td>
            <td>" . $rec['Name'] . "</td>
            <td>" . $rec['qty'] . "</td>
        </tr>");
        }

        echo ('
    </tbody>
    </table>
    ');

        if (!$foundMatch) {
            echo ('
        <p>No Late Returns</p>
        ');
        }
    } //end

    // viewAssignedBreakdowns
    public function viewAssignedBreakdowns()
    {
        if (isset($_SESSION['YAMOVE_TECH_ID'])) {
            $empId = $_SESSION['YAMOVE_TECH_ID'];
        }

        $sql = "SELECT * FROM break_assign t1 INNER JOIN breakdown t2 ON t1.brkId = t2.brkId  WHERE t1.baStatus=3 AND t1.techId='$empId';";
        $result = $this->connResult->query($sql);

        $foundMatch = false; // Flag variable

        echo ('
        <table class="table table-bordered table-responsive-lg">
        <thead>
            <tr>
                <th scope="col">Assiged Details</th>
                <th scope="col">Issue</th>
                <th scope="col">START</th>
            </tr>
        </thead>
        <tbody>
     ');
        while ($rec = $result->fetch_assoc()
        ) {
            $foundMatch = true; // Set the flag to true
            // Put data into table
            echo ("
        <tr>
            <td> You have been assigned to work on Bus No: " . $rec['busId'] . "</td>
            <td>" . $rec['issue'] . "</td>
            <td><button id=" . $rec['Id'] . " class='btn btn-outline-primary btn-sm no-print strtBtn'>START</button></td>
        </tr>");
        }

        echo ('
    </tbody>
    </table>
    ');

        if (!$foundMatch) {
            echo ('
        <p>No Assigned Breakdowns</p>
        ');
        }
    }//end



    public function viewItems()
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

        $sqlViewItm = "SELECT * FROM item ORDER BY partNo ASC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlViewItm);
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
                <th scope="col">Category No</th>
                <th scope="col">Part No</th>
                <th scope="col">Description</th>
                <th scope="col">Remains</th>
            </tr>
        </thead>
        <tbody>
        ');

    $nor = $sqlQuery->num_rows;

    if ($nor > 0) {
        while ($rec = $sqlQuery->fetch_assoc()) {

            $sqlViewRemains = "SELECT sum(remain) as remain FROM restock
            WHERE partNo = '$rec[partNo]';";
            $sqlQueryRemains = $this->connResult->query($sqlViewRemains);
            $recR = $sqlQueryRemains->fetch_assoc();
            $remain = $recR['remain'];
            // put data into table
            echo ("
                <tr>
                    <td>" . $rec['category'] . "</td>
                    <td>" . $rec['partNo'] . "</td>
                    <td>" . $rec['descrip'] . "</td>
                    <td>" . $remain . "</td>
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
        $sqlViewItms = "SELECT * FROM item ORDER BY partNo ASC ;";
        $sqlQuery = $this->connResult->query($sqlViewItms);
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
    }//end


    public function searchItem(){
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

        $sqlSearch = "SELECT  * FROM item WHERE  (category LIKE '%$key%' OR partNo LIKE '%$key%' OR descrip LIKE '%$key%'  OR unit_issues LIKE '%$key%') 
        ORDER BY partNo ASC LIMIT $offset, $limit;";
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
                <th scope="col">Category</th>
                <th scope="col">Part No</th>
                <th scope="col">Description</th>
                <th scope="col">Remains</th>
            </tr>
        </thead>
        <tbody>
        ');

    $nor = $sqlQuery->num_rows;

    if ($nor > 0) {
        while ($rec = $sqlQuery->fetch_assoc()) {
            $sqlViewRemains = "SELECT sum(remain) as remain FROM restock
            WHERE partNo = '$rec[partNo]';";
            $sqlQueryRemains = $this->connResult->query($sqlViewRemains);
            $recR = $sqlQueryRemains->fetch_assoc();
            $remain = $recR['remain'];
            // put data into table
            echo ("
                <tr>
                    <td>" . $rec['category'] . "</td>
                    <td>" . $rec['partNo'] . "</td>
                    <td>" . $rec['descrip'] . "</td>
                    <td>" . $remain . "</td>
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
        $sqlCat = "SELECT  * FROM item WHERE  (category LIKE '%$key%' OR partNo LIKE '%$key%' OR descrip LIKE '%$key%'  OR unit_issues LIKE '%$key%') 
        ORDER BY partNo ASC;";
        $sqlQuery = $this->connResult->query($sqlCat);
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
    }//end

    public function viewTools()
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

        $sqlViewTol = "SELECT * FROM tool ORDER BY Id ASC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlViewTol);
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
                <th scope="col">Tool Name</th>
                <th scope="col">Remains</th>
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
                    <td>" . $rec['Name'] . "</td>
                    <td>" . $rec['Qty'] . "</td>
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
        $sqlViewTl = "SELECT * FROM tool ORDER BY Id ASC;";
        $sqlQuery = $this->connResult->query($sqlViewTl);
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
    } //end


    public function searchTool()
    {
        $limit = 3;
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

        $sqlSearch = "SELECT  * FROM tool WHERE  (Name LIKE '%$key%') 
        ORDER BY Name ASC LIMIT $offset, $limit;";
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
                <th scope="col">Tool Name</th>
                <th scope="col">Remains</th>
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
                    <td>" . $rec['Name'] . "</td>
                    <td>" . $rec['Qty'] . "</td>
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
        $sqlTl = "SELECT  * FROM tool WHERE  (Name LIKE '%$key%') 
        ORDER BY Name ASC;";
        $sqlQuery = $this->connResult->query($sqlTl);
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
    } //end


    //startBrkWorking
    public function startBrkWorking($Id)
    {
        date_default_timezone_set('Asia/Colombo');
        $currentDateTime = new DateTime();
        $DateTime = $currentDateTime->format('Y-m-d H:i:s');

        $sqlUpdate = "UPDATE break_assign SET startTime = '$DateTime', baStatus = 2 WHERE Id='$Id';";
        $sqlQuery = $this->connResult->query($sqlUpdate);

        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("Check SQL");
            exit;
        }

        if ($sqlQuery) {
            return 1;
        } else {
            return 0;
        }
    }

    // viewStartedBreakdowns
    public function viewStartedBreakdowns()
    {
        if (isset($_SESSION['YAMOVE_TECH_ID'])) {
            $empId = $_SESSION['YAMOVE_TECH_ID'];
        }

        $sql = "SELECT * FROM break_assign t1 INNER JOIN breakdown t2 ON t1.brkId = t2.brkId  WHERE t1.baStatus=2 AND t1.techId='$empId';";
        $result = $this->connResult->query($sql);

        $foundMatch = false; // Flag variable

        echo ('
        <table class="table table-bordered table-responsive-lg">
        <thead>
            <tr>
                <th scope="col">Started Work Details</th>
                <th scope="col">END</th>
            </tr>
        </thead>
        <tbody>
     ');
        while ($rec = $result->fetch_assoc()
        ) {
            $foundMatch = true; // Set the flag to true
            // Put data into table
            echo ("
        <tr>
            <td> You have started work on Bus No: " . $rec['busId'] . " and you have to fix the issue '"
            .$rec['issue']."'</td>
            <td><button id=" . $rec['Id'] . " class='btn btn-outline-primary btn-sm no-print endBtn'>END</button></td>
        </tr>");
        }

        echo ('
    </tbody>
    </table>
    ');

        if (!$foundMatch) {
            echo ('
        <p>No Stared Breakdowns</p>
        ');
        }
    }//end

    //endBrkWorking
    public function endBrkWorking($Id,$completionMessage)
    {
        date_default_timezone_set('Asia/Colombo');
        $currentDateTime = new DateTime();
        $DateTime = $currentDateTime->format('Y-m-d H:i:s');

        $sqlUpdate = "UPDATE break_assign SET endTime = '$DateTime', fixed='$completionMessage' , baStatus = 1 WHERE Id='$Id';";
        $sqlQuery = $this->connResult->query($sqlUpdate);

        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("Check SQL");
            exit;
        }

        if ($sqlQuery) {
            return 1;
        } else {
            return 0;
        }
    }//end

    public function viewAssignedMaintenances()
    {
        if (isset($_SESSION['YAMOVE_TECH_ID'])) {
            $empId = $_SESSION['YAMOVE_TECH_ID'];
        }

        $sql = "SELECT * FROM mnt_assign t1 INNER JOIN high_maintenance  t2 ON t1.mntId = t2.mntId  WHERE t1.maStatus=3 AND t1.techId='$empId';";
        $result = $this->connResult->query($sql);

        $foundMatch = false; // Flag variable

        echo ('
        <table class="table table-bordered table-responsive-lg">
        <thead>
            <tr>
                <th scope="col">Assiged Details</th>
                <th scope="col">START</th>
            </tr>
        </thead>
        <tbody>
     ');
        while ($rec = $result->fetch_assoc()
        ) {
            $foundMatch = true; // Set the flag to true
            // Put data into table
            echo ("
        <tr>
            <td> You have been assigned to work on Bus No: " . $rec['busId'] . "</td>
            <td><button id=" . $rec['Id'] . " class='btn btn-outline-primary btn-sm no-print strtBtn'>START</button></td>
        </tr>");
        }

        echo ('
    </tbody>
    </table>
    ');

        if (!$foundMatch) {
            echo ('
        <p>No Assigned Maintenance.</p>
        ');
        }
    }//end

    //startMtnWorking
    public function startMtnWorking($Id)
    {
        date_default_timezone_set('Asia/Colombo');
        $currentDateTime = new DateTime();
        $DateTime = $currentDateTime->format('Y-m-d H:i:s');

        $sqlUpdate = "UPDATE mnt_assign SET startTime = '$DateTime', maStatus = 2 WHERE Id='$Id';";
        $sqlQuery = $this->connResult->query($sqlUpdate);

        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("Check SQL");
            exit;
        }

        if ($sqlQuery) {
            return 1;
        } else {
            return 0;
        }
    }//end

    //viewStartedMaintenance
    public function viewStartedMaintenance()
    {
        if (isset($_SESSION['YAMOVE_TECH_ID'])) {
            $empId = $_SESSION['YAMOVE_TECH_ID'];
        }

        $sql = "SELECT * FROM mnt_assign t1 INNER JOIN high_maintenance t2 ON t1.mntId = t2.mntId  WHERE t1.maStatus=2 AND t1.techId='$empId';";
        $result = $this->connResult->query($sql);

        $foundMatch = false; // Flag variable

        echo ('
        <table class="table table-bordered table-responsive-lg">
        <thead>
            <tr>
                <th scope="col">Started Work Details</th>
                <th scope="col">END</th>
            </tr>
        </thead>
        <tbody>
     ');
        while ($rec = $result->fetch_assoc()
        ) {
            $foundMatch = true; // Set the flag to true
            // Put data into table
            echo ("
        <tr>
            <td> You have started work on Bus No: " . $rec['busId'] . "'</td>
            <td><button id=" . $rec['Id'] . " class='btn btn-outline-primary btn-sm no-print endMBtn'>END</button></td>
        </tr>");
        }

        echo ('
    </tbody>
    </table>
    ');

        if (!$foundMatch) {
            echo ('
        <p>No Stared Maintenance</p>
        ');
        }
    }//end


    public function endMntWorking($Id,$completionMessage)
    {
        date_default_timezone_set('Asia/Colombo');
        $currentDateTime = new DateTime();
        $DateTime = $currentDateTime->format('Y-m-d H:i:s');

        $sqlUpdate = "UPDATE mnt_assign SET endTime = '$DateTime', allFixed='$completionMessage' , maStatus = 1 WHERE Id='$Id';";
        $sqlQuery = $this->connResult->query($sqlUpdate);

        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("Check SQL");
            exit;
        }

        if ($sqlQuery) {
            return 1;
        } else {
            return 0;
        }
    }//end



}
?>







