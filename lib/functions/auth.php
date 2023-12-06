<?php
session_start();
include_once("main.php");

class Authentication  extends Main{
     // Emp login
     public function login($userName, $userPassword){
        $sqlFetch = "SELECT * FROM emp_login WHERE login_email ='$userName';";
        $sqlResult = $this->connResult->query($sqlFetch);

        // error checking
        if($this->connResult->errno){
            echo($this->connResult->error);
            echo("Check SQL");
        }

        // check no of rows
        $nor = $sqlResult->num_rows;
        if($nor > 0){
            $rec = $sqlResult->fetch_assoc();
            $userPwd = md5($userPassword);
            // check the status
            if($rec['login_status'] == 1){
                // check the password
                if($rec['login_pwd'] == $userPwd){
                    // check the role and redirect accordingly
                    switch($rec['login_role']){
                        case 'admin':
                            // create a cookie
                            setcookie("YAMOVE", $rec['login_id'], time()+60*60, '/');
                             // create sessions
                            $_SESSION['YAMOVE_SESSION_ID']= $rec['login_id'];
                            $_SESSION['YAMOVE_SESSION_NAME'] = $rec['login_email'];
                            header('location: lib/views/admin.php');
                            exit;
                        case 'driver':
                            $_SESSION['YAMOVE_DRIVER_ID'] = $rec['login_id'];
                            $_SESSION['YAMOVE_DRIVER_NAME'] = $rec['login_email'];
                            header('location: lib/views/driver.php');
                            exit;
                        case 'conductor':
                            $_SESSION['YAMOVE_CON_ID'] = $rec['login_id'];
                            $_SESSION['YAMOVE_CON_NAME'] = $rec['login_email'];
                            header('location: lib/views/conductor.php');
                            exit;
                        case 'stock_keeper':
                            $_SESSION['YAMOVE_SK_ID'] = $rec['login_id'];
                            $_SESSION['YAMOVE_SK_NAME'] = $rec['login_email'];
                            header('location: lib/views/stockKeeper.php');
                            exit;
                        case 'tool_keeper':
                            $_SESSION['YAMOVE_TK_ID'] = $rec['login_id'];
                            $_SESSION['YAMOVE_TK_NAME'] = $rec['login_email'];
                            header('location: lib/views/toolKeeper.php');
                            exit;
                        case 'DSH':
                            $_SESSION['YAMOVE_DSH_ID'] = $rec['login_id'];
                            $_SESSION['YAMOVE_DSH_NAME'] = $rec['login_email'];
                            header('location: lib/views/deploymentSecHead.php');
                            exit;
                        case 'foreman':
                            $_SESSION['YAMOVE_FM_ID'] = $rec['login_id'];
                            $_SESSION['YAMOVE_FM_NAME'] = $rec['login_email'];
                            header('location: lib/views/foreman.php');
                            exit;
                        case 'technician':
                            $_SESSION['YAMOVE_TECH_ID'] = $rec['login_id'];
                            $_SESSION['YAMOVE_TECH_NAME'] = $rec['login_email'];
                            header('location: lib/views/technician.php');
                            exit;
                        case 'DM':
                            $_SESSION['YAMOVE_DM_ID'] = $rec['login_id'];
                            $_SESSION['YAMOVE_DM_NAME'] = $rec['login_email'];
                            header('location: lib/views/depotManager.php');
                            exit;
                        default:
                            return ("Invalid role");
                    }
                } else {
                    return ("Please check your password");
                }
            } else {
                return ("Your account has been Deactivated!");
            }
        } else {
            return ("Check your Username again!");
        }
    } 
} 
//  end of the class
