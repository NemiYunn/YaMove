
<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Tool extends Main
{
    public function addNewTool($name, $des, $qty)
    {
        $sqlSameTools = "SELECT * FROM tool WHERE Name = '$name';";
        $sqlQuerySm = $this->connResult->query($sqlSameTools);
        $nor = $sqlQuerySm->num_rows;
        if ($nor == 1) {
            echo "This tool is already exist";
        } else if ($nor < 1) {
            //lets create a new bus ID 
            $toolId = new AutoNumberModule();
            $ID = $toolId->number('Id', 'tool', 'Tol');

            $sqlToolInsert = "INSERT INTO tool VALUES ('$ID','$name','$des','$qty',1);";
            $sqlQuery = $this->connResult->query($sqlToolInsert);
            // error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("Check SQL");
                exit;
            }
            if ($sqlQuery > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    } //end

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
                <th scope="col">ISSUE</th>
                <th scope="col">RE FILL</th>
                <th scope="col">UPDATE</th>
                <th scope="col">ACT/DEACT</th>
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
                    <td><button id=" . $rec['Id'] . " class='btn btn-outline-success btn-sm no-print issue_btn'>ISSUE</button></td>
                    <td><button id=" . $rec['Id'] . " class='btn btn-outline-info btn-sm no-print fill_btn'>RE FILL</button></td>
                    <td><button id=" . $rec['Id'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>
                    ");
                if ($rec['tlStatus'] == 1) {
                    echo ("
                        <td><input type='checkbox' class='form-check-input no-print chkT' name='toggleActive' id=" . $rec['Id'] . " role='switch' checked></td>
                    </tr>     ");
                } else {
                    echo ("
                        <td><input type='checkbox' class='form-check-input no-print chkT' name='toggleActive' id=" . $rec['Id'] . " role='switch'></td>
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
                <th scope="col">ISSUE</th>
                <th scope="col">RE FILL</th>
                <th scope="col">UPDATE</th>
                <th scope="col">ACT/DEACT</th>
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
                    <td><button id=" . $rec['Id'] . " class='btn btn-outline-success btn-sm no-print issue_btn'>ISSUE</button></td>
                    <td><button id=" . $rec['Id'] . " class='btn btn-outline-info btn-sm no-print fill_btn'>RE FILL</button></td>
                    <td><button id=" . $rec['Id'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>
                    ");
                if ($rec['tlStatus'] == 1) {
                    echo ("
                        <td><input type='checkbox' class='form-check-input no-print chkT' name='toggleActive' id=" . $rec['Id'] . " role='switch' checked></td>
                    </tr>     ");
                } else {
                    echo ("
                        <td><input type='checkbox' class='form-check-input no-print chkT' name='toggleActive' id=" . $rec['Id'] . " role='switch'></td>
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
    }//end

    
    public function fetchTool(){
        if(isset($_POST['Id'])){
            $Id = $_POST['Id'];
        }

        $sqlFetch = "SELECT * FROM tool WHERE Id='$Id';";
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


    public function toolUpdate($Id,$name,$des){
        $sqlUpdate = "UPDATE tool SET Name='$name', Des='$des' WHERE Id='$Id';";
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
    } //end


    public function actDeactTool($Id)
    {
        $sqlViewTl = "SELECT * FROM tool WHERE Id='$Id' ;";
        $sqlQuery = $this->connResult->query($sqlViewTl);
        $rec = $sqlQuery->fetch_assoc();
        $res = 0; // Initialize $res with a default value

        if ($rec['tlStatus'] == 1) {
            $sqlUpdate = "UPDATE tool SET tlStatus = 0 WHERE Id='$Id';";
            $res = $this->connResult->query($sqlUpdate);
        } else if ($rec['tlStatus'] == 0) {
            $sqlUpdate = "UPDATE tool SET tlStatus = 1 WHERE Id='$Id';";
            $res = $this->connResult->query($sqlUpdate);
        }

        // Error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }

        if ($res > 0) {
            return 1;
        } else {
            return 0;
        }
    }//end

    public function getEmp()
    {
        // change this to only get technicians and formans
        $sqlViewEmp = "SELECT login_id FROM emp_login WHERE login_status = 1 AND (login_role = 'forman' OR login_role = 'technician') ORDER BY login_id ASC;";
        $sqlQuery = $this->connResult->query($sqlViewEmp);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
         <option selected>Emp No:</option>
        ');
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                echo ("
            <option value='" . $rec['login_id'] . "'> " . $rec['login_id'] . "</option>
            ");
            }
        } else {
            echo ('
            <option value="">No Emps.</option>
            ');
        }
    } //end


    public function issueTool($tlId, $emp, $qty)
    {
        // Get remains of all batches
        $sqlViewRemains = "SELECT * FROM tool WHERE Id = '$tlId';";
        $sqlQuery = $this->connResult->query($sqlViewRemains);
        $rec = $sqlQuery->fetch_assoc();
        $remQty = $rec['Qty'];

        // Check if the requested quantity exceeds the remains
        if ($remQty >= $qty) {
            $newQty = $remQty - $qty;
            // Update the tool quantity 
            $updateSql = "UPDATE tool SET Qty = '$newQty' WHERE Id = '$tlId' ;";
            $updateQuery = $this->connResult->query($updateSql);

            // Insert the issued tool into the issue table
            $insertSql = "INSERT INTO issue_tool (tolId, empId, qty, issueTlStatus, issueTime)
                               VALUES ('$tlId', '$emp', '$qty', 1 , NOW())";
            $insertQuery = $this->connResult->query($insertSql);

            if (!$insertQuery) {
                // Handle the error if the insert fails
                echo "Failed to insert issued tools into the issue table.";
                return;
            }
        }

        if ($updateQuery > 0 && $insertQuery > 0) {
            return 1;
        } else {
            return 0;
        }
    }
 
 
    public function fillTool($rtlId,$up,$Fqty)
    {
        date_default_timezone_set('Asia/Colombo');
        $current_date = date("Y-m-d");

        $sqlFillTool = "INSERT INTO fill_tool (tlId,unit_price,qty,dateTime) VALUES ('$rtlId','$up','$Fqty','$current_date');";
        $sqlQuery = $this->connResult->query($sqlFillTool);

        $sqlViewQty = "SELECT * FROM tool WHERE Id = '$rtlId';";
        $sqlQueryQy = $this->connResult->query($sqlViewQty);
        $rec = $sqlQueryQy->fetch_assoc();
        $Qty = $rec['Qty'];

        $nwQty = $Qty + $Fqty;
        $updateSql = "UPDATE tool SET Qty = '$nwQty' WHERE Id = '$rtlId' ;";
        $updateQuery = $this->connResult->query($updateSql);

        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("Check SQL");
            exit;
        }
        if ($sqlQuery > 0 && $updateQuery > 0) {
            return 1;
        } else {
            return 0;
        }
    }//end


    public function viewToolHistory()
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

        $sqlViewTol = "SELECT t1.empId as empId, t2.Name as Name , t1.qty as qty , t1.Id as Iid FROM issue_tool  t1 INNER JOIN tool t2 ON t1.tolId = t2.Id 
        WHERE DATE(t1.issueTime) = CURDATE() AND t1.issueTlStatus=1  ORDER BY t1.Id ASC LIMIT $offset, $limit;";

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
                <th scope="col">Emp Id</th>
                <th scope="col">Tool Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">RETURN</th>
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
                    <td>" . $rec['empId'] . "</td>
                    <td>" . $rec['Name'] . "</td>
                    <td>" . $rec['qty'] . "</td>
                    <td><button id=" . $rec['Iid'] . " class='btn btn-outline-danger btn-sm no-print rtn_btn'>RETURN</button></td>
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
        $sqlViewTl = "SELECT t1.empId as empId, t2.Name as Name , t1.qty as qty , t1.Id as Iid FROM issue_tool  t1 INNER JOIN tool t2 ON t1.tolId = t2.Id 
        WHERE DATE(t1.issueTime) = CURDATE() AND t1.issueTlStatus=1 ORDER BY t1.Id ASC;";
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


    public function searchToolHistory()
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

        $sqlSearch = "SELECT t1.empId as empId, t2.Name as Name , t1.qty as qty , t1.Id as Iid FROM issue_tool  t1 INNER JOIN tool t2 ON t1.tolId = t2.Id 
        WHERE DATE(t1.issueTime) = CURDATE() AND  t1.issueTlStatus=1 AND (t2.Name LIKE '%$key%' OR t1.empId LIKE '%$key%' ) 
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
                <th scope="col">Emp Id</th>
                <th scope="col">Tool Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">RETURN</th>
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
                    <td>" . $rec['empId'] . "</td>
                    <td>" . $rec['Name'] . "</td>
                    <td>" . $rec['qty'] . "</td>
                    <td><button id=" . $rec['Iid'] . " class='btn btn-outline-danger btn-sm no-print rtn_btn'>RETURN</button></td>
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
        $sqlTl = "SELECT t1.empId as empId, t2.Name as Name , t1.qty as qty , t1.Id as Iid FROM issue_tool  t1 INNER JOIN tool t2 ON t1.tolId = t2.Id 
        WHERE DATE(t1.issueTime) = CURDATE() AND t1.issueTlStatus=1 AND (t2.Name LIKE '%$key%' OR t1.empId LIKE '%$key%' ) 
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
    }//end


    public function reurnedTool($Id)
    {
        $sqlViewTl = "SELECT * FROM issue_tool WHERE Id='$Id' ;";
        $sqlQuery = $this->connResult->query($sqlViewTl);
        $rec = $sqlQuery->fetch_assoc();
        $res = 0; // Initialize $res with a default value

        $sqlUpdate = "UPDATE issue_tool SET issueTlStatus = 0 WHERE Id='$Id';";
        $res = $this->connResult->query($sqlUpdate);

        $tool = $rec['tolId'];
        $qty = $rec['qty'];
        $sqlUpdate1 = "UPDATE tool SET Qty = Qty + $qty WHERE Id='$tool';";
        $res1 = $this->connResult->query($sqlUpdate1);

        // Error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }

        if ($res > 0 && $res1 > 0) {
            return 1;
        } else {
            return 0;
        }
    }//end


    public function viewNotifications()
{
    $sql = "SELECT t1.empId as empId, t2.Name as Name , t1.tolId as tolId FROM issue_tool  t1 INNER JOIN tool t2 ON t1.tolId = t2.Id 
    WHERE t1.issueTlStatus=1  AND t1.issueTime <= DATE_SUB(NOW(), INTERVAL 1 DAY);";

    $result = $this->connResult->query($sql);
    $count = $result->num_rows;

    $foundMatch = false; // Flag variable

    echo ('
    <table class="table table-bordered table-responsive-lg">
    <thead>
        <tr>
            <th scope="col">Emp Id</th>
            <th scope="col">Tool Id</th>
            <th scope="col">Tool Name</th>
        </tr>
    </thead>
    <tbody>
    ');

    while ($rec = $result->fetch_assoc()) {
        $foundMatch = true; // Set the flag to true
        // Put data into table
        echo ("
        <tr>
            <td>" . $rec['empId'] . "</td>
            <td>" . $rec['tolId'] . "</td>
            <td>" . $rec['Name'] . "</td>
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
}



}

?>