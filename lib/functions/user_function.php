<?php
session_start();
  
include_once('main.php');
include_once('auto_no.php');

//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User extends Main
{

    public function userReg($title, $fName, $lName, $nic, $mobileNum, $userName, $userPwd, $userComPwd, $vcode)
    {
        //lets create a new emp ID 
        $userID = new AutoNumberModule();
        $ID = $userID->number('userId', 'usr_reg', 'Usr');
        $newPwd = md5($userPwd);

        $sqlFetch = "SELECT * FROM usr_reg WHERE userName ='$userName';";
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
        $sqlInsert = "INSERT INTO usr_reg VALUES ('$ID','$title', '$fName', '$lName', '$nic', '$mobileNum', '$userName', '$newPwd','$vcode', 0);";

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
        $sqlViewUsr = "SELECT * FROM usr_reg WHERE verifyCode = '$vcode' AND userName = '$email';";
        $sqlQuery = $this->connResult->query($sqlViewUsr);
        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        $nor = $sqlQuery->num_rows;

        if ($nor == 1) {
            $sqlUpdate = "UPDATE usr_reg SET act_status = 1, verifyCode='NULL'  WHERE verifyCode='$vcode' LIMIT 1 ;";
            $sqlQuery = $this->connResult->query($sqlUpdate);
            //error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("check SQL");
                exit;
            }
            if ($sqlQuery > 0) {
                return "1";
            } else {
                return "0";
            }
        }
    }

    public function searchRoute()
    {
        $sqlViewRoutes = "SELECT rtStarts as Rt FROM routes WHERE rtStatus = 1 UNION SELECT rtEnds as Rt FROM routes WHERE rtStatus = 1 ORDER BY Rt ;";
        $sqlQuery = $this->connResult->query($sqlViewRoutes);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
         <option selected><i class="fa fa-map-marker" aria-hidden="true"></i>From :</option>
        ');
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                echo ("
            <option value='" . $rec['Rt'] . "'> " . $rec['Rt'] . "</option>
            ");
            }
        } else {
            echo ('
            <option value="">No data available.</option>
            ');
        }
    }

    public function searchRouteTo()
    {
        $sqlViewRoutes = "SELECT rtStarts as Rt FROM routes WHERE rtStatus = 1 UNION SELECT rtEnds as Rt FROM routes WHERE rtStatus = 1 ORDER BY Rt ;";
        $sqlQuery = $this->connResult->query($sqlViewRoutes);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
         <option selected><i class="fa fa-map-marker" aria-hidden="true"></i>To :</option>
        ');
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                echo ("
            <option value='" . $rec['Rt'] . "'> " . $rec['Rt'] . "</option>
            ");
            }
        } else {
            echo ('
            <option value="">No data available.</option>
            ');
        }
    }

    // showTripData
    public function showTripData($from,$to,$date)
    {
        $sqlViewTrips = "SELECT trpId,busNo,departureAt,arriveAt FROM trip t1 INNER JOIN schedules t2 ON t1.schId = t2.schId INNER JOIN routes t3 ON t2.routeId = t3.rtId WHERE t1.trpStatus = 1 AND t2.schStatus = 1 AND t1.departureFrom ='$from' AND t1.arriveTo = '$to' ORDER BY trpId ASC;";
        $sqlQuery = $this->connResult->query($sqlViewTrips);

        // error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }

        echo ('
        <table class="table table-striped table-hover mt-5">
        <thead>
            <tr id="trpId">
                <th > Bus No. </th>
                <th > Departs </th>
                <th > Arrives </th>
                <th > Available Seats </th>
                <th > Price  </th>
            </tr>
        </thead>
        <tbody>
        ');

    $nor = $sqlQuery->num_rows;

    if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {

                $sqlsecc = "SELECT max(secNo) as maSec,min(secNo) as miSec FROM trip t1 INNER JOIN schedules t2 ON t1.schId = t2.schId INNER JOIN routes t3 ON t2.routeId = t3.rtId INNER JOIN halt t4 ON t3.rtId = t4.rtId WHERE t1.trpStatus = 1 AND t2.schStatus = 1 AND t1.departureFrom ='$from' AND t1.arriveTo = '$to' AND (t4.hltName ='$from' OR t4.hltName ='$to') ORDER BY trpId ASC;";
                $sqlQuery2 = $this->connResult->query($sqlsecc);
                $rec2 = $sqlQuery2->fetch_assoc();
                $maSec = $rec2['maSec'];
                $miSec = $rec2['miSec'];

                $secNo = $maSec - $miSec;
                $sqlSecFare = "SELECT fare FROM secfare WHERE secNo ='$secNo';";
                $sqlQuery3 = $this->connResult->query($sqlSecFare);
                $rec3 = $sqlQuery3->fetch_assoc();
                $secF = $rec3['fare'];

                $sqlSeat = "SELECT * FROM reserve_seat WHERE trpId ='$rec[trpId]' AND resDate='$date';";
                $sqlQuery4 = $this->connResult->query($sqlSeat);
                $rec4 = $sqlQuery4->fetch_assoc(); 

            $norr = $sqlQuery4->num_rows;
            if($norr>0){
                $remainSeats = $rec4['remainSeats'];
               
            }else if($norr == 0){
                $sqlBusSeat = "SELECT busSeats FROM bus WHERE busNo ='$rec[busNo]';";
                $sqlQuery5 = $this->connResult->query($sqlBusSeat);
                $rec5 = $sqlQuery5->fetch_assoc();
                if( $rec5['busSeats'] == 54){
                    $remainSeats = $rec5['busSeats'] - 7;
                }else if( $rec5['busSeats'] == 50){
                    $remainSeats = $rec5['busSeats'] - 5;
                }
                
            }
            // put data into table
            echo ( "
                <tr id=" . $rec['trpId'] . " class=".'trow'." style=".'padding:10px;'.">
                    <td>" . $rec['busNo'] . "</td>
                    <td>" . $rec['departureAt'] . "</td>
                    <td>" . $rec['arriveAt'] . "</td>
                    <td>" . $remainSeats . "</td>
                    <td>" .'LKR '. $secF . "</td>
                    ");
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
        
    }
// end

public function getHaltsBoarding($from,$to)
    {
        $sqlViewHalts = "SELECT hltId,hltName FROM trip t1 INNER JOIN schedules t2 ON t1.schId = t2.schId INNER JOIN routes t3 ON t2.routeId = t3.rtId INNER JOIN halt t4 ON t3.rtId = t4.rtId WHERE t1.trpStatus = 1 AND t2.schStatus = 1 AND t3.rtStatus = 1 AND t4.hltStatus = 1 AND t1.departureFrom ='$from' AND t1.arriveTo = '$to' GROUP BY t4.hltName ASC;";
        $sqlQuery = $this->connResult->query($sqlViewHalts);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
         <option selected><i class="fa fa-map-marker" aria-hidden="true"></i>Boarding :</option>
        ');
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                echo ("
            <option value='" . $rec['hltId'] . "'> " . $rec['hltName'] . "</option>
            ");
            }
        } else {
            echo ('
            <option value="">No data available.</option>
            ');
        }
    }

    public function getHaltsDropping($from,$to)
    {
        $sqlViewHalts = "SELECT hltId,hltName FROM trip t1 INNER JOIN schedules t2 ON t1.schId = t2.schId INNER JOIN routes t3 ON t2.routeId = t3.rtId INNER JOIN halt t4 ON t3.rtId = t4.rtId WHERE t1.trpStatus = 1 AND t2.schStatus = 1 AND t3.rtStatus = 1 AND t4.hltStatus = 1 AND t1.departureFrom ='$from' AND t1.arriveTo = '$to' GROUP BY t4.hltName DESC;";
        $sqlQuery = $this->connResult->query($sqlViewHalts);

        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }
        echo ('
         <option selected><i class="fa fa-map-marker" aria-hidden="true"></i>Dropping :</option>
        ');
        $nor = $sqlQuery->num_rows;
        if ($nor > 0) {
            while ($rec = $sqlQuery->fetch_assoc()) {
                echo ("
            <option value='" . $rec['hltId'] . "'> " . $rec['hltName'] . "</option>
            ");
            }
        } else {
            echo ('
            <option value="">No data available.</option>
            ');
        }
    }
    // end

    public function getTotFare($boarding,$dropping,$NoofPassengers)
    {
        $sqlViewHalts = "SELECT max(secNo) as maSec,min(secNo) as miSec FROM halt WHERE hltId = '$boarding' OR hltId = '$dropping';";
        $sqlQuery = $this->connResult->query($sqlViewHalts);
        $rec = $sqlQuery->fetch_assoc();

        $secs =  $rec['maSec'] -  $rec['miSec'];

        $sqlViewHalts = "SELECT fare FROM secfare WHERE secNo = '$secs';";
        $sqlQuery1 = $this->connResult->query($sqlViewHalts);
        $rec1 = $sqlQuery1->fetch_assoc();
        $totFare= $rec1['fare']*$NoofPassengers;

        // error checking
        if($this->connResult->errno){
            echo ($this->connResult->error);
            echo("check sql");
            exit;
        }
        $nor= $sqlQuery1->num_rows;
        if($nor>0){
            echo ($totFare);
        }else{
            echo("no data");
        }
    }
    // end

    public function getOnePersonFare($boarding,$dropping,$NoofPassengers)
    {
        $sqlViewHalts = "SELECT max(secNo) as maSec,min(secNo) as miSec FROM halt WHERE hltId = '$boarding' OR hltId = '$dropping';";
        $sqlQuery = $this->connResult->query($sqlViewHalts);
        $rec = $sqlQuery->fetch_assoc();

        $secs =  $rec['maSec'] -  $rec['miSec'];

        $sqlViewHalts = "SELECT fare FROM secfare WHERE secNo = '$secs';";
        $sqlQuery1 = $this->connResult->query($sqlViewHalts);
        $rec1 = $sqlQuery1->fetch_assoc();
        $Fare= $rec1['fare']*1;

        // error checking
        if($this->connResult->errno){
            echo ($this->connResult->error);
            echo("check sql");
            exit;
        }
        $nor= $sqlQuery1->num_rows;
        if($nor>0){
            echo ($Fare);
        }else{
            echo("no data");
        }
    }

    public function getLoginState()
    {
        if(isset($_SESSION['YAMOVE_SESSION_UNAME'])){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function userDetails()
    {
        if(isset($_SESSION['YAMOVE_SESSION_UNAME'])){
          $uName = $_SESSION['YAMOVE_SESSION_UNAME'];
          $sqlFetch = "SELECT * FROM usr_reg WHERE userName ='$uName';";
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

        }else{
            echo "No such user";
        }
    }

    // checkReserveTimeExceeds for perticular day
    public function checkReserveTimeExceeds($trpId,$date)
    {
        $sqlTripTime = "SELECT departureAt FROM trip WHERE trpId = '$trpId';";
        $sqlQuery = $this->connResult->query($sqlTripTime);
        $rec = $sqlQuery->fetch_assoc();

        // error checking
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check sql");
            exit;
        }

        $depTime =  $rec['departureAt'];
        $depTimestamp = strtotime($depTime);
        $modifiedDepTime = $depTimestamp - (2 * 3600); // Subtract 2 hours 

        $modifiedDepAt = date("H:i:s", $modifiedDepTime);

        date_default_timezone_set('Asia/Colombo');
        $current_time = date("H:i:s");
        $current_date = date("Y-m-d"); 

        if($date ==  $current_date && $modifiedDepAt < $current_time ){
            echo (0);
        }else{
            echo(1);
        }
    }


    public function makeReservation($trpId,$resDate,$noPas,$totFare,$seatArray)
    {
        if(isset($_SESSION['YAMOVE_SESSION_UNAME'])){
          $uName = $_SESSION['YAMOVE_SESSION_UNAME'];
          $sqlFetch = "SELECT * FROM usr_reg WHERE userName ='$uName';";
          $sqlResult = $this->connResult->query($sqlFetch);
          $rec = $sqlResult->fetch_assoc();
          $userId = $rec['userId'];

            //create reference No
            $random_string = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
            $string = substr($random_string, 0, 3);
            $number = sprintf("%06d", rand(0, 999999));

            // Concatenate the random string and random number to create the reference number
            $reference_number = $string .'-'. $number;
            if($trpId != ''){

                $sqlFetchDup = "SELECT * FROM reservation WHERE trpId ='$trpId' AND seats ='$seatArray';";
                $sqlResultDup = $this->connResult->query($sqlFetchDup);
                $norD = $sqlResultDup->num_rows;

                if($norD == 0){
                    $sqlReserve = "INSERT INTO reservation(resDate,noOfSeats,totFare,refNo,seats,trpId,userId,resStatus) 
                    VALUES ('$resDate','$noPas','$totFare','$reference_number','$seatArray','$trpId','$userId',2);";
                    $sqlQuery = $this->connResult->query($sqlReserve);
    
                    date_default_timezone_set('Asia/Colombo');
                    $currentTimestamp = time();
                    $fifteenMinutesAgo = $currentTimestamp - (15 * 60); // 15 minutes ago in seconds
    
                    $myArray = json_decode($seatArray);
    
                    foreach ($myArray as $value) {
                        $sqlUpdateSeatPlan = "UPDATE seat_plan SET planStatus = 1 WHERE trpId='$trpId' AND resDate='$resDate' AND userId='$userId' AND seatNo ='$value' AND recordTime >= FROM_UNIXTIME($fifteenMinutesAgo);";
                        $sqlQuerySeat = $this->connResult->query($sqlUpdateSeatPlan);
                    }
    
                    $sqlFetch2 = "SELECT * FROM reserve_seat WHERE trpId ='$trpId' AND resDate='$resDate';";
                    $sqlResult2 = $this->connResult->query($sqlFetch2);
                    $nor = $sqlResult2->num_rows;
                    if ($nor == 0) {
    
                        $sqlFetch3 = "SELECT busSeats FROM bus t1 INNER JOIN schedules t2 ON t1.busNo = t2.busNo INNER JOIN trip t3 ON t2.schId = t3.schId WHERE t3.trpId = '$trpId' ;";
                        $sqlResult3 = $this->connResult->query($sqlFetch3);
                        $rec3 = $sqlResult3->fetch_assoc();
                        if($rec3['busSeats'] == 54){
                            // substract counter seats
                            $seats = $rec3['busSeats'] - 7;
                        }else if($rec3['busSeats'] == 50){
                            // substract counter seats
                            $seats = $rec3['busSeats'] - 5;
                        }
                       
                        $remainSeats = $seats - $noPas;
                        $sqlRemainSeat = "INSERT INTO reserve_seat(trpId,resDate,remainSeats) VALUES ('$trpId','$resDate','$remainSeats');";
                        $sqlQuerySeat = $this->connResult->query($sqlRemainSeat);
                    }else if($nor>0){
                        $sqlFetch4 = "SELECT * FROM reserve_seat WHERE trpId ='$trpId' AND resDate='$resDate';";
                        $sqlResult4 = $this->connResult->query($sqlFetch4);
                        $rec4 = $sqlResult4->fetch_assoc();
                        $seats = $rec4['remainSeats'];
    
                        $remainSeats = $seats - $noPas;
    
                        $sqlUpdate = "UPDATE reserve_seat SET remainSeats = '$remainSeats' WHERE trpId='$trpId' AND resDate='$resDate';";
                        $sqlQuerySeat = $this->connResult->query($sqlUpdate);
    
                    }
                }   
            }
            // error checking section
            if ($this->connResult->errno) {
                echo ($this->connResult->error);
                echo ("Check SQL");
                exit;
            }
            if ($sqlQuery > 0) {
                echo $reference_number;
            } else {
                echo "Sorry! Failed to made reservation.";
            }
    }
    }

    public function reservationMail($trpId, $from,$to,$boarding,$dropping,$date,$noOfSeats,$totPrice,$selectedIds,$refNo,$busNo,$dep,$arr)
    {
        
        if(isset($_SESSION['YAMOVE_SESSION_UNAME'])){
            $uName = $_SESSION['YAMOVE_SESSION_UNAME'];
            $sqlFetch = "SELECT * FROM usr_reg WHERE userName ='$uName';";
            $sqlResult = $this->connResult->query($sqlFetch);
            $rec = $sqlResult->fetch_assoc();
            $userName = $rec['userName'];
            $nic = $rec['nic'];
            $mobileNum = $rec['mobileNum'];
            $lName=$rec['lName'];
            $title=$rec['title'];
        }

        $sqlFetch = "SELECT hltName FROM halt WHERE hltId ='$boarding';";
        $sqlResult = $this->connResult->query($sqlFetch);
        $rec = $sqlResult->fetch_assoc();
        $board = $rec['hltName'];

        $sqlFetch = "SELECT hltName FROM halt WHERE hltId ='$dropping';";
        $sqlResult = $this->connResult->query($sqlFetch);
        $rec = $sqlResult->fetch_assoc();
        $drop = $rec['hltName'];


        $Ids = json_decode($selectedIds); // Replace $selectedIds with your actual array
        $tableHeaders = "";
        $tableRows = "<tr>";

        // Generate the HTML for the table headers based on the number of columns
        for ($i = 1; $i <= count($Ids); $i++) {
            $tableHeaders .= "<th> S.N. </th>";
        }

        // Generate the HTML for the table rows using the $selectedIds array
        for ($i = 0; $i < count($Ids); $i++) {
            $tableRows .= "<td> " . $Ids[$i]. "</td>";
        }

        $tableRows .= "</tr>";

        date_default_timezone_set('Asia/Colombo');
        $current_date = date("Y-m-d"); 

        $content= '
        <body>
            <div class="container" style="width:100%;max-width:600px;margin:0 auto;padding:20px;font-family:Arial,sans-serif;">
            <div class="header" style="text-align:center;margin-bottom:20px;">
                <h1>SLTB UDUDUMBARA DEPOT</h1>
                <h3>ONLINE TICKET RESERVATION</h3>
            </div>

            <div class="content" style="margin-bottom:20px;">
                <p>Dear '.$title.''.$lName.',</p>
                <p>Your seat booking has been confirmed. Please find below the details of your booking:</p>
            </div>

            <div class="details" style="margin-bottom:20px;">
                <table style="width:100%;border-collapse:collapse;">
                    <tr>
                     <th style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">Reference No.</th>
                        <td style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">'.$refNo.'</td>
                    </tr>
                    <tr>
                        <th style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">Bus No</th>
                        <td style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">'.$busNo.'</td>
                    </tr>
                    <tr>
                        <th style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">Route</th>
                        <td style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">'.$from.' ->> '.$to.'</td>
                    </tr>
                    <tr>
                        <th style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">Time</th>
                        <td style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">'.$dep.' ->> '.$arr.'</td>
                    </tr>
                    <tr>
                        <th style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">Departure</th>
                        <td style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">'.$board.'</td>
                    </tr>
                    <tr>
                        <th style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">Arrival</th>
                        <td style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">'.$drop.'</td>
                    </tr>
                    <tr>
                        <th style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">Date</th>
                        <td style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">'.$date.'</td>
                    </tr>
                    <tr>
                        <th style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">Seat Numbers</th>
                        <td style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">
                            <table class="seat-numbers-table" style="margin-top:10px;border:1px solid #ddd;border-collapse:collapse;">
                            <thead>'
                        . '<thead>' . $tableHeaders . '</thead>'
                        .'<tbody>' . $tableRows . '</tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">Fare Total</th>
                        <td style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">'.$totPrice.'</td>
                    </tr>
                    <tr>
                        <th style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">NIC Number</th>
                        <td style="padding:8px;text-align:left;border-bottom:1px solid #ddd;">'.$nic.'</td>
                    </tr>
                </table>
            </div>

            <div class="footer" style="text-align:center;">
                <small>
                <p> If you have any questions or need further assistance, please don\'t hesitate to contact us.</p>
                <p>Thank you for choosing our service!</p>
                </small>
                <h4>Tel No: 0812492245</h4>
            </div>
        </div>
        </body>';
        

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
            $mail->addAddress($userName);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Reservation Details';
            $mail->Body    = $content;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return 1;
        } catch (Exception $e) {
           return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function seatPlan($seatArray, $trpId, $resDate)
    {
        if (isset($_SESSION['YAMOVE_SESSION_UNAME'])) {
            $uName = $_SESSION['YAMOVE_SESSION_UNAME'];
            $sqlFetch = "SELECT * FROM usr_reg WHERE userName ='$uName';";
            $sqlResult = $this->connResult->query($sqlFetch);
            $rec = $sqlResult->fetch_assoc();
          $userId = $rec['userId'];

            $myArray = json_decode($seatArray);

            foreach ($myArray as $value) {
                // do something with each value in the array
                $sqlFetch = "SELECT * FROM seat_plan WHERE trpId = '$trpId' AND userId='$userId' AND resDate='$resDate' AND seatNo='$value' ;";
                $sqlResult = $this->connResult->query($sqlFetch);
                $nor= $sqlResult->num_rows;
                
                if($nor == 0){
                    $sqlRemainSeat = "INSERT INTO seat_plan(trpId,resDate,userId,seatNo,planStatus) VALUES ('$trpId','$resDate','$userId','$value',2);";
                    $sqlQuerySeat = $this->connResult->query($sqlRemainSeat);  
                }else{
                    echo "Sorrry! Your selected seats have been reserved, try again..";
                }
                if($this->connResult->errno){
                    echo ($this->connResult->error);
                    echo("check sql");
                    exit;
                }
                if($sqlQuerySeat>0){
                    echo ("done");
                }else{
                    echo("no records found");
                } 
            }
          // error checking
          

        }else{
            echo "No such user";
        }
    }

    public function getSeats($trpId,$resDate)
    {
        $viewSeats = "SELECT seatNo FROM seat_plan WHERE trpId='$trpId' AND resDate='$resDate' AND planStatus= 2;";
        $sqlQuery = $this->connResult->query($viewSeats);

        $nor = $sqlQuery->num_rows;
        $seats = array(); // initialize an empty array for seat numbers

        if ($nor > 0) {
            // loop through results and add each seatNo to the seats array
            while ($rec = $sqlQuery->fetch_assoc()) {
                $seats[] = $rec['seatNo'];
            }
            echo implode(', ', $seats); // output comma-separated list of seats
        } else {
            echo ("no data");
        }
    }

    public function getSeatsReserved($trpId,$resDate)
    {
        $viewSeats = "SELECT seatNo FROM seat_plan WHERE trpId='$trpId' AND resDate='$resDate' AND planStatus= 1;";
        $sqlQuery = $this->connResult->query($viewSeats);

        $nor = $sqlQuery->num_rows;
        $seats = array(); // initialize an empty array for seat numbers

        if ($nor > 0) {
            // loop through results and add each seatNo to the seats array
            while ($rec = $sqlQuery->fetch_assoc()) {
                $seats[] = $rec['seatNo'];
            }
            echo implode(', ', $seats); // output comma-separated list of seats
        } else {
            echo ("no data");
        }
    }

    public function getBusSeats($trpId)
    {
        $viewSeats = "SELECT busSeats FROM bus t1 INNER JOIN schedules t2 ON t1.busNo = t2.busNo INNER JOIN trip t3 ON t2.schId = t3.schId WHERE t3.trpId = '$trpId';";
        $sqlQuery = $this->connResult->query($viewSeats);

        $rec = $sqlQuery->fetch_assoc();
        $noSeats = $rec['busSeats'];

        echo ($noSeats); 
    }


}
// end of class
