<style>
    .table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th,
    .table td {
        padding: 8px;
        border: 1px solid #000;
    }

    .table th {
        background-color: #f2f2f2;
    }

    .table tr:first-child th {
        border-top: 2px solid #000;
    }

    .table tr:last-child td {
        border-bottom: 2px solid #000;
    }

    .table tr:first-child td {
        border-top: 2px solid #000;
    }

    .table tr td {
        border-bottom: 1px solid #000;
    }

    .table tr.partNo-row {
        border-bottom: 2px solid #000;
    }
</style>



<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Manage Duties
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-1">
                <a href="" class="btn btn-outline-success btn-md pull-left no-print mb-2" title="print" onclick="window.print();">Print</a>
            </div>
        </div>

        <div class="row no-print mb-3">
            <div class="col-3">
            </div>
            <div class="col-5"> </div>
            <div class="col-4"> </div>
        </div>
        <div id="get_datam" class=" text-center">

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
                url: "../routes/stockKeeper/stockRemain.php",
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



    });
</script>