<?php

include_once("../include/admin_style.php");

?>
<style>
    .result {
        background-color: green;
        color: #fff;
        padding: 20px;
    }

    html,
    body {
        height: 100%;
    }

    .container {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo {
        display: flex;
        justify-content: center;
        margin-right: 100px;
    }
</style>

<script src="../../js/qrReader.js"></script>

<div class="container">
    <div class="row d-flex align-items-center">
        <div class="col-md-1 mt-5">
            <div class="logo">
                <img src="../images/logo.png" width="210px" height="120px" alt="">
            </div>
        </div>
        <div class="col-md-10">
            <div class="row justify-content-center">
                <div class="col-md-10 card mt-2">
                    <div class="card-header">
                        <center>
                            <h3><b>WELCOME To SLTB Ududumbara</b></h3>
                        </center>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- <div class="col-lg-10"> -->
                            <div>
                                <div style="width:500px;" id="reader"></div>
                                <div style="display:none"> <span id="result"></span></div>
                            </div>
                            <!-- </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var key = "a"; // key for encrypt NIC using AES

    $(document).ready(function() {

        function onScanSuccess(qrCodeMessage) {
            document.getElementById('result').innerHTML = '<span class="result">' + qrCodeMessage + '</span>';
            var encNic = $("#result").text();
            var nic = CryptoJS.AES.decrypt(encNic, key).toString(CryptoJS.enc.Utf8);

            console.log(nic);

            $.ajax({
                url: "../routes/attendance/markAttendance.php",
                method: "POST",
                data: {
                    nic: nic
                },
                dataType: "json",
                success: function(data) {
                    var snd = new Audio("../audio/beep.mp3");
                    snd.play();
                    if (data.emp_gender == 0) {
                        $title = "Miss.";
                    } else {
                        $title = "Mr.";
                    }
                    $name= $title + " " + data.emp_name;
                    $empId = data.emp_Id;
                    $("#msg").text("WELCOME To SLTB Ududumbara..!");
                    // alert(data);
                    if (data != 1) {
                        Swal.fire({
                            title: 'WELCOME To the SLTB Ududmbara Depot..!',
                            text: $name,
                            width: 600,
                            padding: '3em',
                            color: '#8c0d37',
                            backdrop: `
                                     rgba(255, 0, 0, 0.6);
                                    url("/images/nyan-cat.gif")
                                    left top
                                    no-repeat `,
                            timer: 7500
                        })
                    }
                }
            });

        }

        function onScanError(errorMessage) {
            //handle scan error
        }
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess, onScanError);

    });
</script>