<?php
session_start();

include_once('main.php');
include_once('auto_no.php');
include_once('img_upload.php');

//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmpProcess extends Main
{

    public function empRegistration($EnterYourName, $EnterYourEmail,$NIC, $EnterYourPhone, $EnterYourLicense, $gender, $fileName, $tmpName)
    {
        //lets create a new emp ID 
        $empId = new AutoNumberModule();
        $ID = $empId->number('emp_id', 'emp_reg', 'Emp');
        //lets create an object from image upload class 
        $img = new ImageUpload();
        $imgPath = $img->imageProcessing($fileName, $tmpName, $ID);

        $sqlInsert = "INSERT INTO emp_reg (emp_id, emp_name, emp_email, emp_nic, emp_phone, emp_license, emp_gender, img_path)VALUES('$ID','$EnterYourName','$EnterYourEmail','$NIC','$EnterYourPhone', '$EnterYourLicense', $gender,'$imgPath');";
        $sqlEmpLogin = "INSERT INTO emp_login VALUES('$ID','$EnterYourEmail','123','role',0);";

        $sqlQuery = $this->connResult->query($sqlInsert);
        $sqlLogin = $this->connResult->query($sqlEmpLogin);

        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }

        if ($sqlQuery > 0 && $sqlLogin > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    // end of empRegistration


    public function viewRegisteredEmps()
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

        $sqlViewEmps = "SELECT * FROM emp_reg t1 INNER JOIN emp_login t2 ON t1.emp_id = t2.login_id 
                        ORDER BY emp_id DESC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlViewEmps);
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
                    <th scope="col" id="empId">EMP ID</th>
                    <th scope="col">EMP NAME</th>
                    <th scope="col">EMP EMAIL</th>
                    <th scope="col">EMP PHONE</th> 
                    <th scope="col">EMP GENDER</th>
                    <th scope="col">EMP PROFILE</th>
                    <th scope="col" class="no-print">EDIT</th>
                    <th scope="col" class="no-print col-auto">TRASH</th>
                </tr>
            </thead>
            <tbody>
            ');
        $nor = $sqlQuery->num_rows;

        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                // convert gender into a string
                if ($rec['emp_gender'] == 1) {
                    $gender = "Male";
                } else {
                    $gender = "Female";
                }

                // put data into table
                echo ("
                    <tr>
                        <td>" . $rec['emp_id'] . "</td>
                        <td>" . $rec['emp_name'] . "</td>
                        <td>" . $rec['emp_email'] . "</td>
                        <td>" . $rec['emp_phone'] . "</td>
                        <td>" . $gender . "</td>
                        <td><img src=../" . $rec['img_path'] . " width='60px' height='50px'> </td>
                        <td><button id=" . $rec['emp_id'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>");

                if ($rec['login_status'] == 1) {
                    echo ("
                        <td><button id=" . $rec['emp_id'] . " class='btn btn-outline-danger btn-sm no-print delete-btn'>Deactivate</button></td>");
                } else {
                    echo ("
                        <td><button id=" . $rec['emp_id'] . " class='btn btn-outline-info btn-sm no-print delete-btn'>Activate</button></td>");
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
                </table>
            ');


        // ..............pagination code.......................
        $sqlViewEmp = "SELECT *  FROM emp_reg ORDER BY emp_id DESC;";
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
    // end of viewRegisteredEmps




    public function searchEmps()
    {
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


        $sqlSearch = "SELECT  * FROM emp_reg t1 INNER JOIN emp_login t2 ON t1.emp_id = t2.login_id WHERE emp_name LIKE '%$key%' OR emp_email LIKE '%$key%' OR emp_phone LIKE '%$key%' ORDER BY emp_id DESC LIMIT $offset, $limit;";
        $sqlQuery = $this->connResult->query($sqlSearch);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
            <table class="table table-bordered col-9">
            <thead>
                <tr>
                    <th scope="col">EMP ID</th>
                    <th scope="col">EMP NAME</th>
                    <th scope="col">EMP EMAIL</th>
                    <th scope="col">EMP PHONE</th> 
                    <th scope="col">EMP GENDER</th>
                    <th scope="col">EMP PROFILE</th>
                    <th scope="col" class="no-print">EDIT</th>
                    <th scope="col" class="no-print col-auto">TRASH</th>
                </tr>
            </thead>
            <tbody>
            ');
        $nor = $sqlQuery->num_rows;

        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                // convert gender into a string
                if ($rec['emp_gender'] == 1) {
                    $gender = "Male";
                } else {
                    $gender = "Female";
                }

                // put data into table
                echo ("
                <tr>
                    <td>" . $rec['emp_id'] . "</td>
                    <td>" . $rec['emp_name'] . "</td>
                    <td>" . $rec['emp_email'] . "</td>
                    <td>" . $rec['emp_phone'] . "</td>
                    <td>" . $gender . "</td>
                    <td><img src=../" . $rec['img_path'] . " width='60px' height='50px'> </td>
                    <td><button id=" . $rec['emp_id'] . " class='btn btn-outline-primary btn-sm no-print edit_btn'>Edit</button></td>");

                if ($rec['login_status'] == 1) {
                    echo ("
                    <td><button id=" . $rec['emp_id'] . " class='btn btn-outline-danger btn-sm no-print delete-btn'>Deactivate</button></td>");
                } else {
                    echo ("
                    <td><button id=" . $rec['emp_id'] . " class='btn btn-outline-info btn-sm no-print delete-btn'>Activate</button></td>");
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
                </table>
            ');

            // ..............pagination code.......................
        $sqlViewEmp = "SELECT  * FROM emp_reg WHERE emp_name LIKE '%$key%' OR emp_email LIKE '%$key%' OR emp_phone LIKE '%$key%' ORDER BY emp_id DESC;";
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
    // end of serchEmps
    

    public function fetchUser(){
        if(isset($_POST['empId'])){
            $empId = $_POST['empId'];
        }

        $sqlFetch = "SELECT t1.emp_id,t1.emp_name,t1.emp_email,t1.emp_nic,t1.emp_phone,t1.emp_license,t1.emp_gender,t1.img_path,t2.login_email,t2.login_status FROM emp_reg t1 INNER JOIN emp_login t2 ON t1.emp_id = t2.login_id WHERE t1.emp_id='$empId' AND t2.login_id='$empId';";
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
    // end of fetchUser


    public function empUpdate($Id, $Name, $Email, $Phone, $gender, $fileName, $tmpName)
    {
        // if image file is selected
        if ($_FILES['editProfilePic']['size'] != 0) {
            //lets create an object from image upload class 
            $img = new ImageUpload();
            $imgPath = $img->imageProcessing($fileName, $tmpName, $Id);

            $sqlUpdate = "UPDATE emp_reg,emp_login SET emp_reg.emp_name='$Name',emp_reg.emp_email='$Email',emp_reg.emp_phone='$Phone',emp_reg.emp_gender=$gender,emp_reg.img_path='$imgPath',emp_login.login_email='$Email' WHERE emp_reg.emp_id=emp_login.login_id AND emp_reg.emp_id='$Id';";
            $sqlQuery = $this->connResult->query($sqlUpdate);
            //error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("check SQL");
                exit;
            }

            if ($sqlQuery > 0) {
                return "Employee Updated successfully!";
            } else {
                return "Sorry! Failed to update Employee.";
            }
        } else {
            // if there is no image file selected
            $sqlUpdateelse = "UPDATE emp_reg,emp_login SET emp_reg.emp_name='$Name',emp_reg.emp_email='$Email',emp_reg.emp_phone='$Phone',emp_reg.emp_gender=$gender,emp_login.login_email='$Email' WHERE emp_reg.emp_id=emp_login.login_id AND emp_reg.emp_id='$Id';";
            $sqlQuery = $this->connResult->query($sqlUpdateelse);
            //error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("check SQL");
                exit;
            }

            if ($sqlQuery > 0) {
                return "Employee Updated successfully!";
            } else {
                return "Sorry! Failed to update Employee.";
            }
        }
    }
    // end of empUpdate


    public function changeLoginAccess($empId,$empRole,$empName,$empEmail,$empPwd,$empLicense,$status){
        // convert pwd
        $newPwd = md5($empPwd);

        $selectSql = "SELECT * FROM emp_login WHERE login_id='$empId';";
        $result = $this->connResult->query($selectSql);

        // error checking
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("Check sql");
            exit;
        }
        $nor = $result->num_rows;

        if ($nor == 1) {
            $rec = $result->fetch_assoc();
             if ($rec['login_status'] == 0 && $rec['login_pwd'] == '123' && $rec['login_role'] == 'role') {
                // update the records 
                $updateSql = "UPDATE emp_reg,emp_login SET emp_login.login_pwd='$newPwd',emp_login.login_role='$empRole',emp_login.login_status='$status',emp_reg.emp_license='$empLicense' WHERE emp_reg.emp_id=emp_login.login_id AND emp_login.login_id='$empId';";
                $upResult = $this->connResult->query($updateSql);
                if ($upResult > 0) {
                    return 1;
                }
            } else if ($rec['login_status'] == 1) {
                $updateSql = "UPDATE emp_login SET login_status='$status' WHERE login_id='$empId';";
                $upResult = $this->connResult->query($updateSql);
                if ($upResult > 0) {
                    return 0;
                }
            }
        }
    }
    // end of changeLoginAccess


    public function tempActiveDeactive($empId)
    {
        // echo ($empId);
        $selectUser = "SELECT * FROM emp_login WHERE login_id='$empId';";
        $result = $this->connResult->query($selectUser);

        // error checking
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("Check sql");
            exit;
        }
        $nor = $result->num_rows;
        if ($nor == 1) {
            $rec = $result->fetch_assoc();
            if ($rec['login_status'] == 1) {
                $updateSql = "UPDATE emp_login SET login_status='0' WHERE login_id='$empId';";
                $upResult = $this->connResult->query($updateSql);
                if ($upResult > 0) {
                    return ("Access is prohibitted for user");
                    // echo("Access is prohibitted for user");
                }
            }else{
                $updateSql = "UPDATE emp_login SET login_status='1' WHERE login_id='$empId';";
                $upResult = $this->connResult->query($updateSql);
                if ($upResult > 0) {
                    return ("Access is granted to user");
                    // echo("Access is granted to user");
                } 
            }
        }else{
            echo("No record found");
        }
     }


     public function sendEmail($empId,$empRole,$empName,$empEmail,$empPwd){

        $msg= "<center><p>Emp Id : ".$empId." <br>
                You have assigned as ".$empRole." of SLTB Ududumbara Depot and
                Your current password is : <b>".$empPwd." </b> <br>
                <br> Make sure to reset your password.</p></center>";

            //Import PHPMailer classes into the global namespace
            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';
    
            $mail = new PHPMailer(true);  
            try {
                //Server settings
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'sltbyamove@gmail.com';                     //SMTP username
                $mail->Password   = 'bgzhtewcwlxhorot';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
                //Recipients
                $mail->setFrom('from@example.com', 'SLTB Ududumbara');
                $mail->addAddress($empEmail);     //Add a recipient
    
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Hello Mr.'.$empName.', Here is your login details';
                $mail->Body    = $msg;
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
                $mail->send();
                return 1;
            } catch (Exception $e) {
               return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
     }



}
?>

















