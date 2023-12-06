<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Report extends Main
{

    public function reservationIncomeReport($stdate, $endate)
    {
        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d");
        $month = date("m");
        $monthName = date("F", strtotime($date));
        $year = date("Y");

        $sqlFetch = "SELECT t4.rtId, t4.rtStarts, t4.rtEnds, SUM(t1.totFare) AS total_amount
        FROM reservation t1
        INNER JOIN trip t2 ON t1.trpId = t2.trpId
        INNER JOIN schedules t3 ON t2.schId = t3.schId
        INNER JOIN routes t4 ON t3.routeId = t4.rtId
        WHERE resDate BETWEEN '$stdate 00:00:00' AND '$endate 23:59:59'
        GROUP BY t4.rtId;";

        $sqlQuery = $this->connResult->query($sqlFetch);

        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
        <table class="table table-sm">
        <tr><center><h5 style="font-family:verdana; color:#5c5959">Total Income <br>from ' . $stdate . ' To ' . $endate . ' </h5>
        </center></tr>
        <br>
        <thead class="thead-dark">
            <tr>
                <th scope="col">Route Id</th>
                <th scope="col">Route [From -> To] </th>
                <th scope="col">Total Income (Rs.)</th>
            </tr>
            
        </thead>
        <tbody>
        
        ');

        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                // put data into table
                echo ("
                    <tr class='mt-3'>
                        <td>" . $rec['rtId'] . "</td>
                        <td>" . $rec['rtStarts'] . ">>" .  $rec['rtEnds']  . "</td>
                        <td>" . $rec['total_amount'] . "</td>
                    </tr>

                    ");
            }
        } else {
            echo ('
                    <tr><td>No Income Found in this time period.</td></tr>
                ');
        }
        echo ('
                </tbody>
                </table>
                <br>
        Signature: ........................
            ');
    }


    public function changeDutyReport()
    {
        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d");
        $currentDateTime = strtotime(date('Y-m-d H:i:s')); 
        $targetTime = strtotime(date('Y-m-d') . ' 10:00:00');

        if ($currentDateTime > $targetTime) {
            // Current time has passed 5:00 PM
            $sqlViewOne = "SELECT * FROM duty_change t1 INNER JOIN curr_duty t2 
            ON t1.dId = t2.Id INNER JOIN emp_login t3 ON t2.empId= t3.login_id
            WHERE DATE(t1.recTime) = CURDATE()
            ORDER BY aId DESC;";
            $sqlQuery = $this->connResult->query($sqlViewOne);
            $nor = $sqlQuery->num_rows;

            // error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("check sql");
                exit;
            }

            echo ('
            <table class="table table-bordered table-responsive-lg" >
            <tr><center><h5 style="font-family:verdana; color:#5c5959"> Changed Duties on '.$date.'</h5>
            </center></tr>
            <br>
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

                    // put data into table
                    echo ("
                    <tr>
                        <td>" . $schId . "</td>
                        <td>" . $role . "</td>");
                    if ($oldEmp == $newEmp) {
                        echo (" <td>" . $oldEmp . "</td>");
                    } else {
                        echo (" <td>" . $oldEmp . " >> " . $newEmp . "</td>");
                    }
                    if ($oldBusNo == $newBusNo) {
                        echo (" <td>" . $oldBusNo . "</td>");
                    } else {
                        echo (" <td>" . $oldBusNo . " >> " . $newBusNo . "</td>");
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
            <br>
            Signaure:...........................
        ');
        } else {
            // Current time is before 5:00 PM
            echo "Please wait until 5:00 PM.";
        }    
    }

    //absentEmpReport
    public function absentEmpReport()
    {
        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d");
        $currentDateTime = strtotime(date('Y-m-d H:i:s'));
        $targetTime = strtotime(date('Y-m-d') . ' 10:00:00');

        if ($currentDateTime > $targetTime) {
            // Current time has passed 5:00 PM
            $sqlViewOne = "SELECT t1.*
            FROM emp_login t1
            LEFT JOIN attendance t2 ON t1.login_id = t2.empId AND DATE(t2.attTime) = CURDATE()
            WHERE t2.empId IS NULL AND t1.login_status = 1
            ORDER BY t1.login_role ASC;";
            $sqlQuery = $this->connResult->query($sqlViewOne);
            $nor = $sqlQuery->num_rows;

            // error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("check sql");
                exit;
            }

            echo ('
            <table class="table table-bordered table-responsive-lg">
            <tr><center><h5 style="font-family:verdana; color:#5c5959"> Absent Employees on '.$date.'</h5>
            </center></tr>
            <thead>
                <tr>
                    <th scope="col">Employee Id</th>
                    <th scope="col">Role</th>
                    <th scope="col">NIC No.</th>
                </tr>
            </thead>
            <tbody>
            ');
            if ($nor > 0) {
                while ($rec = $sqlQuery->fetch_assoc()) {

                    $sqlViewDetails = "SELECT *
                    FROM emp_login t1
                    INNER JOIN emp_reg t2 ON t1.login_id = t2.emp_id 
                    WHERE t1.login_id ='$rec[login_id]';";

                    $sqlQuery1 = $this->connResult->query($sqlViewDetails);
                    $rec2 = $sqlQuery1->fetch_assoc();

                    // put data into table
                    echo ("
                    <tr>
                        <td>" . $rec['login_id'] . "</td>
                        <td>" . $rec['login_role'] . "</td>
                        <td>" . $rec2['emp_nic'] . "</td>
                    </tr>
                ");
                }
            } else {
                echo ('
                    <tr><td>No Absent Employees today.</td></tr>
                ');
            }
            echo ('
                </tbody>          
            ');

            echo ('   
            </table>
        ');
        } else {
            // Current time is before 5:00 PM
            echo "Please wait until 5:00 PM.";
        }
    }



    // try
    // PHP function to fetch category-wise issue data from the database
    public function costOfCats($startDate, $endDate)
    {
            // Execute SQL query to retrieve category-wise issue data
            $sql = "SELECT t2.category, sum(t1.quantity) AS total_issues 
            FROM issue_item t1 INNER JOIN
            item t2 ON t1.partNo = t2.partNo 
            WHERE DATE(t1.issueTime) >= '$startDate' AND DATE(t1.issueTime) <= '$endDate'
            GROUP BY t2.category";
            $sqlQuery1 = $this->connResult->query($sql);

            // Create an array to store the data
            $data = array();

            // Loop through the query result and add data to the array
            while ($row = $sqlQuery1->fetch_assoc()) {
                $category = $row['category'];
                $totalIssues = $row['total_issues'];

                $data[] = array(
                    "category" => $category,
                    "total_issues" => $totalIssues
                );
            }

            // Return the data as-is, without encoding it again
            return $data;
    }



    public function todayTotCost()
    {

        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d");
        $currentDateTime = strtotime(date('Y-m-d H:i:s'));
        $targetTime = strtotime(date('Y-m-d') . ' 10:00:00');

        if ($currentDateTime > $targetTime) {

            $sqlQuery = "SELECT SUM(ii.issuedPrice) AS totalCost, i.category
                FROM issue_item ii
                INNER JOIN item i ON ii.partNo = i.partNo
                WHERE DATE(ii.issueTime) = CURDATE()
                GROUP BY i.category;";

            $result = $this->connResult->query($sqlQuery);
            // Error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("check sql");
                exit;
            }

            echo '
    <table class="table table-bordered">
    <tr><center><h5 style="font-family:verdana; color:#5c5959"> Cost of issues on '.$date.'</h5>
            </center></tr>
        <thead>
            <tr>
                <th>Category</th>
                <th>Total Cost (Rs.)</th>
            </tr>
        </thead>
        <tbody>';

            $totalCost = 0.00;

            while ($row = mysqli_fetch_assoc($result)) {
                $totalCostByCategory = $row['totalCost'];
                $category = $row['category'];

                echo '
        <tr style=" text-align:right">
            <td>' . $category . '</td>
            <td>' . $totalCostByCategory . '</td>
        </tr>';

                $totalCost += $totalCostByCategory;
            }

            echo '
        <tr>
            <td><strong>Total Rs. </strong></td>
            <td style="border-bottom: 3px double #000; border-top:1px solid #000; text-align:right"><strong>' . $totalCost . '.00</strong></td>
        </tr>
    </tbody>
    </table>
    <br>
    Signature: ..........................';
        } else {
            echo "Please wait until 5:00 PM.";
        }
    }


    public function todayTotCostBus()
    {

        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d");
        $currentDateTime = strtotime(date('Y-m-d H:i:s'));
        $targetTime = strtotime(date('Y-m-d') . ' 10:00:00');

        if ($currentDateTime > $targetTime) {

            $sqlQuery = "SELECT busId, SUM(issuedPrice) AS totalIssuedPrice
                 FROM issue_item
                 WHERE DATE(issueTime) = CURDATE()
                 GROUP BY busId";

            $result = $this->connResult->query($sqlQuery);
            // Error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("check sql");
                exit;
            }

            echo ('<table class="table table-bordered">
    <thead>
    <tr>
    <th>Bus ID</th>
    <th>Issued Price (Rs.)</th>
    </tr>
    </thead>
    <tbody>');

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['busId'] . '</td>';
                echo '<td>' . $row['totalIssuedPrice'] . '</td>';
                echo '</tr>';
            }

            echo ('</tbody>
    </table>');
        } else {
            echo "Please wait until 5:00 PM.";
        }
    }


    // totCostOfBuses
    public function totCostOfBuses($startDate, $endDate)
{
    $sqlQuery = "SELECT busId, SUM(issuedPrice) AS totalIssuedPrice
                 FROM issue_item
                 WHERE DATE(issueTime) >= '$startDate' AND DATE(issueTime) <= '$endDate'
                 GROUP BY busId";

    $result = $this->connResult->query($sqlQuery);
    // Error checking section
    if ($this->connResult->errno) {
        echo ($this->connResult->error);
        echo ("check sql");
        exit;
    }

    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $busId = $row['busId'];
        $issuedPrice = $row['totalIssuedPrice'];

        // Store the data in the associative array
        $data[] = array(
            'busId' => $busId,
            'issuedPrice' => $issuedPrice
        );
    }

    return $data;
}


    // lateReturns
    public function lateReturns($startDate, $endDate)
    {
        date_default_timezone_set('Asia/Colombo');
        $date = date("Y-m-d");

        $sqlQuery = "SELECT t1.empId as empId, t2.Name as Name , t1.tolId as tolId FROM issue_tool  t1 INNER JOIN tool t2 ON t1.tolId = t2.Id 
    WHERE t1.issueTlStatus=1  AND t1.issueTime <= DATE_SUB(NOW(), INTERVAL 1 DAY);";
        $result = $this->connResult->query($sqlQuery);
        $count = $result->num_rows;

        $foundMatch = false; // Flag variable

        echo ('
        <table class="table table-bordered table-responsive-lg">
        <thead>
        <tr><center><h5 style="font-family:verdana; color:#5c5959">Late retun tools to the date of <br> '.$date.'</h5>
            </center></tr>
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
            
                Signature: ..........................
                ');

        if (!$foundMatch) {
                    echo ('
            <p>No Late Returns</p>
            ');
        }
    }


    // PHP function to fetch supplier-wise unit price for item
    public function quotations($rId, $date)
    {
        $sql = "SELECT t1.unitPrice, t2.busiName as supplier
               FROM quotation t1 INNER JOIN
               sup_reg t2 ON t1.supId = t2.supId 
               WHERE t1.rId = '$rId';";
        $sqlQuery1 = $this->connResult->query($sql);

        // Create an array to store the data
        $data = array();

        // Loop through the query result and add data to the array
        while ($row = $sqlQuery1->fetch_assoc()) {
            $supplier = $row['supplier'];
            $unitPrice = $row['unitPrice'];

            $data[] = array(
                "supplier" => $supplier,
                "unitPrice" => $unitPrice
            );
        }

        // Return the data as-is, without encoding it again
        return $data;
    }
   
   


    }//end of class
