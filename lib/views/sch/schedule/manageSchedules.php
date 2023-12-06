<?php
include_once("scheduleModal.php");
include_once("updateSchedule.php");
?>

<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Manage Schedules
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-1">
                <a href="" class="btn btn-outline-success btn-md pull-left no-print mb-2" title="print" onclick="window.print();">Print</a>
            </div>
        </div>
        <div class="row no-print mb-3">
            <div class="col-3">
                <!-- <label for="search" class="vissually-hidden">Search</label> -->
                <input type="search" class="form-control " id="searchValue" placeholder="Search">
            </div>
            <div class="col-7">

            </div>
            <div class="col-2">
                <button type="button" id="btn_update" class="btn btn-outline-primary add_sch_btn">Add New Schedule</button>
            </div>
        </div>
        <div id="get_data" class="table-responsive-md text-center">
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        
        $.ajax({
            url: "../routes/sched/viewRtNo.php",
            method: "POST",
            success: function(data) {
                $("#rtNoV").html(data);
            }
        });

        $.ajax({
            url: "../routes/sched/viewBusNo.php",
            method: "POST",
            success: function(data) {
                $("#busNoV").html(data);
            }
        });
        
        $.ajax({
            url: "../routes/sched/viewBusNo.php",
            method: "POST",
            success: function(data) {
                $("#busUpNoV").html(data);
            }
        });

        // addNewSchedule script
        $(document).on("click", ".add_sch_btn", function() {
            $("#schModal").modal('show');
        });
        // close modal
        $("#closeModal").click(function() {
            $("#schModal").modal('hide');
        })
        // clear addnew btn modal
        $('#schModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        $("#btn_addSchedule").click(function(e) {
            // catch the values of the modal
            e.preventDefault();
            var form = $('#addNewScheduleForm')[0];
            var formData = new FormData(form);
            console.log(formData)
            // pass the value to the route
            $.ajax({
                url: '../routes/sched/addSchedule.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    alert(data);
                },
                error: function() {}
            });
            $("#schModal").modal('hide');
        })

         //beginning of view schedule data according to the selected page no
         function fetch_data(page) {
            $.ajax({
                url: "../routes/sched/viewSchedules.php",
                method: "POST",
                data: {
                    page: page
                },
                success: function(data) {
                    $("#get_data").html(data);
                }
            });
        }
        fetch_data();
        $(document).on("click", ".page-item", function() {
            var page = $(this).attr("id");
            fetch_data(page);
        })

        // beginning of Search and show results
        function load_data(page, key = "") {
            $.ajax({
                url: "../routes/sched/searchSchedulesData.php",
                method: "POST",
                data: {
                    page: page,
                    key: key
                },
                success: function(data) {
                    $("#get_data").html(data);
                }
            });
        }
        // TO pass the key and first page (show first page results)
        $("#searchValue").on('input', function() {
            var key = $(this).val();
            load_data(1, key);
        });
        // To pass the selected page value and key(show result according to the page)
        $(document).on("click", ".page-items", function() {
            var page = $(this).attr("id");
            var key = $("#searchValue").val();
            load_data(page, key);
        });
        
        // fetch and show on update
        $(document).on("click", ".edit_btn", function() {
            $schId = $(this).attr("id");
            // pass to the route and get the data
            $.ajax({
                url: "../routes/sched/fetchSchedule.php",
                method: "POST",
                data: {
                    schId: $schId
                },
                dataType: "json",
                success: function(data) {
                    $("#upSchId").val(data.schId);
                    $("#rtUpNo").val(data.rtNo);
                    $("#schUpNo").val(data.schNo);
                    // if(data.busNo == "NULL"){
                    //     $("#busUpNoV").val("not selected");
                    // }else{
                    //     $("#busUpNoV").val(data.busNo);
                    // }
                    $("#busUpNoV").find("option:selected").text(data.busNo);
                    $("#stTimeUp").val(data.startTime);
                    $("#endTimeUp").val(data.endTime);
                    $("#ntStayUp").val(data.nightStay);

                    $("#upSchModal").modal('show');
                    var label = data.schId;
                    $("#modalUpLabel").html(label);
                }
            })
        })
        // close modal
        $("#upCloseModal").click(function() {
            $("#upSchModal").modal('hide');
        })

        // update script
        $(document).on("click", "#btn_upSchedule", function(e) {
            e.preventDefault();
            var form = $("#updateScheduleForm")[0];
            var formData = new FormData(form);
            console.log(formData);
            $.ajax({
                url: "../routes/sched/updateSchedule.php",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                    alert(data);
                }
            })
            $("#upSchModal").modal('hide');
        })

        // act deact
        $(document).on("click", ".chkS", function() {
            $schId = $(this).attr("id");
            // var rtId = $("#rtId").val();
            // alert($empId);
            if (confirm("Do you want to change the status of the schedule? ")) {
                $.ajax({
                    url: "../routes/sched/actDeactSchedule.php",
                    method: "POST",
                    data: {
                        schId: $schId,
                        // rtId: rtId
                    },
                    success: function(data) {
                        alert(data);
                    }
                })
            }
        })


        $(document).on("click", "#btn_back", function() {
            $("#root").load('sch/chooseScheduleTask.php');
        })

        $(document).on("click", ".manage_btn", function() {
            let value = $(this).attr('id');
            $("#root").load('sch/schedule/manageTrips.php?schNo=' + value);
        });

    });
</script>