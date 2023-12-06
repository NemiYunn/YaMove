<?php
include_once("addToolModal.php");
include_once("updateToolModal.php");
include_once("reFillToolModal.php");
include_once("issueToolModal.php");
?>

<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Manage Tools
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
                <button type="button" id="category" class="btn btn-outline-primary add_btn">Add New Item</button>
                <button type="button" id="category" class="btn btn-outline-success hist_btn">Issued History</button>
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

        // addNewCategory script
        $(document).on("click", ".add_btn", function() {
            // $('.c1').prop('disabled', false);
            // $("#modalLabel").html("Add New Item");
            $("#tlModal").modal('show');
        });
        // close modal
        $("#closeModal").click(function() {
            $("#tlModal").modal('hide');
        })
        // clear addnew btn modal
        $('#tlModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })


        $("#btn_addTool").click(function(e) {
            // catch the values of the modal
            e.preventDefault();
            var form = $('#addNewToolForm')[0];
            var formData = new FormData(form);
            console.log(formData)

            $.ajax({
                url: '../routes/toolKeeper/addTool.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Tool added successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to add Tool!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                },
                error: function() {}
            });
            $("#tlModal").modal('hide');
        });


        //beginning of view data according to the selected page no
        function fetch_data(page) {
            $.ajax({
                url: "../routes/toolKeeper/viewTools.php",
                method: "POST",
                data: {
                    page: page
                },
                success: function(data) {
                    $("#get_datam").html(data);
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
                url: "../routes/toolKeeper/searchTool.php",
                method: "POST",
                data: {
                    page: page,
                    key: key
                },
                success: function(data) {
                    $("#get_datam").html(data);
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


        // fetch and show(update)
        $(document).on("click", ".edit_btn", function() {
            $Id = $(this).attr("id");
            // pass to the route and get the data
            $.ajax({
                url: "../routes/toolKeeper/fetchTool.php",
                method: "POST",
                data: {
                    Id: $Id
                },
                dataType: "json",
                success: function(data) {
                    $('#id').val(data.Id);
                    $("#Uname").val(data.Name);
                    $("#Udes").val(data.Des);
                    $("#Uqty").val(data.Qty);
                    $("#updateToolModal").modal('show');
                }
            })
        })
        // close modal
        $("#upCloseModal").click(function() {
            $("#updateToolModal").modal('hide');
        })


        // update script
        $(document).on("click", "#btn_upTool", function(e) {
            e.preventDefault();
            var form = $("#upToolForm")[0];
            var formData = new FormData(form);
            console.log(formData);
            $.ajax({
                url: "../routes/toolKeeper/updateTool.php",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Item updated successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to update Item!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                }
            })
            $("#updateToolModal").modal('hide');
        });


        // delete button
        $(document).on("click", ".chkT", function() {
            $Id = $(this).attr("id");
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
                        url: "../routes/toolKeeper/actDeactTool.php",
                        method: "POST",
                        data: {
                            Id: $Id
                        },
                        success: function(data) {
                            if (data == 1) {
                                Swal.fire(
                                    '',
                                    'Status changed successfully!',
                                    'success'
                                )
                            }
                        }
                    });
                }
            })
        });


        $(document).on("click", ".issue_btn", function() {
            var tlId = $(this).attr("id");
            $("#tlId").val(tlId); // Set the value of the input field
            $("#issueTlModal").modal('show');
        });

        $("#closeIssueModal").click(function() {
            $("#issueTlModal").modal('hide');
        });

        $('#issueTlModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        });

        $("#btn_issueTool").click(function(e) {
            e.preventDefault();
            var form = $('#issueToolForm')[0];
            var formData = new FormData(form);
            console.log(formData);
            $.ajax({
                url: '../routes/toolKeeper/issueTool.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: "Tool issued successfully.",
                            showConfirmButton: false,
                            timer: 3500
                        });
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: "Please try with lower quantity.",
                            showConfirmButton: false,
                            // timer: 10500
                        });
                    }
                },
                error: function() {
                    // Error handling code
                }
            });

            $("#issueTlModal").modal('hide');
        });


         //refill
         $(document).on("click", ".fill_btn", function() {
            var tlId = $(this).attr("id");
            $("#rtlId").val(tlId); // Set the value of the input field
            $("#fillTlModal").modal('show');
        });
        // close modal
        $("#closeFillModal").click(function() {
            $("#fillTlModal").modal('hide');
        })
        // clear btn modal
        $('#fillTlModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        $("#btn_fillTool").click(function(e) {
            // catch the values of the modal
            e.preventDefault();
            var form = $('#fillToolForm')[0];
            var formData = new FormData(form);
            console.log(formData)

            $.ajax({
                url: '../routes/toolKeeper/fillTool.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Tool Filled successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to refill Item!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                },
                error: function() {}
            });
            $("#fillTlModal").modal('hide');
        })

        $(document).on("click", ".hist_btn", function() {
            $("#TKroot").load('toolKeeper/issueHistory.php');
        })

        // go back
        $(document).on("click", "#btn_back", function() {
            $("#TKroot").load('toolKeeper/chooseTask.php');
        })





    });
</script>