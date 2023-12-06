<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Manage Duties
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
            <div class="col-6"> </div>
            <div class="col-3">
                <button type="button" id="viewChangeDuties" class="btn btn-outline-success view_btn">View Changed Duties</button>
            </div>
        </div>
        <div id="get_datam" class=" text-center">

        </div>
        <br><br>
        <div class="row">
            <div class="col-md-9">
                <button class="btn btn-primary no-print" id="btn_back" style="position:absolute; left:10px;bottom:10px;"> Back </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        function fetch_data(page) {
            $.ajax({
                url: "../routes/duty/viewDuties.php",
                method: "POST",
                data: {
                    page: page
                },
                success: function(data) {
                    // Update HTML element with received data
                    $("#get_datam").html(data);

                    $.ajax({
                        url: "../routes/duty/getAttendance.php",
                        method: "POST",
                        dataType: "json",
                        data: {},
                        success: function(data) {
                            // Iterate over rows in dutyT table
                            $('#dutyT tr, #dutyT tr:not(:first-child)').each(function() {
                                var empId = $(this).find('td:nth-child(2)').text().trim(); // Trim leading/trailing white spaces

                                // Check if empId matches any value in the array
                                if (data.some(item => item.empId.trim() === empId)) {
                                    $(this).css('background-color', '');
                                } else {
                                    $(this).find('td:nth-child(2)').css('background-color', 'red');
                                    $(this).find('td:nth-child(5) button').removeClass('btn-outline-primary').addClass('btn-outline-danger');
                                    $('#dutyT thead tr').css('border-color', '');
                                }
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log("Error: " + textStatus, errorThrown);
                        }
                    });

                    $.ajax({
                        url: "../routes/bus/getCurrentStatus.php",
                        method: "POST",
                        dataType: "json",
                        data: {},
                        success: function(busData) {
                            console.log(busData);

                            // Create an array of busIds from the busData
                            var busIds = busData.map(item => item.busNo && item.busNo.trim()).filter(Boolean);

                            // Iterate over rows in dutyT table
                            $('#dutyT tr, #dutyT tr:not(:first-child)').each(function() {
                                var busId = $(this).find('td:nth-child(4)').text().trim(); // Trim leading white spaces

                                // Check if busId exists in the busIds array
                                if (busIds.includes(busId)) {
                                    // Match found for busId
                                    // $(this).css('background-color', 'green');
                                    console.log("Match found for busNo: " + busId);
                                } else {
                                    // No match found for busId
                                    $(this).find('td:nth-child(4)').css('background-color', 'red');
                                    $(this).find('td:nth-child(5) button').removeClass('btn-outline-primary').addClass('btn-outline-danger');
                                    console.log("Not found for busNo: " + busId);
                                    $('#dutyT thead tr').css('border-color', '');
                                }
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log("Error: " + textStatus, errorThrown);
                        }
                    });



                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Error: " + textStatus, errorThrown);
                }
            });
        }

        fetch_data();

        $(document).on("click", ".page-item", function() {
            var page = $(this).attr("id");
            fetch_data(page);
        });

        // beginning of Search and show results
        function load_data(page, key = "") {
            $.ajax({
                url: "../routes/duty/searchDuties.php",
                method: "POST",
                data: {
                    page: page,
                    key: key
                },
                success: function(data) {
                    $("#get_datam").html(data);

                    // check attendance
                    $.ajax({
                        url: "../routes/duty/getAttendance.php",
                        method: "POST",
                        dataType: "json",
                        data: {},
                        success: function(data) {
                            // console.log(data);

                            $('#dutyT tr, #dutyT tr:not(:first-child)').each(function() {
                                var empId = $(this).find('td:nth-child(2)').text().trim(); // Trim leading/trailing white spaces

                                // Check if empId matches any value in the array
                                if (data.some(item => item.empId.trim() === empId)) {
                                    // $(this).css('background-color', 'green'); // Apply green background color to the row
                                    // console.log("Match found for empId: " + empId);
                                } else {
                                    $(this).find('td:nth-child(2)').css('background-color', 'red');
                                    $(this).find('td:nth-child(5) button').removeClass('btn-outline-primary').addClass('btn-outline-danger');
                                    // console.log("arrayOfValues: ", data);
                                    $('#dutyT thead tr').css('border-color', '');
                                }
                            });
                        }
                    });

                    $.ajax({
                        url: "../routes/bus/getCurrentStatus.php",
                        method: "POST",
                        dataType: "json",
                        data: {},
                        success: function(data) {
                            console.log(data);

                            $('#dutyT tr, #dutyT tr:not(:first-child)').each(function() {
                                var busId = $(this).find('td:nth-child(4)').text().trim(); // Trim leading white spaces

                                if (Array.isArray(data) && data.some(itm => itm.busId && itm.busId.trim() === busId)) {
                                    // $(this).css('background-color', 'green'); // Apply green background color to the row
                                    // console.log("Match found for busId: " + busId);
                                } else {
                                    $(this).find('td:nth-child(4)').css('background-color', 'red');
                                    $(this).find('td:nth-child(5) button').removeClass('btn-outline-primary').addClass('btn-outline-danger');
                                    // console.log("Not found for busId: " + busId);
                                    $('#dutyT thead tr').css('border-color', '');
                                }
                            });
                        }
                    });


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

        // if curr_duty table status =0(after change done), botton for 
        //that perticular id should be green and Changed


        $(document).on("click", ".change-btn", function() {
            let value = $(this).attr('id');
            $("#root").load('sch/duty/changeDuty.php?dId=' + value);
        });

        // view changed duties
        $(document).on("click", "#viewChangeDuties", function() {
            $("#root").load('sch/duty/viewChangedDuties.php');
        });

        // go back
        $(document).on("click", "#btn_back", function() {
            $("#root").load('sch/chooseScheduleTask.php');
        })

    });
</script>