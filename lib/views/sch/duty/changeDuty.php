<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Change Duty &nbsp;&nbsp; <span class="did" id="<?php echo ($_GET['dId']); ?>"></span>
    </div>
    <div class="card-body">
        <!-- <div class="row">
            <div class="col-1">
                <a href="" class="btn btn-outline-success btn-md pull-left no-print mb-2" title="print" onclick="window.print();">Print</a>
            </div>
        </div> -->

        <div id="getData" class=" text-center">
            <div class="row">
                <div class="col-md-2">
                    <span><b>Prev. EmpId : </span></b>
                </div>
                <div class="col-md-3">
                    <input class="form-control" type="text" id="prevEmp" readonly>
                </div>
                <!-- <div class="col-md-1"></div> -->
                <div class="col-md-2">
                    <span><b>Prev. Bus No : </span></b>
                </div>
                <div class="col-md-3">
                    <input class="form-control" type="text" id="prevBus" readonly>
                </div>
            </div>
            <br><br>
            <div class="row mt-6">
                <div class="col-md-2">
                    <span><b>New EmpId : </span></b>
                    <br>only if needed*
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="newEmps">

                    </select>
                </div>
                <!-- <div class="col-md-1"></div> -->
                <div class="col-md-2">
                    <span><b>New Bus No : </span></b>
                    <br>only if needed*
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="buses">

                    </select>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary no-print" id="changeCurrDuty"> Change Duty </button>
            </div>
        </div>

    </div>
    <div class="card-footer no-print">
        <button class="btn btn-primary no-print" id="btn_back"> Back </button>
    </div>
</div>


<script>
    $(document).ready(function() {
        $did = $.trim($(".did").attr('id'));

        var newEmpId = "";
        var newBusNo = "";

        $.ajax({
            url: "../routes/duty/fetchDuty.php",
            method: "POST",
            data: {
                dId: $did,
            },
            dataType: "json",
            success: function(data) {
                $("#prevEmp").val(data.empId);
                $("#prevBus").val(data.busId);

                var prevEmp = $("#prevEmp").val();
                var prevBus = $("#prevBus").val();

                $("#buses").on("change", function(event) {
                    var newBus = $(this).val();
                    if (newBus) {
                        newBusNo = newBus;
                    }
                });

                $("#newEmps").on("change", function(event) {
                    var newEmp = $(this).val();
                    if (newEmp) {
                        newEmpId = newEmp;
                    }
                });

                if (newEmpId === "") {
                    newEmpId = prevEmp;
                }
                if (newBusNo === "") {
                    newBusNo = prevBus;
                }

                $(document).on("click", "#changeCurrDuty", function() {
                    // console.log(newEmpId);
                    // console.log(newBusNo);
                    $.ajax({
                        url: "../routes/duty/saveChangedDuty.php",
                        method: "POST",
                        data: {
                            dId: $did,
                            newEmpId: newEmpId,
                            newBusNo: newBusNo,
                        },
                        success: function(data) {
                            // console.log(data);
                            if (data == 1) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Duty changed successfully!',
                                    showConfirmButton: false,
                                    timer: 2500
                                })
                            } else {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Failed to change duty!',
                                    showConfirmButton: false,
                                    timer: 2500
                                })
                            }
                        }
                    })
                });
            }
        });


        $.ajax({
            url: "../routes/duty/getFreeEmps.php",
            method: "POST",
            data: {
                dId: $did,
            },
            success: function(data) {
                $("#newEmps").html(data);
            }
        })

        $.ajax({
            url: "../routes/duty/viewFreeBuses.php",
            method: "POST",
            data: {
                dId: $did,
            },
            success: function(data) {
                $("#buses").html(data);
            }
        });

        // go back
        $(document).on("click", "#btn_back", function() {
            $("#root").load('sch/duty/manageDuties.php');
        })

    })
</script>