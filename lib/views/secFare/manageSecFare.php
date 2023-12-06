<?php
include_once("secFareModal.php");
include_once("secFareUpdateModal.php");
?>

<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Manage Section Fare
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
            <div class="col-4">

            </div>
            <div class="col-5">
                <button type="button" id="btn_add" class="btn btn-outline-primary add_secF_btn">Add New Section</button>
                <button type="button" id="btn_update" class="btn btn-outline-info update_secF_btn">Update Section Fare</button>
            </div>
        </div>
        <div id="get_data" class="table-responsive-md text-center">
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // addNewTrip script
        $(document).on("click", ".add_secF_btn", function() {
            $("#secFModal").modal('show');
        });
        // close modal
        $("#closeModal").click(function() {
            $("#secFModal").modal('hide');
        })
        // clear addnew btn modal
        $('#secFModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        $("#btn_addSecF").click(function(e) {
            // catch the values of the modal
            e.preventDefault();
            var form = $('#addNewSecForm')[0];
            var formData = new FormData(form);
            console.log(formData)
            // pass the value to the route
            $.ajax({
                url: '../routes/secFare/addSection.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    alert(data);
                },
                error: function() {}
            });
            $("#secFModal").modal('hide');
        })

        //beginning of view section data according to the selected page no
        function fetch_data(page) {
            $.ajax({
                url: "../routes/secFare/viewSections.php",
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
                url: "../routes/secFare/searchSectionsData.php",
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

        
        // update script
        $(document).on("click", ".update_secF_btn", function() {
            $("#secFUpModal").modal('show');
        });
        // close modal
        $("#closeUpModal").click(function() {
            $("#secFUpModal").modal('hide');
        })
        $('#secFUpModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        $("#btn_upSecF").click(function(e) {
            // catch the values of the modal
            e.preventDefault();
            var form = $('#updateSecFareForm')[0];
            var formData = new FormData(form);
            console.log(formData)
            // pass the value to the route
            $.ajax({
                url: '../routes/secFare/updateSectionFare.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    alert(data);
                },
                error: function() {}
            });
            $("#secFUpModal").modal('hide');
        })
        
        $(document).on("click", "#btn_back", function() {
            $("#root").load('sch/chooseScheduleTask.php');
        })

    })
</script>