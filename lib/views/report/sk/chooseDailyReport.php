<style>
    hr {
        border: none;
        border-top: 5px solid #d3d3d3;
        height: 0;
        margin: 20px 0;
    }

    #mHr {
        border: none;
        border-top: 3px solid #d3d3d3;
        height: 0;
        margin: 20px 0;
    }
</style>

<div class="container mt-4">

    <div class="row mt-10">
        <div class="card col-md-12">
            <div class="card-body">
                <h3 class="card-title">Report of Today's Total Cost </h3>

                <hr>
                <div class="row">
                    <div class="col-md-5">
                        <h6>You can view this after 5 P.M. ***</h6>
                    </div>
                </div>
                <a href="#" class="btn btn-primary btn-lg mt-2" id="tdCost">Generate Report</a>
            </div>
        </div>
    </div>
    <br>
    <hr id="mHr"><br>
    <div class="row mt-50">
        <div class="card col-md-12">
            <div class="card-body">
                <h3 class="card-title">Report of Cost Details for Buses</h3>

                <hr>
                <div class="row">
                    <div class="col-md-5">
                        <h6>You can view this after 5 P.M. ***</h6>
                    </div>
                </div>
                <a href="#" class="btn btn-primary btn-lg mt-2" id="tdBusCost">Generate Report</a>
            </div>
        </div>
    </div>

</div>

<script>

    $(document).on("click", "#tdCost", function() {
        $("#SKroot").load("report/sk/todayTotCost.php");
    });

    $(document).on("click", "#tdBusCost", function() {
        $("#SKroot").load("report/sk/todayTotCostBus.php");
    });
</script>