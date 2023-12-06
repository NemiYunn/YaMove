<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Manage Rosters
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
            <div class="col-7"> </div>
            <div class="col-2">
                <button type="button" id="btn_add" class="btn btn-outline-primary add_btn">Add New Roster</button>
            </div>
        </div>
        <div class="row no-print mb-3">
            <div class="col-3">
                <select class="form-select c1" aria-label="Default select example" name="selectRole" id="selectRole">
                    <option selected disabled>Select Role</option>
                    <option value="driver">Driver</option>
                    <option value="conductor">Conductor</option>
                </select>
            </div>
        </div>
        <div id="get_datam" class="table-responsive-md text-center">

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
    $(document).on("click", ".add_btn", function() {
        $("#root").load('sch/roster/addNewRoster.php');

    });

    $(document).ready(function() {

        function fetch_data(page) {
            $.ajax({
                url: "../routes/roster/viewRoster.php",
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
        // end of view script

        // beginning of Search and show results
        function load_data(page, key = "") {
            $.ajax({
                url: "../routes/roster/searchRoster.php",
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
        // end of search script

        // beginning of filter and show results
        function filter_data(page, key = "") {
            $.ajax({
                url: "../routes/roster/filterRoster.php",
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
        $("#selectRole").on('change', function() {
            var key = $(this).val();
            filter_data(1, key);
        });
        // To pass the selected page value and key(show result according to the page)
        $(document).on("click", ".page-items", function() {
            var page = $(this).attr("id");
            var key = $("#selectRole").val();
            filter_data(page, key);
        });
        

        // delete button
        $(document).on("click", ".delete_btn", function() {
            $rosId = $(this).attr("id");
            if (confirm("Are you sure you want to delete this roster?") == true) {
                $.ajax({
                    url: "../routes/roster/deleteRoster.php",
                    method: "POST",
                    data: {
                        rosId: $rosId
                    },
                    success: function(data) {
                        alert(data);
                    }
                });
            }
        })

        $(document).on("click", ".view_btn", function() {
            let value = $(this).attr('id');
            $("#root").load('sch/roster/viewOneRoster.php?rosId=' + value);
        });

        $(document).on("click", "#btn_back", function() {
            $("#root").load('sch/chooseScheduleTask.php');
        })
    })
</script>