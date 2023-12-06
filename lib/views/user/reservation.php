<div class="row mt-3 no-print">
    <div class="col-md-2"></div>
    <div class="card col-md-4">
        <h3 id="h5" class="card-header" style="background-color:CornflowerBlue ; text-align:center"> Journey Summary </h3>
        <div class="card-body">
            <div class="row">
                <label for="rt">Route : &nbsp;&nbsp; <b> <span id="rt"> blah </span></b> </label>
                <label for="time">Time Start -> End : &nbsp;&nbsp; <b><span id="time"> tata </span> </b></label>
            </div>
            <div class="row">
                <label for="bus">Bus No : &nbsp;&nbsp; <b><span id="busNum"> xxx</span></b> </label>

                <label for="from">Departure : &nbsp;&nbsp; <b><span id="from"> xxx</span></b> </label>

                <label for="to">Arrival : &nbsp;&nbsp; <b><span id="to"> </span></b> </label>

                <label for="date">Date : &nbsp;&nbsp; <b><span id="date"> </span></b> </label>

                <label for="to">No of Passengers : &nbsp;&nbsp; <b> <span id="pas"> </span> </b> </label>

                <label for="price">Price <label style="background-color: blue; color:aliceblue">One Person </label> : &nbsp;&nbsp;<b> <span id="price"> </span> </b></label>

            </div>
        </div>
        <div class="card-footer " style="background-color:brown; color:aliceblue; text-align:right">
            <b>
                <label for="totPrice">Total Price - LKR : &nbsp;&nbsp; <span id="totPrice"> </span> </label>
            </b>
            <br>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
<br>
<div class="row no-print">
    <div class="col-md-2"></div>
    <div class=" col-md-5 alert alert-success no-print" role="alert" id="sucMsg">
        <span>Your transaction was successful..! </span>
    </div>
</div>
<br>
<div class="row" id="payment">
    <div class="col-md-2"></div>
    <div class="card col-md-8" id="selectMethod">
        <!-- <h3 id="h5" class="card-header" style="background-color: blue; text-align:center"> Journey Summary </h3> -->
        <div class="card-header ">
            <!-- <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                <label class="form-check-label" for="inlineCheckbox1"><b>Terms & Conditions</b></label>
            </div> -->
        </div>
        <div class="card-body">
            <h6>Payment Method</h6>
            <i class="fa fa-credit-card" aria-hidden="true"></i> Please Select Payment Method
            <br><br>
            <!-- <div class="form-check"> -->
            <input class="form-check-input" type="radio" name="radioPay" id="radioPay">
            <img src="../images/visa.png" alt="visa" style="width:40px; height:40px">
            <!-- </div> -->
            &nbsp;&nbsp;&nbsp;
            <!-- <div class="form-check"> -->
            <input class="form-check-input" type="radio" name="radioPay" id="radioPay">
            <img src="../images/mcard.png" alt="mcard" style="width:40px; height:40px">
            <!-- </div> -->
        </div>

    </div>
</div>




<script>
    $(document).ready(function() {

        // if(("#inlineCheckbox1").checked == true){
        //     alert(1);
        // }
        $("#sucMsg").hide();


        $("#rt").html($from + " >> " + $to);
        $("#time").html($dep + " >> " + $arr);
        $("#busNum").html($busNum);
        $("#from").html($boardingName);
        $("#to").html($droppingName);
        $("#date").html($date);
        $("#pas").html($noOfSeats);

        // $totPrice = 0;
        $refNo = '';
        $.ajax({
            url: "../routes/user/getFare.php",
            method: "POST",
            data: {
                boarding: $boarding,
                dropping: $dropping,
                NoofPassengers: $noOfSeats,
            },
            success: function(data) {
                $("#totPrice").html(data);
                $totPrice = data;
            }
        });

        $.ajax({
            url: "../routes/user/getOnePersonFare.php",
            method: "POST",
            data: {
                boarding: $boarding,
                dropping: $dropping,
                NoofPassengers: $noOfSeats,
            },
            success: function(data) {
                $("#price").html(data);
            }
        });

        $(document).on("click", "#radioPay", function() {
            $("#payment").load("user/cardDetails.php");
        });

        // paynow button and validation 
        $(document).on("click", ".pay", function() {

            if ($exM != "" && $exY != "" && $cardNo != "" && $cardHName != "" && $cardSec != "") {
                $("#sucMsg").show();
                setTimeout(function() {
                    $("#sucMsg").hide();
                }, 20000);

                var selIds = JSON.stringify(selectedIds);
                $.ajax({
                    url: "../routes/user/makeReservation.php",
                    method: "POST",
                    data: {
                        trpId: $trpId,
                        resDate: $date,
                        NoofPassengers: $noOfSeats,
                        totFare: $totPrice,
                        seatArray: selIds,
                    },
                    success: function(data) {
                        // load invoice
                        $refNo = data;
                        $("#payment").load("user/invoice.php");
                        
                        // pass data to send email
                        $.ajax({
                            url: "../routes/user/reservationMail.php",
                            method: "POST",
                            data: {
                                trpId: $trpId,
                                from: $from,
                                to: $to,
                                boarding: $boarding,
                                dropping: $dropping,
                                resDate: $date,
                                NoofPassengers: $noOfSeats,
                                totFare: $totPrice,
                                seatArray: selIds,
                                refNo: $refNo,
                                busNo: $busNum,
                                dep: $dep,
                                arr: $arr,
                            },
                            success: function(data) {
                                setTimeout(function() {
                                    $('#spinner').hide();
                                    $('#innerTable').show();
                                }, 2000);
                                if (data == 1) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Email has been sent with your booking details!',
                                        showConfirmButton: false,
                                        timer: 5000
                                    })
                                } else {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'Failed to send email!',
                                        showConfirmButton: false,
                                        timer: 2500
                                    })
                                }

                            },
                            error: function(xhr, status, error) {
                                console.log(error); // Handle any error that occurred
                            }
                        });

                    }
                });
            } else {
                // Show validation messages
                if (!$exM) $("#exMonthV").show();
                if (!$exY) $("#exYearV").show();
                if (!$cardNo) $("#cardNoVal").show();
                if (!$cardHName) $("#cardHNameV").show();
                if (!$cardSec) $("#cardSecV").show();
            }
        });
    });
</script>