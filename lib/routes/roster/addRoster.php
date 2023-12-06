<?php

include_once('../../functions/roster_function.php');

//lets create an object from the Emp class 
$roster = new Roster();

$result = $roster ->addNewRoster($_POST['empId'],$_POST['datepicker'],$_POST['month'],$_POST['day1'],
$_POST['day2'],$_POST['day3'],$_POST['day4'],$_POST['day5'],$_POST['day6'],$_POST['day7'],$_POST['day8'],$_POST['day9'],$_POST['day10'],
$_POST['day11'],$_POST['day12'],$_POST['day13'],$_POST['day14'],$_POST['day15'],$_POST['day16'],$_POST['day17'],$_POST['day18'],$_POST['day19'],
$_POST['day20'],$_POST['day21'],$_POST['day22'],$_POST['day23'],$_POST['day24'],$_POST['day25'],$_POST['day26'],$_POST['day27'],
$_POST['day28'],$_POST['day29'],$_POST['day30'],$_POST['day31']);
echo($result);
?>