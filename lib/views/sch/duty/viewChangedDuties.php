<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Changed Duty List
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-1">
                <a href="" class="btn btn-outline-success btn-md pull-left no-print mb-2" title="print" onclick="window.print();">Print</a>
            </div>
        </div>

        <!-- <div class="row no-print mb-3">
            <div class="col-3">
                <input type="search" class="form-control " id="searchValue" placeholder="Search">
            </div>
            <div class="col-6"> </div>
            <div class="col-3">
                <button type="button" id="viewChangeDuties" class="btn btn-outline-success view_btn">View Changed Duties</button>
            </div>
        </div> -->

        <div id="getDatas" class=" text-center">

        </div>
        <div class="row">
            <div class="col-md-3">
                <button class="btn btn-primary no-print" id="btn_back"> Back </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

         //beginning of view route data according to the selected page no
         function fetch_data(page) {
            $.ajax({
                url: "../routes/duty/viewChangedDuties.php",
                method: "POST",
                data: {
                    page: page
                },
                success: function(data) {
                    $("#getDatas").html(data);
                }
            });
        }
        fetch_data();
        $(document).on("click", ".page-item", function() {
            var page = $(this).attr("id");
            fetch_data(page);
        })
        // end of view script



        // go back
        $(document).on("click", "#btn_back", function() {
            $("#root").load('sch/duty/manageDuties.php');
        })

    })
</script>