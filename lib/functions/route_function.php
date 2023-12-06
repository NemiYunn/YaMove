<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Routes extends Main{
    
    public function viewRoutes()
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

        $sqlViewRoutes = "SELECT * FROM routes ORDER BY rtId DESC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlViewRoutes);
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
                <th scope="col" id="rtId">Route id</th>
                <th scope="col" id="rtNo">Route No</th>
                <th scope="col">Origin</th>
                <th scope="col">Destination</th>
                <th scope="col">KMs</th>
                <th scope="col" class="no-print">EDIT</th>
                <th scope="col" class="no-print">Manage Halts</th>
                <th scope="col" class="no-print">Active/Deactive</th>           
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
                    <td>" . $rec['rtId'] . "</td>
                    <td>" . $rec['rtNo'] . "</td>
                    <td>" . $rec['rtStarts'] . "</td>
                    <td>" . $rec['rtEnds'] . "</td>
                    <td>" . $rec['rtDes'] . "</td>
                    <td><button id=" . $rec['rtId'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>
                    <td><button id=" . $rec['rtId'] . " class='btn btn-outline-success btn-sm no-print manage_btn'>Manage Halts</button></td>");
                    if($rec['rtStatus']==1){
                        echo("
                        <td><input type='checkbox' class='form-check-input chk' name='toggleActive' id=" . $rec['rtId'] ." role='switch' checked></td>
                    </tr>     ");
                    }else{
                        echo("
                        <td><input type='checkbox' class='form-check-input chk' name='toggleActive' id=" . $rec['rtId'] ." role='switch' ></td>
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
        $sqlViewRt = "SELECT * FROM routes ORDER BY rtId DESC; ";
        $sqlQuery = $this->connResult->query($sqlViewRt);
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
    // end of viewRoutes
    }

    public function addNewRoute($rtNo,$rtStarts,$rtEnds,$rtDes){
        //lets create a new route ID 
        $rtId = new AutoNumberModule();
        $ID = $rtId->number('rtId', 'routes', 'Rt');
        $rtSt = ucfirst($rtStarts);
        $rtEd = ucfirst($rtEnds);

        $sqlRouteInsert = "INSERT INTO routes VALUES ('$ID','$rtNo','$rtSt','$rtEd','$rtDes',1);";
        $sqlQuery = $this->connResult->query($sqlRouteInsert);
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
    // end of addNewRoute 
    }


    public function searchRouteData(){
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


        $sqlSearch = "SELECT  * FROM routes WHERE (rtId LIKE '%$key%' OR rtNo LIKE '%$key%' OR rtStarts LIKE '%$key%' OR rtEnds LIKE '%$key%' OR rtDes LIKE '%$key%' ) ORDER BY rtId DESC LIMIT $offset, $limit;";
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
                <th scope="col" id="rtId">Route Id</th>
                <th scope="col" id="rtNo">Route No</th>
                <th scope="col">Origin</th>
                <th scope="col">Destination</th>
                <th scope="col">KMs</th>
                <th scope="col" class="no-print">UPDATE</th>
                <th scope="col" class="no-print">Manage Halts</th>
                <th scope="col" class="no-print">Active/Deactive</th> 
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
                    <td>" . $rec['rtId'] . "</td>
                    <td>" . $rec['rtNo'] . "</td>
                    <td>" . $rec['rtStarts'] . "</td>
                    <td>" . $rec['rtEnds'] . "</td>
                    <td>" . $rec['rtDes'] . "</td>
                    <td><button id=" . $rec['rtId'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>
                    <td><button id=" . $rec['rtId'] . " class='btn btn-outline-success btn-sm no-print manage_btn'>Manage Halts</button></td>");
                    if($rec['rtStatus']==1){
                        echo("
                        <td><input type='checkbox' class='form-check-input chk' name='toggleActive' id=" . $rec['rtId'] ." role='switch' checked></td>
                    </tr>     ");
                    }else{
                        echo("
                        <td><input type='checkbox' class='form-check-input chk' name='toggleActive' id=" . $rec['rtId'] ." role='switch'></td>
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
        $sqlViewRoutes = "SELECT  * FROM routes WHERE (rtId LIKE '%$key%' OR rtNo LIKE '%$key%' OR rtStarts LIKE '%$key%' OR rtEnds LIKE '%$key%' OR rtDes LIKE '%$key%' ) ORDER BY rtId DESC;";
        $sqlQuery = $this->connResult->query($sqlViewRoutes);
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
    
    public function fetchRoute(){
        if(isset($_POST['rtId'])){
            $rtId = $_POST['rtId'];
        }

        $sqlFetch = "SELECT * FROM routes WHERE rtId='$rtId';";
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

    public function routeUpdate($rtId,$rtNo,$rtStarts,$rtEnds,$rtDes){
        $sqlUpdate = "UPDATE routes SET rtNo='$rtNo',rtStarts='$rtStarts',rtEnds='$rtEnds',rtDes='$rtDes' WHERE rtId='$rtId';";
        $sqlQuery = $this->connResult->query($sqlUpdate);
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if ($sqlQuery > 0) {
            return "Route Updated successfully!";
        } else {
            return "Sorry! Failed to update route.";
        }
    // end of update
    }

    public function actDeactRoute($rtId)
    {
        $sqlViewRt = "SELECT * FROM routes WHERE rtId='$rtId' ; ";
        $sqlQueryRt = $this->connResult->query($sqlViewRt);
        $rec = $sqlQueryRt->fetch_assoc();
        // $rtStus = $rec['rtStatus'];

        if($rec['rtStatus'] == 1){
            $sqlUpdate = "UPDATE routes SET rtStatus = 0 WHERE rtId='$rtId';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }else if($rec['rtStatus'] == 0){
            $sqlUpdate = "UPDATE routes SET rtStatus = 1 WHERE rtId='$rtId';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }
        
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if ($sqlQuery > 0) {
            return "Route Status Changed successfully!";
        } else {
            return "Sorry! Failed to change route status.";
        }
    }

// end of the class
}


?>






