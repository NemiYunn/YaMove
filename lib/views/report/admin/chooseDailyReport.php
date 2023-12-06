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
                <h3 class="card-title">Report of Changed Duties</h3>

                <hr>
                <div class="row">
                    <div class="col-md-5">
                        <h6>You can view this after 5 P.M. ***</h6>
                    </div>
                </div>
                <a href="#" class="btn btn-primary btn-lg mt-2" id="chDuties">Generate Report</a>
            </div>
        </div>
    </div>
    <br>
    <hr id="mHr"><br>
    <div class="row mt-50">
        <div class="card col-md-12">
            <div class="card-body">
                <h3 class="card-title">Report of Absent Employees</h3>

                <hr>
                <div class="row">
                    <div class="col-md-5">
                        <h6>You can view this after 5 P.M. ***</h6>
                    </div>
                </div>
                <a href="#" class="btn btn-primary btn-lg mt-2" id="abEmps">Generate Report</a>
            </div>
        </div>
    </div>

</div>

<script>

    $(document).on("click", "#chDuties", function() {
        $("#root").load("report/admin/changeDutyReport.php");
    });

    $(document).on("click", "#abEmps", function() {
        $("#root").load("report/admin/absentEmpReport.php");
    });
</script>