<?php
include_once("catModal.php");
include_once("updateCat.php");
// include_once("changeState.php");
?>

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
                <button type="button" id="category" class="btn btn-outline-primary add_btn">Add New Category</button>
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
            $("#modalLabel").html("Add New Category");
            $("#catModal").modal('show');
        });
        // close modal
        $("#closeModal").click(function() {
            $("#catModal").modal('hide');
        })
        // clear addnew btn modal
        $('#catModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        $("#btn_addCat").click(function(e) {
            // catch the values of the modal
            e.preventDefault();
            var form = $('#addNewCatForm')[0];
            var formData = new FormData(form);
            console.log(formData)
            
            $.ajax({
                url: '../routes/stockKeeper/addCategory.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Category added successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to add Category!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                },
                error: function() {}
            });
            $("#catModal").modal('hide');
        })

        //beginning of view data according to the selected page no
        function fetch_data(page) {
            $.ajax({
                url: "../routes/stockKeeper/viewCategories.php",
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
                url: "../routes/stockKeeper/searchCatData.php",
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
            $catNo = $(this).attr("id");
            // pass to the route and get the data
            $.ajax({
                url: "../routes/stockKeeper/fetchCat.php",
                method: "POST",
                data: {
                    catNo: $catNo
                },
                dataType: "json",
                success: function(data) {
                    $('#updCatNo').val(data.catNo);
                    $("#upCatNo").val(data.catNo);
                    $("#upCatDes").val(data.catDes);

                    $("#updateCatModal").modal('show');
                }
            })
        })
        // close modal
        $("#upCloseModal").click(function() {
            $("#updateCatModal").modal('hide');
        })

        // update script
        $(document).on("click", "#btn_updateCat", function(e) {
            e.preventDefault();
            var form = $("#updateCatForm")[0];
            var formData = new FormData(form);
            console.log(formData);
            $.ajax({
                url: "../routes/stockKeeper/updateCatData.php",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Category updated successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to update Category!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                }
            })
            $("#updateCatModal").modal('hide');
        })


        // delete button
        $(document).on("click", ".chkB", function() {
            $catNo = $(this).attr("id");
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
                        url: "../routes/stockKeeper/actDeactCat.php",
                        method: "POST",
                        data: {
                            catNo: $catNo
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

        // go back
        $(document).on("click", "#btn_back", function() {
            $("#SKroot").load('stockKeeper/chooseTask.php');
        })

    });
</script>