<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Stock extends Main
{
    public function addNewCategory($catNo,$catDes)
    {
            $ctNo = ucfirst($catNo);
    
            $sqlCatInsert = "INSERT INTO category VALUES ('$ctNo','$catDes',1);";
            $sqlQuery = $this->connResult->query($sqlCatInsert);
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
    }

    public function viewCategories()
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

        $sqlViewCat = "SELECT * FROM category ORDER BY catNo ASC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlViewCat);
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
                <th scope="col">Description</th>
                <th scope="col" class="no-print">UPDATE</th>
                <th scope="col" class="no-print">ACT/DEACT</th>
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
                    <td>" . $rec['catNo'] . "</td>
                    <td>" . $rec['catDes'] . "</td>
                    <td><button id=" . $rec['catNo'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>
                    ");
                    if($rec['catStatus']==1){
                        echo("
                        <td><input type='checkbox' class='form-check-input no-print chkB' name='toggleActive' id=" . $rec['catNo'] ." role='switch' checked></td>
                    </tr>     ");
                    }else{
                        echo("
                        <td><input type='checkbox' class='form-check-input no-print chkB' name='toggleActive' id=" . $rec['catNo'] ." role='switch'></td>
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
        $sqlViewEmp = "SELECT * FROM category ORDER BY catNo ASC ;";
        $sqlQuery = $this->connResult->query($sqlViewEmp);
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


    public function searchCatData(){
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

        $sqlSearch = "SELECT  * FROM category WHERE  (catNo LIKE '%$key%' OR catDes LIKE '%$key%') 
        ORDER BY catNo ASC LIMIT $offset, $limit;";
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
                <th scope="col">Category No</th>
                <th scope="col">Description</th>
                <th scope="col" class="no-print">UPDATE</th>
                <th scope="col" class="no-print">ACT/DEACT</th>
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
                    <td>" . $rec['catNo'] . "</td>
                    <td>" . $rec['catDes'] . "</td>
                    <td><button id=" . $rec['catNo'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>
                    ");
                    if($rec['catStatus']==1){
                        echo("
                        <td><input type='checkbox' class='form-check-input no-print chkB' name='toggleActive' id=" . $rec['catNo'] ." role='switch' checked></td>
                    </tr>     ");
                    }else{
                        echo("
                        <td><input type='checkbox' class='form-check-input no-print chkB' name='toggleActive' id=" . $rec['catNo'] ." role='switch'></td>
                    </tr>     ");
                    }
            }
    } else {
        echo ('
                <tr><td>Data not found</td></tr>
            ');
    }
    echo (
        '
            </tbody>
            </table>
        ');
        // ..............pagination code.......................
        $sqlCat = "SELECT  * FROM category WHERE  (catNo LIKE '%$key%' OR catDes LIKE '%$key%') 
        ORDER BY catNo ASC;";
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
    }


    public function fetchCat(){
        if(isset($_POST['catNo'])){
            $catNo = $_POST['catNo'];
        }

        $sqlFetch = "SELECT * FROM category WHERE catNo='$catNo';";
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

    
    public function catUpdate($catNo,$catDes){
        $sqlUpdate = "UPDATE category SET catDes='$catDes' WHERE catNo='$catNo';";
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
    }

    public function actDeactCat($catNo)
    {
        $sqlViewCt = "SELECT * FROM category WHERE catNo='$catNo' ; ";
        $sqlQueryBs = $this->connResult->query($sqlViewCt);
        $rec = $sqlQueryBs->fetch_assoc();

        if($rec['catStatus'] == 1){
            $sqlUpdate = "UPDATE category SET catStatus = 0 WHERE catNo='$catNo';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }else if($rec['catStatus'] == 0){
            $sqlUpdate = "UPDATE category SET catStatus = 1 WHERE catNo='$catNo';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }
        
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
    }

    public function getCategories()
    {
        $sqlViewCategories = "SELECT catNo FROM category WHERE catStatus = 1 ORDER BY catNo ASC;";
        $sqlQuery = $this->connResult->query($sqlViewCategories);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
         <option selected>Category :</option>
        ');
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                echo ("
            <option value='" . $rec['catNo'] . "'> " . $rec['catNo'] . "</option>
            ");
            }
        } else {
            echo ('
            <option value="">No Categories.</option>
            ');
        }
    }


    public function addNewItem($cats, $partNo, $des, $type, $unit, $level, $fileName, $tmpFile)
    {
        // Specify the directory where you want to save the uploaded file
        $targetDir = "../../images/item/";

        // Generate a unique name for the uploaded file
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $uniFileName = uniqid() . "." . $fileExtension;
        $targetPath = $targetDir . $uniFileName;

        if (move_uploaded_file($tmpFile, $targetPath)) {
            $sqlSameItems = "SELECT * FROM item WHERE partNo = '$partNo';";
            $sqlQuerySm = $this->connResult->query($sqlSameItems);
            $nor = $sqlQuerySm->num_rows;
            if ($nor == 1) {
                echo "Part No is already exist";
            } else if ($nor < 1) {
                $sqlItmInsert = "INSERT INTO item VALUES ('$partNo','$uniFileName','$des','$type','$unit','$level',1,'$cats');";
                $sqlQuery = $this->connResult->query($sqlItmInsert);
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
        }   
    }


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
                <th scope="col" class="no-print">ISSUE</th>
                <th scope="col" class="no-print">UPDATE</th>
                <th scope="col" class="no-print">ACT/DEACT</th>
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
                    <td><button id=" . $rec['partNo'] . " class='btn btn-outline-success btn-sm no-print issueBtn'>Issue</button></td>
                    <td><button id=" . $rec['partNo'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>
                    ");
                    if($rec['itemStatus']==1){
                        echo("
                        <td><input type='checkbox' class='form-check-input no-print chkB' name='toggleActive' id=" . $rec['partNo'] ." role='switch' checked></td>
                    </tr>     ");
                    }else{
                        echo("
                        <td><input type='checkbox' class='form-check-input no-print chkB' name='toggleActive' id=" . $rec['partNo'] ." role='switch'></td>
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
    }


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
                <th scope="col" class="no-print">ISSUE</th>
                <th scope="col" class="no-print">UPDATE</th>
                <th scope="col" class="no-print">ACT/DEACT</th>
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
                    <td><button id=" . $rec['partNo'] . " class='btn btn-outline-success btn-sm no-print issueBtn'>Issue</button></td>
                    <td><button id=" . $rec['partNo'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>
                    ");
                    if($rec['itemStatus']==1){
                        echo("
                        <td><input type='checkbox' class='form-check-input no-print chkB' name='toggleActive' id=" . $rec['partNo'] ." role='switch' checked></td>
                    </tr>     ");
                    }else{
                        echo("
                        <td><input type='checkbox' class='form-check-input no-print chkB' name='toggleActive' id=" . $rec['partNo'] ." role='switch'></td>
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
    }


    public function fetchItem(){
        if(isset($_POST['partNo'])){
            $partNo = $_POST['partNo'];
        }

        $sqlFetch = "SELECT * FROM item WHERE partNo='$partNo';";
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


    public function itemUpdate($upcats,$uppartNo,$updes,$uptype,$upunit,$uplevel){
        $sqlUpdate = "UPDATE item SET descrip='$updes',types='$uptype',unit_issues='$upunit',stock_level='$uplevel',category='$upcats' WHERE partNo='$uppartNo';";
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
    }


    public function actDeactItem($partNo)
    {
        $sqlViewItm = "SELECT * FROM item WHERE partNo='$partNo' ; ";
        $sqlQueryItm = $this->connResult->query($sqlViewItm);
        $rec = $sqlQueryItm->fetch_assoc();

        if($rec['itemStatus'] == 1){
            $sqlUpdate = "UPDATE item SET itemStatus = 0 WHERE partNo='$partNo';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }else if($rec['itemStatus'] == 0){
            $sqlUpdate = "UPDATE item SET itemStatus = 1 WHERE partNo='$partNo';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
        }
        
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
    }


    public function getParts()
    {
        $sqlViewParts = "SELECT partNo FROM item WHERE itemStatus = 1 ORDER BY partNo ASC;";
        $sqlQuery = $this->connResult->query($sqlViewParts);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
         <option selected>Part No:</option>
        ');
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                echo ("
            <option value='" . $rec['partNo'] . "'> " . $rec['partNo'] . "</option>
            ");
            }
        } else {
            echo ('
            <option value="">No Parts.</option>
            ');
        }
    }


    public function getBus()
    {
        // change this to only get technicians and formans
        $sqlViewBus = "SELECT busNo FROM bus WHERE busStatus = 1 ORDER BY busId ASC;";
        $sqlQuery = $this->connResult->query($sqlViewBus);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
         <option selected>Bus No:</option>
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
            <option value="">No Buses.</option>
            ');
        }
    }



    public function restockItem($partNo, $qty, $price)
    {

        date_default_timezone_set('Asia/Colombo');
        $current_date = date("Y-m-d");

        $sqlItmRestock = "INSERT INTO restock(partNo,rsQuantity,unitPrice,remain,recDate) VALUES ('$partNo','$qty','$price','$qty','$current_date');";
        $sqlQuery = $this->connResult->query($sqlItmRestock);
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


    // issueItem
    public function issueItem($bus, $qty, $partNo)
    {
        // Get remains of all batches
        $sqlViewRemains = "SELECT SUM(remain) AS remains FROM restock WHERE partNo = '$partNo';";
        $sqlQuery = $this->connResult->query($sqlViewRemains);
        $rec = $sqlQuery->fetch_assoc();
        $remains = $rec['remains'];

        // Check if the requested quantity exceeds the remains
        if ($remains >= $qty) {
            // select issuing level at once
            $sqlSelectLevel = "SELECT * FROM item WHERE partNo = '$partNo'";
            $sqlQuerySelectLevel = $this->connResult->query($sqlSelectLevel);
            $rowL = $sqlQuerySelectLevel->fetch_assoc();

            if($rowL['unit_issues']>= $qty){
                $sqlSelect = "SELECT * FROM restock WHERE partNo = '$partNo' AND remain > 0 ORDER BY batchNo ASC";
                $sqlQuerySelect = $this->connResult->query($sqlSelect);
    
                $issuedItems = array();
    
                // Loop through the result and issue items from available batches
                while ($row = $sqlQuerySelect->fetch_assoc()) {
                    $stockId = $row['batchNo'];
                    $availableQuantity = $row['remain'];
                    $unitPrice = $row['unitPrice'];
                   
    
                    // Calculate the quantity to issue from this batch
                    $issueQuantity = min($qty, $availableQuantity);
    
                    $issuedPrice = $unitPrice* $issueQuantity; // You need to determine the issued price
    
                    // Update the stock quantity for the current batch
                    $updateSql = "UPDATE restock SET remain = remain - $issueQuantity WHERE batchNo = $stockId";
                    $updateQuery = $this->connResult->query($updateSql);
    
                    // Record the issued items with their respective batch information
                    $issuedItems[] = array(
                        'batch_id' => $stockId,
                        'quantity' => $issueQuantity,
                        'price' => $issuedPrice
                    );
    
                    // Reduce the remaining quantity to be issued
                    $qty -= $issueQuantity;
    
                    if ($qty <= 0) {
                        break; // Exit the loop if the requested quantity has been issued
                    }
                }
    
                // Insert the issued items into the issue table
                foreach ($issuedItems as $item) {
                    $batchId = $item['batch_id'];
                    $quantity = $item['quantity'];
                    $price = $item['price'];
                    // Prepare the INSERT statement
                    $insertSql = "INSERT INTO issue_item (busId, quantity, partNo, batchNo, issuedPrice, issueTime)
                              VALUES ('$bus', $quantity, '$partNo', $batchId, $price, NOW())";
    
                    // Execute the INSERT statement
                    $insertQuery = $this->connResult->query($insertSql);
    
                    if (!$insertQuery) {
                        // Handle the error if the insert fails
                        echo "Failed to insert issued items into the issue table.";
                        return;
                    }
                }
    
                echo 1;
            }else{
                echo "Please try a lower quantity";
            }
          
        } else {
            echo "Please try a lower quantity.";
        }
    }


    // viewNotifications
    public function viewNotifications()
    {
        $sqlSelectItem = "SELECT partNo, stock_level FROM item";
        $itemQuery = $this->connResult->query($sqlSelectItem);

        $count = 0;
        $foundMatch = false; // Flag variable

        while ($item = $itemQuery->fetch_assoc()) {
            $partNo = $item['partNo'];
            $stockLevel = $item['stock_level'];

            $sqlSelectRemain = "SELECT t1.partNo, SUM(t1.remain) AS totalRemain, t2.descrip, t2.category ,
                            t2.types, t2.stock_level
                            FROM restock t1 INNER JOIN item t2 ON t1.partNo = t2.partNo 
                            WHERE t1.partNo = '$partNo'
                            GROUP BY t1.partNo
                            HAVING totalRemain <= $stockLevel";
            $remainQuery = $this->connResult->query($sqlSelectRemain);
            $nor = $remainQuery->num_rows;

            $sqlSelectRfq = "SELECT * FROM rfq
            WHERE partNo = '$partNo' AND rfqStatus = 1;";
            $rfqQuery = $this->connResult->query($sqlSelectRfq);
            $nor1 = $rfqQuery->num_rows;

            if ($nor > 0) {
                if (!$foundMatch) {
                    echo ('
                    <table class="table table-bordered table-responsive-lg">
                    <thead>
                        <tr>
                            <th scope="col">Category</th>
                            <th scope="col">Part No.</th>
                            <th scope="col">Description</th>
                            <th scope="col">Unit Type</th>
                            <th scope="col">Stock Level</th>
                            <th scope="col" class="no-print">RFQ</th>
                        </tr>
                    </thead>
                    <tbody>
                ');

                    $foundMatch = true;
                }

                while ($rec = $remainQuery->fetch_assoc()) {
                    // put data into table
                    echo ("
                    <tr>
                        <td>" . $rec['category'] . "</td>
                        <td>" . $rec['partNo'] . "</td>
                        <td>" . $rec['descrip'] . "</td>
                        <td>" . $rec['types'] . "</td>
                        <td>" . $rec['stock_level'] . "</td>");
                    if($nor1 ==1){
                        echo ("<td><button id=" . $rec['partNo'] . " class='btn btn-outline-succcess btn-sm no-print disabled rfqBtn'>SENT RFQ</button></td>
                        </tr>");
                    }else{
                        echo ("<td><button id=" . $rec['partNo'] . " class='btn btn-outline-primary btn-sm no-print rfqBtn'>RFQ</button></td>
                        </tr>");
                    }
                }
            }
        }

        if (!$foundMatch) {
            echo ('
            <table class="table table-bordered table-responsive-lg">
            <thead>
                <tr>
                    <th scope="col">Category</th>
                    <th scope="col">Part No.</th>
                    <th scope="col">Description</th>
                    <th scope="col">Unit Type</th>
                    <th scope="col" class="no-print">RFQ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4">No item has exceeded its level</td>
                </tr>
            </tbody>
            </table>
        ');
        } else {
            echo ('
            </tbody>
            </table>
        ');
        }
    }


    public function stockRemain()
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
    
        $sqlViewItm = "SELECT r.partNo, r.batchNo, r.remain
        FROM restock r
        WHERE r.remain > 0
        ORDER BY r.partNo, r.batchNo ASC
        LIMIT $offset, $limit;";
    
        $sqlQuery = $this->connResult->query($sqlViewItm);
        
        // Error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
    
        // Create an associative array to store the data
        $data = array();
    
        while ($row = mysqli_fetch_assoc($sqlQuery)) {
            $partNo = $row['partNo'];
            $batchNo = $row['batchNo'];
            $remain = $row['remain'];
    
            // Store the data in the associative array if remain > 0
            if ($remain > 0) {
                $data[$partNo][$batchNo] = $remain;
            }
        }
    
        echo ('
        <table class="table table-bordered table-responsive-lg">
        <thead>
            <tr>
            <th>Part No</th>
            <th>Batch No</th>
            <th>Remain</th>
            </tr>
        </thead>
        <tbody>
        ');
    
        $previousPartNo = null; // Variable to keep track of previous partNo
        
        foreach ($data as $partNo => $batches) {
            echo '<tr>';
            
            // Check if the current partNo is different from the previous one
            if ($partNo !== $previousPartNo) {
                echo '<td rowspan="' . count($batches) . '">' . $partNo . '</td>'; // rowspan for the first row of each partNo
                $previousPartNo = $partNo; // Update the previous partNo
            }
            
            $firstBatch = true;
            foreach ($batches as $batchNo => $remain) {
                if (!$firstBatch) {
                    echo '<tr>'; // start a new row for each batchNo after the first one
                }
                
                echo '<td>' . $batchNo . '</td>';
                echo '<td>' . $remain . '</td>';
                echo '</tr>';
                
                $firstBatch = false;
            }
        }
    
        if (empty($data)) {
            echo '<tr><td colspan="3">No remaining stock available.</td></tr>';
        }
            
        echo ('
            </tbody>
            </table>
        ');
    

        // ..............pagination code.......................
        $sqlViewItms = "SELECT r.partNo, r.batchNo, r.remain
        FROM restock r
        ORDER BY r.partNo, r.batchNo ASC ;";
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
    }


    public function rfq($partNo, $Rqty, $Ldate)
    {
        $sqlRfqInsert = "INSERT INTO rfq (partNo,rQuantity,closingDate,rfqStatus) VALUES ('$partNo','$Rqty','$Ldate',1);";
        $sqlQuery = $this->connResult->query($sqlRfqInsert);
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


    public function getRfqItems()
    {
        $sqlViewRfqs = "SELECT t1.partNo, t1.rId, t2.descrip FROM rfq  t1 INNER JOIN item t2 ON t1.partNo = t2.partNo
         WHERE t1.rfqStatus = 1 ORDER BY t1.rId ASC;";
        $sqlQuery = $this->connResult->query($sqlViewRfqs);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
         <option selected disabled>Item No :</option>
        ');
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                echo ("
            <option value='" . $rec['rId'] . "'> " . $rec['partNo'] . " - ".$rec['descrip']."</option>
            ");
            }
        } else {
            echo ('
            <option value="">No RFQs.</option>
            ');
        }
    }

    //getRfqItemNo
    public function getRfqItemNo($rId)
    {
        $sqlViewItem = "SELECT t1.partNo, t2.descrip FROM rfq  t1 INNER JOIN item t2 ON t1.partNo = t2.partNo
         WHERE t1.rId = '$rId';";
        $sqlQuery = $this->connResult->query($sqlViewItem);
        $rec = $sqlQuery->fetch_assoc();
        $nor = $sqlQuery->num_rows;

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        if ($nor > 0) {
            echo (" " . $rec['partNo'] . " : " . $rec['descrip']);

            }
        else {
            echo ('
                error
            ');
        }
    }
    



}//end of class
