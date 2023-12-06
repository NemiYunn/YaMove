<?php
// include admin style script
// include_once("../../include/user_style.php");
// include_once("../include/user_nav.php");
// include_once("user/home.php");
?>

<!-- <head>
    <style>
        /* Center align the header */
        .card-header {
            text-align: center;
        }

        /* Style the logo */
        .card-header img {
            width: 100px;
            height: 60px;
        }

        /* Style the title */
        .card-header h2,
        .card-header h3 {
            margin: 0;
        }

        /* Style the labels */
        /* label {
            font-weight: 100;
            font-size: 20px;
        } */

        /* Style the table */
        table {
            border: 1px solid black;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 5px;
        }

        /* Hide the print button on screen */
        .no-print {
            display: none;
        }

        /* Style the print button */
        .btn-print {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn-print:hover {
            background-color: darkgreen;
            cursor: pointer;
        }

        .center-horizontal {
            margin: 0 auto;
        }

        .center-vertical {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head> -->
<div class="col-md-2"></div>
<div id="cardDetails" class=" col-md-7">
    <div class="card" id="pay">
        <div class="card-header ">
            <div class="row">
                <div class="col-md-2">
                    <img src="../images/logo.png" width="100px" height="60px" alt="">
                </div>
                <div class="col-md-10">
                    <center>
                        <h2>SLTB UDUDUMBARA DEPOT</h2>
                    </center>
                    <center>
                        <h4>ONLINE TICKET RESERVATION</h4>
                    </center>
                </div>
            </div>
            <br>
        </div>
        <div class="card-body">
            <div class=" row mt-2">
                <div class="col-md-1"></div>
                <div class="col-md-6">
                    <label class="form-label" style="font-weight: 100;font-size:20px;"><b>Reference No. </b> <span id="refNo">ABC-225566</span></label>
                </div>
                <div class="col-md-2"></div>
            </div>
            <hr>
            <div class="row mt-2">
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <label for="bus">Bus No :</label> <br>
                    <label for="rt">Route : </label> <br>
                    <label for="time">Time Start -> End :</label> <br><br>

                    <label for="from">Departure : </label> <br>
                    <label for="to">Arrival : </label> <br>
                    <label for="date">Date :</label>
                </div>
                <div class="col-md-4">
                    <b><span id="busNum1"> xxx</span></b> <br>
                    <b> <span id="rt1"> blah </span></b> <br>
                    <b><span id="time1"> tata </span> </b><br><br>

                    <b><span id="from1"> xxx</span></b> <br>
                    <b><span id="to1"> yyy</span></b><br>
                    <b><span id="date1"> 2022-03-05</span></b>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <label for="bus">Fare Tot. :</label> <br>
                </div>
                <div class="col-md-4">
                    <b><span id="totFare1"> xxx</span></b> <br>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <label class="form-label">Seat Numbers :</label>
                </div>
                <div class="col-md-5">
                    <div id="spinner"></div>
                    <div style="display:none" id="innerTable">
                        <table id="seatNumbersTable" class="table table-striped table-bordered">
                            <thead></thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <label for="nic">NIC Number : </label> <br>
                    <label for="mobile">Mobile No. : </label><br>
                    <label for="issue">Issued Date : </label><br>
                </div>
                <div class="col-md-4">
                    <b><span id="nic"> 2022-03-05</span></b> <br>
                    <b><span id="mobile"> 2022-03-05</span></b> <br>
                    <b><span id="issue"> 2022-03-05</span></b> <br>
                </div>
            </div>
        </div>
        <div class="card-footer ">
            <div class="row">
                <div class="col-md-8">
                    <small>
                        If you have any questions or concerns about your reservation,
                        please don't hesitate to contact us. We are always happy to assist you. <br><br>
                        Thank you for choosing our service!
                    </small>
                    <h4>Tel No: 0812492245</h4>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <a href="" class="btn btn-success btn-md pull-left no-print mb-2" title="print" onclick="window.print();">Print Your Invoice</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // alert($busNum);
        $("#busNum1").html($busNum);
        $("#rt1").html($from + " >> " + $to);
        $("#time1").html($dep + " >> " + $arr);
        $("#from1").html($boardingName);
        $("#to1").html($droppingName);
        $("#date1").html($date);
        $("#issue").html($tday);
        $("#refNo").html($refNo);
        $("#totFare1").html("Rs. " + $totPrice);
        // get rest of details
        $.ajax({
            url: "../routes/user/userDetails.php",
            method: "POST",
            data: {},
            dataType: "json",
            success: function(data) {
                $("#nic").html(data.nic);
                $("#mobile").html(data.mobileNum);
                // alert(selectedIds);
                // Retrieve the selectedIds array from wherever it is defined
                var Ids = selectedIds; // Replace with your actual array
                // alert(Ids.length);

                // Generate the HTML for the table headers based on the number of columns
                var tableHeaders = "";
                for (var i = 1; i <= Ids.length; i++) {
                    tableHeaders += "<th> S.N. </th>";
                }

                // Generate the HTML for the table rows using the selectedIds array
                var tableRows = "<tr>";


                for (var j = 0; j < Ids.length; j++) {
                    tableRows += "<td> " + Ids[j] + "</td>";
                }


                tableRows += "</tr>";
                // Insert the generated table headers and rows into the table element
                $("#seatNumbersTable thead").html(tableHeaders);
                $("#seatNumbersTable tbody").html(tableRows);
            }
        });



    })
</script>