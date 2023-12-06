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

    <div class="row">
        <div class="card col-md-12">
            <div class="card-body">
                <h3 class="card-title">Report for Late Returns of Tools  </h3>
                <hr>
                <div class="row">
                    <div class="col-md-1">
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Start Date :</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <input type="date" class="form-control startDateRes" id="datepicker">
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-1">
                        <div class="mb-3">
                            <label for="endDate" class="form-label">End Date :</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <input type="date" class="form-control endDateRes" id="datepicker">
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-primary btn-lg mt-2" id="returns">Generate Report</a>
            </div>
        </div>
    </div>

    <!-- <br>
    <hr id="mHr"><br>

    <div class="row">
        <div class="card col-md-12">
            <div class="card-body">
                <h3 class="card-title">Report For Total Cost of Categories </h3>
                <hr>
                <div class="row">
                    <div class="col-md-1">
                        <div class="mb-3">
                            <label for="startDateC" class="form-label">Start Date :</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <input type="date" class="form-control startDateResC" id="datepicker">
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-1">
                        <div class="mb-3">
                            <label for="endDateC" class="form-label">End Date :</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <input type="date" class="form-control endDateResC" id="datepicker">
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-primary btn-lg mt-2" id="catRep">Generate Report</a>
            </div>
        </div>
    </div> -->


</div>


<script>
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    $tday = yyyy + '-' + mm + '-' + dd;
    $tday.toString();
    $("#datepicker").attr("max", $tday);
    $(document).ready(function() {

        $stdate = "";
        $endate = "";

        $(".startDateRes").on("input", function() {
            $stdate = $(this).val();
        });
        $(".endDateRes").on("input", function() {
            $endate = $(this).val();
        });

        $(document).on("click", "#returns", function() {
            $("#TKroot").load("report/tk/lateReturns.php");
        });

        // $stdateC = "";
        // $endateC = "";

        // $(".startDateResC").on("input", function() {
        //     $stdateC = $(this).val();
        // });
        // $(".endDateResC").on("input", function() {
        //     $endateC = $(this).val();
        // });

        // $(document).on("click", "#catRep", function() {
        //     $("#SKroot").load("report/sk/costOfCats.php");
        // });



    })
</script>