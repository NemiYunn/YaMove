<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
       Late Returns***
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-1">
                <a href="" class="btn btn-outline-success btn-md pull-left no-print mb-2" title="print" onclick="window.print();">Print</a>
            </div>
        </div>

        <div id="get_datam" class=" text-center">

        </div>

    </div>
    
</div>


<script>
    $(document).ready(function() {

        $.ajax({
            url: "../routes/notification/tk/viewNotifications.php",
            method: "POST",
            data: {
            },
            success: function(data) {
                $("#get_datam").html(data);
            }
        });

    });
</script>