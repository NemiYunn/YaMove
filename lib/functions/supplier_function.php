<?php
session_start();
  
include_once('main.php');
include_once('auto_no.php');

//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Supplier extends Main
{

    public function userReg($bName, $add, $mobileNum, $userName, $userPwd, $vcode)
    {
        //lets create a new emp ID 
        $userID = new AutoNumberModule();
        $ID = $userID->number('supId', 'sup_reg', 'Sup');
        $newPwd = md5($userPwd);

        $sqlFetch = "SELECT * FROM sup_reg WHERE busiEmail ='$userName';";
        // run the query
        $sqlResult = $this->connResult->query($sqlFetch);
        // error checking
        if($this->connResult->errno){
            echo($this->connResult->error);
            echo("Check SQL");
        }
        //check no of rows
        $nor = $sqlResult ->num_rows;
        if ($nor == 0) {
        $sqlInsert = "INSERT INTO sup_reg VALUES ('$ID', '$bName', '$add', '$mobileNum', '$userName', '$newPwd','$vcode', 0);";

        $sqlQuery = $this->connResult->query($sqlInsert);

            //error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("check SQL");
                exit;
            }

            if ($sqlQuery > 0) {
                return 1;
            } else {
                return "Sorry! Something wrong. Try again.";
            }
        }else{
            return "Username is already available!";
        }

        // send mail 
    }

    public function sendMail($vMsg, $username)
    {
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
            $mail->addAddress($username);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Verify Your Account - SLTB Ududumbara';
            $mail->Body    = $vMsg;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
        //    return 1;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function verifyEmail($email, $vcode)
    {
        $sqlViewUsr = "SELECT * FROM sup_reg WHERE vCode = '$vcode' AND busiEmail = '$email';";
        $sqlQuery = $this->connResult->query($sqlViewUsr);
        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        $nor = $sqlQuery->num_rows;

        if ($nor == 1) {
            $sqlUpdate = "UPDATE sup_reg SET busiStatus = 1, vCode='NULL'  WHERE vCode='$vcode' LIMIT 1 ;";
            $sqlQuery = $this->connResult->query($sqlUpdate);
            //error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("check SQL");
                exit;
            }
            if ($sqlQuery > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    //viewRfq
    public function viewRfq()
    {
        // change this to only get technicians and formans
        $sqlViewRfq = "SELECT * FROM rfq t1 INNER JOIN item t2 ON t1.partNo = t2.partNo 
        WHERE t1.rfqStatus = 1 ORDER BY t1.rId ASC;";
        $sqlQuery = $this->connResult->query($sqlViewRfq);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                $filePath = "../images/item/" . $rec['imgPath'];

                echo ('
                <div class="col-md-3 mb-4">
                    <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="'. $filePath.'" alt="'.$rec['descrip'].'" style="max-height: 200px;>
                        <div class="card-body">
                            <h5 class="card-title">'.$rec['descrip'].'</h5>
                            <p class="card-text">'. $rec['partNo']. '</p>
                            <p class="card-text">You can put your quotation here..</p>
                            <a href="#" class="btn btn-primary addQ" id="'.$rec['rId'].'">Add Quotation</a>
                        </div>
                    </div>
                </div>
                
            ');
            }
        } else {
            echo ('
            <option value="">No Buses.</option>
            ');
        }
    }

    //fetchDetails
    public function fetchDetails($rId){
        // echo($rId);
        $sqlFetch = "SELECT t1.rQuantity, t1.closingDate, t2.descrip, t3.catDes
        FROM rfq t1
        INNER JOIN item t2 ON t1.partNo = t2.partNo
        INNER JOIN category t3 ON t2.category = t3.catNo        
        WHERE t1.rId ='$rId';";
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


    //addQuotation
    public function addQuotation($rfqNo, $uPrice)
    {
        if(isset( $_SESSION['YAMOVE_SESSION_SUPID'])){
            $supId =  $_SESSION['YAMOVE_SESSION_SUPID'];

            $sqlFetch = "SELECT * FROM quotation WHERE rId ='$rfqNo' AND supId ='$supId';";
            $sqlResult = $this->connResult->query($sqlFetch);
            // error checking
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("Check SQL");
            }
            //check no of rows
            $nor = $sqlResult->num_rows;
            if ($nor == 0) {
                $sqlInsert = "INSERT INTO quotation (supId,unitPrice,rId	) VALUES ('$supId', '$uPrice', '$rfqNo');";
                $sqlQuery = $this->connResult->query($sqlInsert);

                //error checking section
                if ($this->connResult->errno) {
                    echo ($this->connResult->error);
                    echo ("check SQL");
                    exit;
                }
                if ($sqlQuery > 0) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return "You have already add quotation for this item!";
            }
        }else{
            return 2;
        }
    }


}
?>