<?php
session_start();

include_once('main.php');
include_once('auto_no.php');

class Driver extends Main
{
    public function viewRoster()
    {
      
      if (isset($_SESSION['YAMOVE_DRIVER_ID'])) {
          $empId = $_SESSION['YAMOVE_DRIVER_ID'];
      }

      date_default_timezone_set('Asia/Colombo');
      $month = date("F");
      $year = date("Y");

      $sqlFetch = " SELECT empId,years,months, 
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.01')) as 'day1',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.02')) as 'day2',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.03')) as 'day3',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.04')) as 'day4',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.05')) as 'day5',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.06')) as 'day6',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.07')) as 'day7',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.08')) as 'day8',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.09')) as 'day9',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.10')) as 'day10',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.11')) as 'day11',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.12')) as 'day12',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.13')) as 'day13',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.14')) as 'day14',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.15')) as 'day15',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.16')) as 'day16',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.17')) as 'day17',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.18')) as 'day18',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.19')) as 'day19',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.20')) as 'day20',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.21')) as 'day21',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.22')) as 'day22',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.23')) as 'day23',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.24')) as 'day24',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.25')) as 'day25',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.26')) as 'day26',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.27')) as 'day27',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.28')) as 'day28',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.29')) as 'day29',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.30')) as 'day30',
      JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.31')) as 'day31'
      FROM `roster` WHERE empId='$empId' AND years ='$year' AND months ='$month';";
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
        // end of fetch roster
    }

    // viewNotifications
    public function viewNotifications()
    {
        if (isset($_SESSION['YAMOVE_DRIVER_ID'])) {
            $empId = $_SESSION['YAMOVE_DRIVER_ID'];
        }

        $sqlSelect = "SELECT * from duty_change t1 INNER JOIN curr_duty t2 ON t1.dId = t2.Id
       INNER JOIN schedules t3 ON t2.schId = t3.schId
       WHERE newEmpId='$empId' AND DATE(t1.recTime) = CURDATE()
       ORDER BY aId DESC;";

        $notCount = $this->connResult->query($sqlSelect);
        $nor = $notCount->num_rows;
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
                       <th scope="col">Message</th>
                       <th scope="col" class="no-print">CHECK</th>
                   </tr>
               </thead>
               <tbody>
       ');
        if ($nor > 0) {
            while ($rec = $notCount->fetch_assoc()) {
                if (($rec['newEmpId'] != $rec['empId']) && ($rec['newBusId'] != $rec['busId'])) {
                    $msg = "<center>Hi..! You have assign to a new duty for today.<br>
                    Your current shedule No. is " . $rec['schNo'] . " and <br>
                    Your current Bus Number is " . $rec['newBusId'] . "</center>";
                } else if (($rec['newEmpId'] == $rec['empId']) && ($rec['newBusId'] != $rec['busId'])) {
                    $msg = "<center>Hi..!
                   Your current shedule No. is " . $rec['schNo'] . " and <br>
                   new Bus has been assigned for your journey today.<br>
                    Your Bus Number is " . $rec['newBusId'] . "</center>";
                } else if (($rec['newEmpId'] != $rec['empId']) && ($rec['newBusId'] == $rec['busId'])) {
                    $msg = "<center>Hi..! You have assign to a new duty for today.<br>
                   Your current shedule No. is " . $rec['schNo'] . " and <br>
                    Your Bus Number is " . $rec['newBusId'] . "</center>";
                }

                echo ("
                           <tr style='background-color:F7F3F2'>
                               <td> <font face = 'Verdana' size = '3'>" . $msg . "</font></td>");
                if ($rec['dcStatus'] == 1) {
                    echo ("<td><button id=" . $rec['aId'] . " class='btn btn-outline-primary btn-sm no-print conBtn'>ACCEPT</button></td>");
                } else if ($rec['dcStatus'] == 0) {
                    echo ("<td><button id=" . $rec['aId'] . " class='btn btn-outline-success btn-sm no-print conBtn'>ACCEPTED</button></td>");
                }
                echo ("</tr>
                    ");
            }
        } else {
            echo ('
                           <tr><td> No newly assigned duties!</td></tr>
                       ');
        }
        echo ('
               </tbody>
               </table>
           ');
    }

    // confirmDuty
    public function confirmDuty($aId)
    {

        $sqlStateUpdate = "UPDATE duty_change SET dcStatus = 0 WHERE aId='$aId';";
        $sqlQuery = $this->connResult->query($sqlStateUpdate);
        //error checking section
        if ($this->connResult->errno) {
            echo ($this->connResult->error);
            echo ("check SQL");
            exit;
        }
        if ($sqlQuery > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

     // viewTrips
     public function viewTrips()
     {
         date_default_timezone_set('Asia/Colombo');
         $Date = date("Y-m-d");
         $month = date("F");
         $day = date("d");
         $year = date("Y");
         // Set the current time
         $currentDateTime = new DateTime();
         $currentTime = $currentDateTime->format('H:i:s');

        if (isset($_SESSION['YAMOVE_DRIVER_ID'])) {
            $empId = $_SESSION['YAMOVE_DRIVER_ID'];
        }
     
         // check schNo for the day
         $sqlViewSch = "SELECT JSON_UNQUOTE(JSON_EXTRACT(schedules,'$.$day')) as schNum
         FROM roster WHERE months='$month' AND years='$year' AND empId='$empId';";
         $sqlQuery = $this->connResult->query($sqlViewSch);
         $rec = $sqlQuery->fetch_assoc();
         $schNo = $rec['schNum'];
     
         // if you are on a free day
         if ($schNo == "RL") {
             // check whether you are in the duty_change table today
             $sqlViewDuty = "SELECT * FROM duty_change WHERE DATE(recTime) = CURDATE()
             AND newEmpId ='$empId' ORDER BY recTime DESC LIMIT 1;";
             $sqlQuery1 = $this->connResult->query($sqlViewDuty);
             $nor = $sqlQuery1->num_rows;
             // if yes, get schId of current duty and get trip details
             if ($nor == 1) {
                 $sqlViewTrp = "SELECT * FROM trip t1 INNER JOIN schedules t4 ON 
                 t1.schId=t4.schId INNER JOIN curr_duty t2 ON t1.schId = t2.schId 
                 INNER JOIN duty_change t3 ON t2.Id= t3.dId
                 WHERE t3.newEmpId='$empId' AND t3.dcStatus=0;";
     
                 $sqlQuery2 = $this->connResult->query($sqlViewTrp);
                 $trips = array(); // Array to store the trips
     
                 while ($rec2 = $sqlQuery2->fetch_assoc()) {
                     $trips[] = $rec2; // Store each trip record in the array
                 }
     
                 if (!empty($trips)) {
                     $busId = $trips[0]['busId']; // Use the first record's busId
     
                     echo ('
                     <table class="table table-bordered table-responsive-lg">
                     <thead>
                         <tr>
                             <th scope="col">Bus No.</th>
                             <th scope="col">sch No.</th>
                             <th scope="col">Departure From >> Arrive To</th>
                             <th scope="col">Departure At >> Arrive At</th>
                         </tr>
                     </thead>
                     <tbody>
                     ');
     
                     foreach ($trips as $trip) {
                         echo ("
                             <tr>
                                 <td>" . $busId . "</td>
                                 <td>" . $trip['schNo'] . "</td>
                                 <td>" . $trip['departureFrom'] . " >> " . $trip['arriveTo'] . "</td>
                                 <td>" . $trip['departureAt'] . " >> " . $trip['arriveAt'] . "</td>
                             </tr>
                         ");
                     }
     
                     echo ('
                     </tbody>
                     </table>
                     ');
                 } else {
                     echo ("Check whether you have newly assigned duties");
                 }
             } else {
                 echo ("Check whether you have newly assigned duties");
             }
         } else {
             // if you are in the roster
             $sqlViewTrp = "SELECT * FROM trip t1 INNER JOIN schedules t2 ON t1.schId = t2.schId 
             INNER JOIN roster t3 ON t2.schNo= JSON_UNQUOTE(JSON_EXTRACT(t3.schedules,'$.$day'))
             WHERE t3.months='$month' AND t3.years='$year' AND t3.empId='$empId';";
     
             $sqlQuery2 = $this->connResult->query($sqlViewTrp);
             $trips = array(); // Array to store the trips
     
             while ($rec2 = $sqlQuery2->fetch_assoc()) {
                 $trips[] = $rec2; // Store each trip record in the array
             }
     
             if (!empty($trips)) {
                 // check whether data for your Id in duty_change(newBusId)
                 $sqlViewBus = "SELECT * FROM duty_change WHERE DATE(recTime) = CURDATE()
                 AND newEmpId ='$empId' ORDER BY recTime DESC LIMIT 1;";
                 $sqlQuery3 = $this->connResult->query($sqlViewBus);
                 $nor3 = $sqlQuery3->num_rows;
     
                 if ($nor3 == 1) {
                     $rec3 = $sqlQuery3->fetch_assoc();
                     $busId = $rec3['newBusId'];
                 } else {
                     // if not, get bus id from the schedule table
                     $busId = $trips[0]['busNo']; // Use the first record's busNo
                 }
     
                 echo ('
                 <table class="table table-bordered table-responsive-lg">
                 <thead>
                     <tr>
                         <th scope="col">Bus No.</th>
                         <th scope="col">sch No.</th>
                         <th scope="col">Departure From >> Arrive To</th>
                         <th scope="col">Departure At >> Arrive At</th>
                     </tr>
                 </thead>
                 <tbody>
                 ');
     
                 foreach ($trips as $trip) {
                     echo ("
                         <tr>
                             <td>" . $busId . "</td>
                             <td>" . $trip['schNo'] . "</td>
                             <td>" . $trip['departureFrom'] . " >> " . $trip['arriveTo'] . "</td>
                             <td>" . $trip['departureAt'] . " >> " . $trip['arriveAt'] . "</td>
                         </tr>
                     ");
                 }
     
                 echo ('
                 </tbody>
                 </table>
                 ');
             } else {
                 echo ('
                 <table class="table table-bordered table-responsive-lg">
                 <thead>
                     <tr>
                         <th scope="col">Bus No.</th>
                         <th scope="col">sch No.</th>
                         <th scope="col">Departure From >> Arrive To</th>
                         <th scope="col">Departure At >> Arrive At</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td> No Trips available today! Enjoy your rest day..!</td>
                     </tr>
                 </tbody>
                 </table>
                 ');
             }
         }
     
         // error checking section
         if ($this->connResult->errno) {
             echo ($this->connResult->error);
             echo ("check sql");
             exit;
         }
     }//end


     public function getEmpId(){
       
        if (isset($_SESSION['YAMOVE_DRIVER_ID'])) {
            $empId = $_SESSION['YAMOVE_DRIVER_ID'];
        }

        $sqlFetch = "SELECT * FROM emp_reg WHERE emp_id ='$empId';";
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
     

}// end of class
