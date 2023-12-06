<style>
    thead {
        background-color: #333;
        color: #fff;
        font-weight: 500;
    }

    #letterheadContainer {
        background-color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 50px;
        position: relative;
        
    }

    #letterHead {
        /* overflow: hidden;  */
        background-image: url('../images/depotLH.png');
        background-size: cover;
        align-items: center;
        height: 190px;
        width: 586px;
        position: absolute;
        top: 0;
        left: 0;
        /* z-index: 2; */
        padding-right: -20px;
    }

    #reportContainer {
        position: relative;
        text-align: center;
        width: 75%;
        margin: auto;
        padding-top: 20px;
        
        /* Adjust the padding to create space below the letterHead */
    }
</style>
<div class="row">
    <div class="col-md-2"></div>
    <div id="letterheadContainer" class="col-md-7">
        <div class="" id="letterHead">

        </div>
        <div id="reportContainer" class=" text-center">

        </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-2">
        <a href="" class="btn btn-success btn-lg pull-left no-print mb-2" title="print" onclick="window.print();">Print Report</a>
    </div>
</div>


<script>
    $(document).ready(function() {
        var rowHeight = 0;
        var fullH = 0;
        $.ajax({
            url: '../routes/report/admin/changeDutyReport.php',
            method: 'POST',
            data: {
            },
            success: function(response) {
                $('#reportContainer').html(response);

                // Calculate the height based on the number of rows

                var tableRowCount = document.querySelectorAll("#reportContainer table tbody tr").length;
                var rows = document.querySelectorAll("#reportContainer table tbody tr");
                rows.forEach(function(row) {
                    rowHeight = row.clientHeight;
                    fullH += rowHeight;

                });
                console.log('Row height:', fullH);
                // console.log('Row height:', rowHeight);
                var tableHeight = (tableRowCount * rowHeight);

                // Set the calculated height to the report container

                document.getElementById("reportContainer").style.height = tableHeight + "px";
                var letterHeight = tableHeight + 400;
                document.getElementById("letterheadContainer").style.height = letterHeight + "px";
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });

    });
</script>