<?php
include_once("itemModal.php");
include_once("updateItem.php");
include_once("restockItemModal.php");
include_once("issueItemModal.php");
?>

<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Manage Items
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
            <div class="col-5"> </div>
            <div class="col-4">
                <button type="button" id="category" class="btn btn-outline-primary add_btn">Add New Item</button>
                <button type="button" id="category" class="btn btn-outline-info restockBtn">Restock Item</button>
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
            $("#modalLabel").html("Add New Item");
            $("#itmModal").modal('show');
        });
        // close modal
        $("#closeModal").click(function() {
            $("#itmModal").modal('hide');
        })
        // clear addnew btn modal
        $('#itmModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })


        $("#btn_addItem").click(function(e) {
            if (validateForm()) {
                // All fields have values entered
                // catch the values of the modal
                e.preventDefault();
                var form = $('#addNewItmForm')[0];
                var formData = new FormData(form);
                console.log(formData)

                $.ajax({
                    url: '../routes/stockKeeper/addItem.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data == 1) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Item added successfully!',
                                showConfirmButton: false,
                                timer: 2500
                            })
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Failed to add Item!',
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
                    },
                    error: function() {}
                });
                $("#itmModal").modal('hide');

            } else {
                // Show an error message or handle empty fields
                alert("Please fill in all the fields.");
            }
        });

        function validateForm() {
            var isValid = true;

            // Validate Part No.
            var partNo = $("#partNo").val().trim();
            if (!partNo.match(/^[\w-]+$/)) {
                isValid = false;
                $("#partNo").addClass("is-invalid");
            } else {
                $("#partNo").removeClass("is-invalid");
            }

            // Validate Description
            var description = $("#des").val().trim();
            if (description === "") {
                isValid = false;
                $("#des").addClass("is-invalid");
            } else {
                $("#des").removeClass("is-invalid");
            }

            // Validate Unit Type
            var unitType = $("#type").val();
            if (unitType === "") {
                isValid = false;
                $("#type").addClass("is-invalid");
            } else {
                $("#type").removeClass("is-invalid");
            }

            // Validate Unit of Issues
            var unitOfIssues = $("#unit").val().trim();
            if (!unitOfIssues.match(/^\d+$/)) {
                isValid = false;
                $("#unit").addClass("is-invalid");
            } else {
                $("#unit").removeClass("is-invalid");
            }

            // Validate Minimum Stock Level
            var minStockLevel = $("#level").val().trim();
            if (!minStockLevel.match(/^\d+$/)) {
                isValid = false;
                $("#level").addClass("is-invalid");
            } else {
                $("#level").removeClass("is-invalid");
            }

            return isValid;
        }


        //beginning of view data according to the selected page no
        function fetch_data(page) {
            $.ajax({
                url: "../routes/stockKeeper/viewItems.php",
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
        })


        // beginning of Search and show results
        function load_data(page, key = "") {
            $.ajax({
                url: "../routes/stockKeeper/searchItem.php",
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
            $partNo = $(this).attr("id");
            // pass to the route and get the data
            $.ajax({
                url: "../routes/stockKeeper/fetchItem.php",
                method: "POST",
                data: {
                    partNo: $partNo
                },
                dataType: "json",
                success: function(data) {
                    $('#uppartNo').val(data.partNo);
                    $("#updes").val(data.descrip);
                    $("#uptype").val(data.types);
                    $("#upunit").val(data.unit_issues);
                    $("#uplevel").val(data.stock_level);
                    $("#upcats").find("option:selected").text(data.category);
                    $('#uppartNom').val(data.partNo);
                    $("#updateItemModal").modal('show');
                }
            })
        })
        // close modal
        $("#upCloseModal").click(function() {
            $("#updateItemModal").modal('hide');
        })


        // update script
        $(document).on("click", "#btn_upItem", function(e) {
            e.preventDefault();
            var form = $("#upItmForm")[0];
            var formData = new FormData(form);
            console.log(formData);
            $.ajax({
                url: "../routes/stockKeeper/updateItem.php",
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
            $("#updateItemModal").modal('hide');
        })


        // delete button
        $(document).on("click", ".chkB", function() {
            $partNo = $(this).attr("id");
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
                        url: "../routes/stockKeeper/actDeactItem.php",
                        method: "POST",
                        data: {
                            partNo: $partNo
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

        //restock
        $(document).on("click", ".restockBtn", function() {
            $("#restockItemModal").modal('show');
        });
        // close modal
        $("#closeRskModal").click(function() {
            $("#restockItemModal").modal('hide');
        })
        // clear btn modal
        $('#restockItemModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        $("#btn_restockItem").click(function(e) {
            // catch the values of the modal
            e.preventDefault();
            var form = $('#restockItemForm')[0];
            var formData = new FormData(form);
            console.log(formData)

            $.ajax({
                url: '../routes/stockKeeper/restockItem.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Item restocked successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to restock Item!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                },
                error: function() {}
            });
            $("#restockItemModal").modal('hide');
        })


        $(document).on("click", ".issueBtn", function() {
            var prtNo = $(this).attr("id");
            $("#parts").val(prtNo);
            $("#issueItemModal").modal('show');
        });

        $("#closeIssueModal").click(function() {
            $("#issueItemModal").modal('hide');
        });

        $('#issueItemModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        });

        $("#btn_issueItem").click(function(e) {
            e.preventDefault();
            var form = $('#issueItemForm')[0];
            var formData = new FormData(form);
            var prtNo = $("#parts").val();
            formData.append('prtNo', prtNo);
            console.log(formData);
            $.ajax({
                url: '../routes/stockKeeper/issueItem.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: "Item issued successfully.",
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

            $("#issueItemModal").modal('hide');
        });



        // go back
        $(document).on("click", "#btn_back", function() {
            $("#SKroot").load('stockKeeper/chooseTask.php');
        })


    });
</script>