<?php
include_once("tripModal.php");
include_once("updateTrip.php");
?>

<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Manage Trips <input type="text" id="schNo" name="schNo" value="<?php echo ($_GET['schNo']); ?>">
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
                <button type="button" id="btn_update" class="btn btn-outline-primary add_trp_btn">Add New Trip</button>
            </div>
        </div>
        <div id="get_data" class="table-responsive-md text-center">
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // addNewTrip script
        $(document).on("click", ".add_trp_btn", function() {
            $("#tripModal").modal('show');
        });
        // close modal
        $("#closeModal").click(function() {
            $("#tripModal").modal('hide');
        })
        // clear addnew btn modal
        $('#tripModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        $("#btn_addTrp").click(function(e) {
            // catch the values of the modal
            e.preventDefault();
            var form = $('#addNewTripForm')[0];
            var formData = new FormData(form);
            console.log(formData)
            // pass the value to the route
            $.ajax({
                url: '../routes/trip/addTrip.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    alert(data);
                },
                error: function() {}
            });
            $("#tripModal").modal('hide');
        })

        //beginning of view trip data according to the selected page no and sch
        function fetch_data(page) {
            var schNo = $("#schNo").val();
            $.ajax({
                url: "../routes/trip/viewTrips.php",
                method: "POST",
                data: {
                    page: page,
                    schNo: schNo
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
            var schNo = $("#schNo").val();
            $.ajax({
                url: "../routes/trip/searchTripData.php",
                method: "POST",
                data: {
                    page: page,
                    key: key,
                    schNo: schNo
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

        // fetch and show(update)
        $(document).on("click", ".edit_Trpbtn", function() {
            $trpId = $(this).attr("id");
            var schNo = $("#schNo").val();
            // pass to the route and get the data
            $.ajax({
                url: "../routes/trip/fetchTrip.php",
                method: "POST",
                data: {
                    trpId: $trpId,
                    schNo: schNo
                },
                dataType: "json",
                success: function(data) {
                    $("#trpUpId").val(data.trpId);
                    $("#depFromUp").val(data.departureFrom);
                    $("#depAtUp").val(data.departureAt);
                    $("#arrToUp").val(data.arriveTo);
                    $("#arrAtUp").val(data.arriveAt);

                    $("#tripUpModal").modal('show');
                }
            })
        })
        // close modal
        $("#closeUpModal").click(function() {
            $("#tripUpModal").modal('hide');
        })
        // update script
        $(document).on("click", "#btn_UpTrp", function(e) {
            e.preventDefault();
            var form = $("#UpTripForm")[0];
            var formData = new FormData(form);
            var schNo = $("#schNo").val();
            formData.append('schNo', schNo);
            //  console.log(formData);
            $.ajax({
                url: "../routes/trip/updateTripData.php",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                    alert(data);
                }
            })
            $("#tripUpModal").modal('hide');
        })


        // act deact
        $(document).on("click", ".chkT", function() {
            $trpId = $(this).attr("id");
            var schNo = $("#schNo").val();

            if (confirm("Do you want to change the status of the trip? ") == true) {
                $.ajax({
                    url: "../routes/trip/actDeactTrip.php",
                    method: "POST",
                    data: {
                        trpId: $trpId,
                        schNo: schNo
                    },
                    success: function(data) {
                        alert(data);
                    }
                })
            }
        })

        $(document).on("click", "#btn_back", function() {
            $("#root").load('sch/schedule/manageSchedules.php');
        })
    });
</script>