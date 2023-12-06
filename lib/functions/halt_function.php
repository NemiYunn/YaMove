<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Halts extends Main{
    // add new halt
    public function addNewHalt($hltName,$hltDis,$secNo,$rtId){
        //lets create a new halt ID 
        $hltId = new AutoNumberModule();
        $ID = $hltId->number('hltId', 'halt', 'Hlt');

        $sqlSelect = "SELECT * from halt WHERE secNo='$secNo' AND rtId = '$rtId';";
        $hl = $this->connResult->query($sqlSelect);
        $nor= $hl->num_rows;

        if($nor ==0){
            $sqlHaltInsert = "INSERT INTO halt VALUES ('$rtId', '$ID','$hltName','$hltDis','$secNo',1);";
            $sqlQuery = $this->connResult->query($sqlHaltInsert);
            // error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("Check SQL");
                exit;
            }
            if ($sqlQuery > 0) {
                return "Halt added successfully!";
            } else {
                return "Sorry! Failed to add Halt.";
            }
        }else{
            return "Sorry! Section is already available.";
        }
       
    }

    // view halt
    public function viewHalts()
    {
        $limit = 3;
        $links = 2;
        $page = 0;
        $rtId=$_POST['rtId'];
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
        } else {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;

        $sqlViewHalts = "SELECT * FROM halt t1 INNER JOIN routes t2 ON t1.rtId = t2.rtId  WHERE t2.rtStatus = 1 AND t1.rtId = '$rtId' ORDER BY secNo DESC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlViewHalts);
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
                <th scope="col" id="hltId">Halt Id</th>
                <th scope="col" id="hltName">Halt Name</th>
                <th scope="col">KMs</th>
                <th scope="col" id="sec">Sec No</th>
                <th scope="col" class="no-print">UPDATE</th>
                <th scope="col" class="no-print">Active/Deactive</th>
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
                    <td>" . $rec['hltId'] . "</td>
                    <td>" . $rec['hltName'] . "</td>
                    <td>" . $rec['hltDis'] . "</td>
                    <td>" . $rec['secNo'] . "</td>
                    <td><button id=" . $rec['hltId'] . " class='btn btn-outline-primary btn-sm no-print edit_Hltbtn'>Edit</button></td>");
                    if($rec['hltStatus']==1){
                        echo("
                        <td><input type='checkbox' class='form-check-input chkH' name='toggleActive' id=" . $rec['hltId'] ." role='switch' checked></td>
                    </tr>     ");
                    }else{
                        echo("
                        <td><input type='checkbox' class='form-check-input chkH' name='toggleActive' id=" . $rec['hltId'] ." role='switch'></td>
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
        $sqlViewHlt = "SELECT * FROM halt t1 INNER JOIN routes t2 ON t1.rtId = t2.rtId  WHERE t2.rtStatus = 1  AND t1.rtId = '$rtId' ORDER BY secNo DESC; ";
        $sqlQuery = $this->connResult->query($sqlViewHlt);
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
        // end of viewHalts
    }

    public function searchHaltData(){
        $limit = 3;
        $links = 2;
        $page = 0;
        $rtId=$_POST['rtId'];
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


        $sqlSearch = "SELECT * FROM halt t1 INNER JOIN routes t2 ON t1.rtId = t2.rtId  WHERE t2.rtStatus = 1  AND t1.rtId = '$rtId' AND (hltId LIKE '%$key%' OR hltName LIKE '%$key%' OR hltDis LIKE '%$key%' OR secNo LIKE '%$key%' ) ORDER BY secNo DESC LIMIT $offset, $limit;";
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
                <th scope="col" id="hltId">Halt Id</th>
                <th scope="col" id="hltName">Name</th>
                <th scope="col">KMs</th>
                <th scope="col" id="sec">Sec No</th>
                <th scope="col" class="no-print">UPDATE</th>
                <th scope="col" class="no-print">Active/Deactive</th>
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
                    <td>" . $rec['hltId'] . "</td>
                    <td>" . $rec['hltName'] . "</td>
                    <td>" . $rec['hltDis'] . "</td>
                    <td>" . $rec['secNo'] . "</td>
                    <td><button id=" . $rec['hltId'] . " class='btn btn-outline-primary btn-sm no-print edit_Hltbtn'>Edit</button></td>");
                    if($rec['rtStatus']==1){
                        echo("
                        <td><input type='checkbox' class='form-check-input chkH' name='toggleActive' id=" . $rec['hltId'] ." role='switch' checked></td>
                    </tr>     ");
                    }else{
                        echo("
                        <td><input type='checkbox' class='form-check-input chkH' name='toggleActive' id=" . $rec['hltId'] ." role='switch'></td>
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
        $sqlViewHalts = "SELECT * FROM halt t1 INNER JOIN routes t2 ON t1.rtId = t2.rtId  WHERE t2.rtStatus = 1  AND t1.rtId = '$rtId' AND (hltId LIKE '%$key%' OR hltName LIKE '%$key%' OR  hltDis LIKE '%$key%' OR secNo LIKE '%$key%' ) ORDER BY secNo DESC;";
        $sqlQuery = $this->connResult->query($sqlViewHalts);
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
    // end of searchHaltData
    }

    public function fetchHalt(){
        $rtId = $_POST['rtId'];
        if(isset($_POST['hltId'])){
            $hltId = $_POST['hltId'];
        }
        $sqlFetch = "SELECT * FROM halt WHERE rtId ='$rtId' AND hltId='$hltId';";
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
    // end of fetch halt data
    }

    public function haltUpdate($rtId,$hltId,$hltName,$hltDis,$secNo){
        $sqlUpdate = "UPDATE halt SET hltName='$hltName', hltDis='$hltDis', secNo ='$secNo' WHERE rtId='$rtId' AND hltId='$hltId';";
        $sqlQuery = $this->connResult->query($sqlUpdate);
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if ($sqlQuery > 0) {
            return "Halt Updated successfully!";
        } else {
            return "Sorry! Failed to update halt.";
        }
    // end of update
    }


    public function actDeactHalt($hltId)
    {
        $sqlViewHt = "SELECT * FROM halt WHERE hltId='$hltId' ; ";
        $sqlQueryHt = $this->connResult->query($sqlViewHt);
        $rec = $sqlQueryHt->fetch_assoc();
        // $rtStus = $rec['rtStatus'];

        if($rec['hltStatus'] == 1){
            $sqlUpdate = "UPDATE halt SET hltStatus = 0 WHERE hltId='$hltId';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }else if($rec['rtStatus'] == 0){
            $sqlUpdate = "UPDATE halt SET hltStatus = 1 WHERE hltId='$hltId';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }
        
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if ($sqlQuery > 0) {
            return "Halt Status Changed successfully!";
        } else {
            return "Sorry! Failed to change halt status.";
        }
    }

}
// end of class


?>










