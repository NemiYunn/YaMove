<?php

session_start();

include_once("main.php");
// include_once("auto_no");

class UserAuthentication  extends Main{
     // user login
     public function userLogin($username,$userpwd){
        $sqlFetch = "SELECT * FROM usr_reg WHERE userName ='$username';";
        // run the query
        $sqlResult = $this->connResult->query($sqlFetch);
        // error checking
        if($this->connResult->errno){
            echo($this->connResult->error);
            echo("Check SQL");
        }
        //check no of rows
        $nor = $sqlResult ->num_rows;
        if($nor>0){
            // convert results into a association array
            $rec = $sqlResult -> fetch_assoc();
            // convert password
            $newuserPwd = md5($userpwd);
            // check the status
            if($rec['act_status']== 1 && $rec['verifyCode']== 'NULL'){
                    // check the pwd
                    if($rec['userPwd']== $newuserPwd){
                        // create a cookie
                        setcookie("YAMOVE-USR",$rec['userId'],time()+60*60,'/');
                        // create sessions
                        $_SESSION['YAMOVE_SESSION_UID']= $rec['userId'];
                        $_SESSION['YAMOVE_SESSION_UNAME']= $rec['userName'];

                        // redirect
                       return(1);
                    }
                    else{
                        return("Please check your password");
                    }
            }
            else{
                return("Please verify your email!");
            }
        }
        else{
            return("Please check your login details again..");
        }
    } //end of the login method

    // user login
    public function supLogin($username,$userpwd){
        $sqlFetch = "SELECT * FROM sup_reg WHERE busiEmail ='$username';";
        // run the query
        $sqlResult = $this->connResult->query($sqlFetch);
        // error checking
        if($this->connResult->errno){
            echo($this->connResult->error);
            echo("Check SQL");
        }
        //check no of rows
        $nor = $sqlResult ->num_rows;
        if($nor>0){
            // convert results into a association array
            $rec = $sqlResult -> fetch_assoc();
            // convert password
            $newuserPwd = md5($userpwd);
            // check the status
            if($rec['busiStatus']== 1 && $rec['vCode']== 'NULL'){
                    // check the pwd
                    if($rec['password']== $newuserPwd){
                        // create a cookie
                        setcookie("YAMOVE-SUP",$rec['supId'],time()+60*60,'/');
                        // create sessions
                        $_SESSION['YAMOVE_SESSION_SUPID']= $rec['supId'];
                        $_SESSION['YAMOVE_SESSION_SUPNAME']= $rec['busiEmail'];

                        // redirect
                       return(1);
                    }
                    else{
                        return("Please check your password");
                    }
            }
            else{
                return("Please verify your email!");
            }
        }
        else{
            return("Please check your login details again..");
        }
    } //end of the login method


} 
//  end of the class
// include_once('../views/user/user.php');
?>



