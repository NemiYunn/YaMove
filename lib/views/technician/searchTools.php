<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Search for Tools
    </div>
    <div class="card-body">
        <!-- <div class="row">
            <div class="col-1">
                <a href="" class="btn btn-outline-success btn-md pull-left no-print mb-2" title="print" onclick="window.print();">Print</a>
            </div>
        </div> -->

        <div class="row no-print mb-3">
            <div class="col-3">
                <!-- <label for="search" class="vissually-hidden">Search</label> -->
                <input type="search" class="form-control " id="searchValue" placeholder="Search">
            </div>
            <div class="col-6"> </div>
            <div class="col-3">
                <!-- <button type="button" id="category" class="btn btn-outline-primary add_btn">Add New Item</button>
                <button type="button" id="category" class="btn btn-outline-success hist_btn">Issued History</button> -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div id="get_data" class="col-md-6 text-center"></div>
            <div class="col-md-3"></div>
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
        //beginning of view data according to the selected page no
        function fetch_data(page) {
            $.ajax({
                url: "../routes/technician/viewTools.php",
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
                url: "../routes/technician/searchTools.php",
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

        // go back
        $(document).on("click", "#btn_back", function() {
            $("#TCNroot").load('notificaion/tcn/chooseNotify.php');
        })



    });
</script>