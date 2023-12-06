<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Today's Newly Assign Duties and Changes***
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
            url: "../routes/notification/driver/viewNotifications.php",
            method: "POST",
            data: {
            },
            success: function(data) {
                $("#get_datam").html(data);
            }
        });

         // click confirm and set resStatus to 1
         $(document).on("click", ".conBtn", function() {
            var id = $(this).attr("id");
            $(this).removeClass("btn-outline-primary").addClass("btn-outline-success").text("ACCEPTED");
            $.ajax({
                url: "../routes/notification/driver/confirmDuty.php",
                method: "POST",
                data: {
                    aid: id
                },
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Duty Accepted!',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed acceptance!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                }
            });
        });

    });
</script>