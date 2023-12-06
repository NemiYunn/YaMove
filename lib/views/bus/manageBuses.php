<?php

include_once("busModal.php");
include_once("updateBus.php");
include_once("changeState.php");

?>


<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Manage Buses
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
                <button type="button" id="btn_update" class="btn btn-outline-primary add_btn">Add New Bus</button>
            </div>
        </div>
        <div id="get_data" class="table-responsive-md text-center">

        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        //beginning of view bus data according to the selected page no
        function fetch_data(page) {
            $.ajax({
                url: "../routes/bus/viewBuses.php",
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
        // end of view script



        // beginning of Search and show results
        function load_data(page, key = "") {
            $.ajax({
                url: "../routes/bus/searchBusData.php",
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
        // end of search script


        // addNewBus script
        $(document).on("click", ".add_btn", function() {
            $('.c1').prop('disabled', false);
            $("#modalLabel").html("Add new Bus");
            $("#busModal").modal('show');
        });
        // close modal
        $("#closeModal").click(function() {
            $("#busModal").modal('hide');
        })
        // clear addnew btn modal
        $('#busModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        // addbus(send data)
        $("#btn_addBus").click(function(e) {
            // catch the values of the modal
            e.preventDefault();
            var form = $('#addNewBusForm')[0];
            var formData = new FormData(form);
            // pass the value to the route
            $.ajax({
                url: '../routes/bus/addNewBus.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    // alert(data);
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Bus added successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to add bus!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                },
                error: function() {}
            });
            $("#busModal").modal('hide');
            // not working below

        })
        // end of addNewBus script


        // view particular bus details
        function viewTheBus($busId) {
            // pass to the route and get the data
            $.ajax({
                url: "../routes/bus/fetchBus.php",
                method: "POST",
                data: {
                    busId: $busId
                },
                dataType: "json",
                success: function(data) {
                    $("#busNo").val(data.busNo);
                    $("#busType").val(data.busType);
                    $("#busGrade").val(data.busGrade);
                    $("#busCatag").val(data.busCatag);
                    $("#busSeats").val(data.busSeats);
                    $("#busKms").val(data.busKms);
                    $("#busState").val(data.busState);

                    $("#busModal").modal('show');
                    var label = data.busId;
                    $("#modalLabel").html(label);
                }
            })
        }
        $(document).on("click", ".view_btn", function() {
            $busId = $(this).attr("id");
            viewTheBus($busId);
            $('.c1').prop('disabled', true);
            $("#btn_addBus").hide();
        })
        // end of view bus


        // fetch and show(update)
        $(document).on("click", ".edit_btn", function() {
            $busId = $(this).attr("id");
            // pass to the route and get the data
            $.ajax({
                url: "../routes/bus/fetchBus.php",
                method: "POST",
                data: {
                    busId: $busId
                },
                dataType: "json",
                success: function(data) {
                    $("#upBusId").val(data.busId);
                    $("#upBusNo").val(data.busNo);
                    $("#upBusType").val(data.busType);
                    $("#upBusGrade").val(data.busGrade);
                    $("#upBusCategory").val(data.busCatag);
                    $("#upBusSeats").val(data.busSeats);
                    $("#upBusKms").val(data.busKms);
                    $("#upBusState").val(data.busState);
                   

                    $("#updateBusModal").modal('show');
                }
            })
        })
        // close modal
        $("#upCloseModal").click(function() {
            $("#updateBusModal").modal('hide');
        })
        // update script
        $(document).on("click", "#btn_updateBus", function(e) {
            e.preventDefault();
            var form = $("#updateBusForm")[0];
            var formData = new FormData(form);
            // console.log(formData);
            $.ajax({
                url: "../routes/bus/updateBusData.php",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Bus updated successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to update bus!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                }
            })
            $("#updateBusModal").modal('hide');
        })

        // delete button
        $(document).on("click", ".chkB", function() {
            $busId = $(this).attr("id");
            // $("#deleteBus").modal('show');
            Swal.fire({
                title: 'Are you sure?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change status!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "../routes/bus/actDeactBus.php",
                        method: "POST",
                        data: {
                            busId: $busId
                        },
                        success: function(data) {
                            Swal.fire(
                                '',
                                'Status changed successfully!',
                                'success'
                            )
                        }
                    });
                }
            })
        })

        // change state button
        $(document).on("click", ".state_btn", function() {
            $busId = $(this).attr("id");
            $("#updateBusState").modal('show');
            // pass the value of state button
            $(document).on("click", ".s1", function() {
                $value = $(this).attr("id");
                // alert($value);
                $.ajax({
                    url: "../routes/bus/changeBusState.php",
                    method: "POST",
                    data: {
                        busId: $busId,
                        value: $value
                    },
                    success: function(data) {
                        if (data == 0) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Bus state changed successfully!',
                                showConfirmButton: false,
                                timer: 2500
                            })
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Failed to change bus state!',
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
                    }
                });
                $("#updateBusState").modal('hide');
            })

        });
        // close modal
        $("#closeStateModal").click(function() {
            $("#updateBusState").modal('hide');
        })
    });
</script>