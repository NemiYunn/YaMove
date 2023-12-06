<?php
include_once("haltModal.php");
include_once("updateHalt.php");
?>

<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Manage Halts
        <input type="text" id="rtId" name="rtId" value="<?php echo ($_GET['rtId']); ?>">
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
                <button type="button" id="btn_update" class="btn btn-outline-primary add_btn">Add New Halt</button>
                
            </div>
        </div>
        <div id="get_datas" class="table-responsive-md text-center">

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // add new halt 
        $(document).on("click", ".add_btn", function() {
            $("#haltModal").modal('show');
        });
        // close modal
        $("#closeModal").click(function() {
            $("#haltModal").modal('hide');
        })
        // clear addnew btn modal
        $('#haltModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        $("#btn_addHalt").click(function(e) {
            // catch the values of the modal
            e.preventDefault();
            var form = $('#addNewHaltForm')[0];
            var formData = new FormData(form);
            var rtId = $("#rtId").val();
            formData.append('rtId',rtId);
             console.log(formData);
            // pass the value to the halt
            $.ajax({
                url: '../routes/halt/addHalt.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                     alert(data);
                },
                error: function() {}
            });
            $("#haltModal").modal('hide');
        })

        //beginning of view halt data according to the selected page no and route
        function fetch_data(page) {
            var rtId = $("#rtId").val();
            $.ajax({
                url: "../routes/halt/viewHalts.php",
                method: "POST",
                data: {
                    page: page,
                    rtId: rtId
                },
                success: function(data) {
                    $("#get_datas").html(data);
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
            var rtId = $("#rtId").val();
            $.ajax({
                url: "../routes/halt/searchHaltData.php",
                method: "POST",
                data: {
                    page: page,
                    key: key,
                    rtId: rtId
                },
                success: function(data) {
                    $("#get_datas").html(data);
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

        // fetch and show(update)
        $(document).on("click", ".edit_Hltbtn", function() {
            $hltId = $(this).attr("id");
            var rtId = $("#rtId").val();
            // pass to the route and get the data
            $.ajax({
                url: "../routes/halt/fetchHalt.php",
                method: "POST",
                data: {
                    hltId: $hltId,
                    rtId: rtId
                },
                dataType: "json",
                success: function(data) {
                    $("#hltUpId").val(data.hltId);
                    $("#hltUpName").val(data.hltName);
                    // $("#hltUpNext").val(data.hltNext);
                    $("#hltUpDis").val(data.hltDis);
                    $("#secUpNo").val(data.secNo);

                    $("#upHaltModal").modal('show');
                    var label = data.hltId+ data.hltName;
                    $("#upHltModalLabel").html(label);
                }
            })
        })
        // close modal
        $("#upCloseModal").click(function() {
            $("#upHaltModal").modal('hide');
        })

        // update script
        $(document).on("click", "#btn_updateHalt", function(e) {
            e.preventDefault();
            var form = $("#updateHaltForm")[0];
            var formData = new FormData(form);
            var rtId = $("#rtId").val();
            formData.append('rtId',rtId);
            //  console.log(formData);
            $.ajax({
                url: "../routes/halt/updateHaltData.php",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                    alert(data);
                }
            })
            $("#upHaltModal").modal('hide');
        })

        // act deact
        $(document).on("click", ".chkH", function() {
            var hltId = $(this).attr("id");
            // var rtId = $("#rtId").val();
            // alert($empId);
            if (confirm("Do you want to change the status of the halt? ")) {
                $.ajax({
                    url: "../routes/halt/actDeactHalt.php",
                    method: "POST",
                    data: {
                        hltId: hltId,
                        // rtId: rtId
                    },
                    success: function(data) {
                        alert(data);
                    }
                })
            }
        })


        $(document).on("click", "#btn_back", function() {
            $("#root").load('sch/route/manageRoutes.php');
        })

    })
</script>