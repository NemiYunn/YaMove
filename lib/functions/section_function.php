<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Section extends Main{
    // add new trip
    public function addNewSection($secNo,$secfare){
        //lets create a new trip ID 
        $secId = new AutoNumberModule();
        $ID = $secId->number('secId', 'secfare', 'Sec');

        $sqlSelect = "SELECT * from secfare WHERE secNo='$secNo';";
        $sec = $this->connResult->query($sqlSelect);
        $nor= $sec->num_rows;
        
        if($nor>0){
            return "Sorry! You have entered section number already!";
        }
        else{
            $sqlSecInsert = "INSERT INTO secfare VALUES ('$ID','$secNo','$secfare');";
            $sqlQuery = $this->connResult->query($sqlSecInsert);
            // error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("Check SQL");
                exit;
            }
            if ($sqlQuery > 0) {
                return "Section added successfully!";
            } else {
                return "Sorry! Failed to add Section.";
            }
        }         
    }

    public function viewSections()
    {
        $limit = 10;
        $links = 2;
        $page = 0;
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
        } else {
            $page = 1;
        }
        $offset = ($page - 1) * $limit;

        $sqlSelect = "SELECT * from secfare ORDER BY secId DESC LIMIT $offset, $limit;";
        $sec = $this->connResult->query($sqlSelect);

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
                <th scope="col">Section Id</th>
                <th scope="col" > Section No</th>
                <th scope="col" >Section Fare</th>
            </tr>
        </thead>
        <tbody>
        ');

    $nor = $sec->num_rows;

    if ($nor > 0) {
        while ($rec = $sec->fetch_assoc()) {
            // put data into table
            echo ( "
                <tr>
                    <td>" . $rec['secId'] . "</td>
                    <td>" . $rec['secNo'] . "</td>
                    <td>" . $rec['fare'] . "</td>
                </tr> ");         
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
        $sqlViewSec = "SELECT * from secfare ORDER BY secId DESC; ";
        $sqlQuery = $this->connResult->query($sqlViewSec);
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
        // end of viewSecs
    }

    public function searchSectionData(){
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


        $sqlSearch = "SELECT  * FROM secfare WHERE (secId LIKE '%$key%' OR secNo LIKE '%$key%' OR fare LIKE '%$key%' ) ORDER BY secId DESC LIMIT $offset, $limit;";
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
            <th scope="col">Section Id</th>
            <th scope="col" > Section No</th>
            <th scope="col" >Section Fare</th>
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
                <td>" . $rec['secId'] . "</td>
                <td>" . $rec['secNo'] . "</td>
                <td>" . $rec['fare'] . "</td>
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
        $sqlViewHalts = "SELECT  * FROM secfare WHERE (secId LIKE '%$key%' OR secNo LIKE '%$key%' OR fare LIKE '%$key%' ) ORDER BY secId DESC;";
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
    // end of searchSecData
    }

    public function secFareUpdate($oldMinFare, $newMinFare)
    {
        if($oldMinFare > $newMinFare){
            $dif = $oldMinFare - $newMinFare;
            $presentage = ($dif / $oldMinFare) * 100;
            $sqlUpdate = "UPDATE secfare SET fare= fare - (fare*$presentage/100);";
            $sqlQueryUp = $this->connResult->query($sqlUpdate);
        }
        else{
            $dif = -1*($oldMinFare - $newMinFare);
            $presentage = ($dif / $oldMinFare) * 100;
            $sqlUpdate = "UPDATE secfare SET fare= fare + (fare*$presentage/100);";
            $sqlQueryUp = $this->connResult->query($sqlUpdate);
        }    
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if ($sqlQueryUp > 0) {
            return "Fare Updated successfully!";
        } else {
            return "Sorry! Failed to update fare.";
        }
        // end of update
    }
}

?>