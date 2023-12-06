<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Reservation extends Main{
    
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

        $sqlViewReser = "SELECT * from reservation WHERE resStatus =2 ORDER BY resId DESC LIMIT $offset, $limit;";
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
                <th scope="col">Reserved Date</th>
                <th scope="col">Ref. No.</th>
                <th scope="col">No of Passengers</th>
                <th scope="col" class="no-print">CONFIRM</th>
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
                    <td>" . $rec['userId'] . "</td>
                    <td>" . $rec['trpId'] . "</td>
                    <td>" . $rec['resDate'] . "</td>
                    <td>" . $rec['refNo'] . "</td>
                    <td>" . $rec['noOfSeats'] . "</td>
                    <td><button id=" . $rec['resId'] . " class='btn btn-outline-primary btn-sm no-print conBtn'>CONFIRM</button></td>");
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
        $sqlViewRes = "SELECT * from reservation WHERE resStatus =2 ORDER BY resId DESC;";
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
    }


    public function searchReservation(){
        $limit = 5;
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


        $sqlSearch = "SELECT * from reservation WHERE resStatus =2 AND (resDate LIKE '%$key%')  ORDER BY resId DESC LIMIT $offset, $limit;";
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
                <th scope="col">Reserved Date</th>
                <th scope="col">Ref. No.</th>
                <th scope="col">No of Passengers</th>
                <th scope="col" class="no-print">CONFIRM</th>
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
                    <td>" . $rec['userId'] . "</td>
                    <td>" . $rec['trpId'] . "</td>
                    <td>" . $rec['resDate'] . "</td>
                    <td>" . $rec['refNo'] . "</td>
                    <td>" . $rec['noOfSeats'] . "</td>
                    <td><button id=" . $rec['resId'] . " class='btn btn-outline-primary btn-sm no-print conBtn'>CONFIRM</button></td>");
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
        $sqlViewBus = "SELECT * from reservation WHERE resStatus =2 AND (resDate LIKE '%$key%')  ORDER BY resId DESC;";
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

    public function confirmReservation($id){

        $sqlStateUpdate = "UPDATE reservation SET resStatus = 1 WHERE resId='$id';";
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



}//end of class