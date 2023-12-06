<?php
// include_once("../../include/admin_style.php");
?>

<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-3">
        <a href="#" id="changeSearch" class="btn btn-outline-primary changeSearch">Change Your Search..</a>
    </div>
    <div class="col-md-2"></div>
    <div class=" col-md-2 alert alert-danger" role="alert" id="errMsg">
        <span id="bus">Plese select a Trip! </span>
    </div>
    <div class=" col-md-2 alert alert-danger" role="alert" id="errMsg1">
        <span id="halt"> Plese select Boarding and Dropping halts!</span>
    </div>
    <div class=" col-md-2 alert alert-danger" role="alert" id="errMsg2">
        <span id="log"> Please log in to the system first..!</span>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-2"></div>
    <div class="card col-md-8">
        <h4 id="h5" class="card-header"> Bus Trip Info </h4>

        <div class="card-body">
            <p id="date" class="card-text"></p>
            <h6 id="title" class="card-title"></h6>
            <div id="getData"></div>

        </div>
        <div class="card-footer ">
            <div class="row" id="msg1"></div>
            <div class="row hltmsg"> Select your Boarding and Dropping Halt: </div>

            <div class="row mt-3 hltselect">
                <div class="col-md-2">
                    <select class="form-control cc2" name="boarding" id="boarding" required>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control cc2" name="dropping" id="dropping" required>
                    </select>
                </div>
                <center> <a href="#" class="btn btn-primary next">Next</a></center>
            </div>

        </div>
    </div>
    <div class="col-md-2"></div>
</div>



<script>
    $(document).ready(function() {
        $select = 0;
        $("#errMsg").hide();
        $("#errMsg1").hide();
        $("#errMsg2").hide();

        $("#h5").html($from + " <b> > </b>" + $to);
        $("#date").html("Date " + $date);
        $("#title").html("Select a Trip and proceed >>");

        $.ajax({
            url: "../routes/user/getTripData.php",
            method: "POST",
            data: {
                from: $from,
                to: $to,
                date: $date
            },
            success: function(data) {
                $("#getData").html(data);
            }
        });


        $(document).on("click", ".trow", function() {
            $select = 1;
            $trpId = $(this).attr("id");
            $(this).addClass('selected').siblings().removeClass('selected');

            // Get the available seats value
            $availSeats = parseInt($(this).find('td:nth-child(4)').text());

            if ($availSeats === 0) {
                $(this).addClass('disabled');
                $(".hltmsg").hide();
                $(".hltselect").hide();
                $("#msg1").html("<b><< No seats available for this trip. Please choose another trip. >></b>");
                return;
            }

            // check time exceeds
            $.ajax({
                url: "../routes/user/checkReserveTimeExceeds.php",
                method: "POST",
                data: {
                    trpId: $trpId,
                    date: $date,
                },
                success: function(data) {
                    if (data == 0) {
                        $(this).addClass('disabled');
                        $(".hltmsg").hide();
                        $(".hltselect").hide();
                        $("#msg1").html("<b><< Booking time has been exceeded. Please choose another trip. >></b>");
                        return;
                    }
                }
            });

            // Rest of your code for selecting the row
            $(".hltmsg").show();
            $(".hltselect").show();
            $busNum = $(this).find('td:nth-child(1)').text();
            $dep = $(this).find('td:nth-child(2)').text();
            $arr = $(this).find('td:nth-child(3)').text();
            $price = $(this).find('td:nth-child(5)').text();

            $("#msg1").html("<b> << Bus Selected >> </b>");
        });


        $.ajax({
            url: "../routes/user/getHaltsBoarding.php",
            method: "POST",
            data: {
                from: $from,
                to: $to
            },
            success: function(data) {
                $("#boarding").html(data);
            }
        });

        $.ajax({
            url: "../routes/user/getHaltsDropping.php",
            method: "POST",
            data: {
                from: $from,
                to: $to
            },
            success: function(data) {
                $("#dropping").html(data);
            }
        });

        $boarding = "";
        $dropping = "";

        $("#boarding").on("change", function() {
            $boarding = $(this).val();
            $boardingName = $(this).find('option:selected').text();
        });
        $("#dropping").on("change", function() {
            $dropping = $(this).val();
            $droppingName = $(this).find('option:selected').text();
        });

        $(document).on("click", ".next", function() {
            // $("#uRoot").load("user/seatPlan.php");
            if ($select == 1 && $boarding != "" && $dropping != "") {
                $.ajax({
                    url: "../routes/user/getLoginState.php",
                    method: "POST",
                    data: {},
                    success: function(data) {
                        if (data == 1) {
                            // alert($trpId);
                            $.ajax({
                                url: "../routes/user/getBusSeats.php",
                                method: "POST",
                                data: {
                                    trpId: $trpId,
                                },
                                success: function(data) {
                                    //    alert(data);
                                    if (data == 50) {
                                        $("#uRoot").load('user/seatPlan2.php');
                                    } else if (data == 54) {
                                        $("#uRoot").load('user/seatPlan.php');
                                    }
                                }
                            });

                            // var url = 'user/seatPlan.php';
                            // $("#uRoot").load(url);
                        } else {
                            $("#errMsg2").show();
                            setTimeout(function() {
                                $("#errMsg2").hide();
                            }, 3000);
                        }
                    }
                });
            } else if ($select == 0 && $boarding != "" && $dropping != "") {
                $("#errMsg2").hide();
                $("#errMsg1").hide();
                $("#errMsg").show();
                setTimeout(function() {
                    $("#errMsg").hide();
                }, 3000);
            } else if ($select == 0 && $boarding == "" && $dropping == "") {
                $("#errMsg2").hide();
                $("#errMsg1").hide();
                $("#errMsg").show();
                setTimeout(function() {
                    $("#errMsg").hide();
                }, 3000);
            } else if ($select == 1 && $boarding == "" && $dropping == "") {
                $("#errMsg1").show();
                $("#errMsg").hide();
                $("#errMsg2").hide();
                setTimeout(function() {
                    $("#errMsg1").hide();
                }, 3000);
            } else if ($select == 1 && $boarding != "" && $dropping == "") {
                $("#errMsg1").show();
                $("#errMsg").hide();
                $("#errMsg2").hide();
                setTimeout(function() {
                    $("#errMsg1").hide();
                }, 3000);
            } else if ($select == 1 && $boarding == "" && $dropping != "") {
                $("#errMsg1").show();
                $("#errMsg").hide();
                $("#errMsg2").hide();
                setTimeout(function() {
                    $("#errMsg1").hide();
                }, 3000);
            } else {
                $("#errMsg").show();
                $("#errMsg1").hide();
                $("#errMsg2").hide();
                setTimeout(function() {
                    $("#errMsg").hide();
                }, 3000);
            }
        });


    })
</script>