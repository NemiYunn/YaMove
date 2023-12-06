<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Today's Trip Details
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-1">
                <a href="" class="btn btn-outline-success btn-md pull-left no-print mb-2" title="print" onclick="window.print();">Print</a>
            </div>
        </div>
        <br>
        <div id="get_data" class="table-responsive-md text-center">

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        //beginning of view res data according to the selected page no

        $.ajax({
            url: "../routes/conductor/viewTrips.php",
            method: "POST",
            data: {},
            success: function(data) {
                $("#get_data").html(data);
            }
        });


    })
</script>