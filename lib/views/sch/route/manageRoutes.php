<?php
include_once("routeModal.php");
include_once("updateRoute.php");
// include_once("changeState.php");
?>

<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Manage Routes
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
                <button type="button" id="btn_update" class="btn btn-outline-primary add_btn">Add New Route</button>
            </div>
        </div>
        <div id="get_data" class="table-responsive-md text-center">
        <!-- <input type="checkbox" class="form-check-input" name="toggleActive" id="toggleActive" role="switch" checked> -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        //beginning of view route data according to the selected page no
        function fetch_data(page) {
            $.ajax({
                url: "../routes/route/viewRoutes.php",
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
                url: "../routes/route/searchRouteData.php",
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

        // addNewRoute script
        $(document).on("click", ".add_btn", function() {
            // $('.c1').prop('disabled', false);
            $("#modalLabel").html("Add New Route");
            $("#routeModal").modal('show');
        });
        // close modal
        $("#closeModal").click(function() {
            $("#routeModal").modal('hide');
        })
        // clear addnew btn modal
        $('#routeModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        $("#btn_addRoute").click(function(e) {
            // catch the values of the modal
            e.preventDefault();
            var form = $('#addNewRouteForm')[0];
            var formData = new FormData(form);
            console.log(formData)
            // pass the value to the route
            $.ajax({
                url: '../routes/route/addRoute.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == 1) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Route added successfully!',
                                showConfirmButton: false,
                                timer: 2500
                            })
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Failed to add route!',
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
                },
                error: function() {}
            });
            $("#routeModal").modal('hide');
        })

         // fetch and show(update)
         $(document).on("click", ".edit_btn", function() {
            $rtId = $(this).attr("id");
            // pass to the route and get the data
            $.ajax({
                url: "../routes/route/fetchRoute.php",
                method: "POST",
                data: {
                    rtId: $rtId
                },
                dataType: "json",
                success: function(data) {
                    $("#rtUpId").val(data.rtId);
                    $("#rtUpNo").val(data.rtNo);
                    $("#rtUpStarts").val(data.rtStarts);
                    $("#rtUpEnds").val(data.rtEnds);
                    $("#rtUpDes").val(data.rtDes);

                    $("#upRouteModal").modal('show');
                    var label = data.rtId;
                    $("#upModalLabel").html(label);
                }
            })
        })
        // close modal
        $("#upCloseModal").click(function() {
            $("#upRouteModal").modal('hide');
        })
        // update script
        $(document).on("click", "#btn_updateRoute", function(e) {
            e.preventDefault();
            var form = $("#updateRouteForm")[0];
            var formData = new FormData(form);
            console.log(formData);
            $.ajax({
                url: "../routes/route/updateRouteData.php",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                    alert(data);
                }
            })
            $("#upRouteModal").modal('hide');

        })

        // delete button
        $(document).on("click", ".chk", function() {
            $rtId = $(this).attr("id");
           
            
            // $("#deleteBus").modal('show');
           if(confirm("Are you sure you want to change the status of route?") == true){
            $.ajax({
                url: "../routes/route/actDeactRoute.php",
                method: "POST",
                data: {
                    rtId: $rtId
                },
                success: function(data) {
                    alert(data);
                }
            });
           }   
        })

        $(document).on("click", ".manage_btn", function() {
            let value = $(this).attr('id');
            $("#root").load('sch/route/manageHalts.php?rtId=' + value);
        });

        $(document).on("click", "#btn_back", function() {
            $("#root").load('sch/chooseScheduleTask.php');
        })

    });
</script>