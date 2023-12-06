<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Assigned Breakdowns***
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
            url: "../routes/notification/tcn/viewAssignedBreakdowns.php",
            method: "POST",
            data: {},
            success: function(data) {

                $("#get_datam").html(data);

                $(".strtBtn").click(function() {
                    $assignedId = $(this).attr("id");
                    // alert($assignedId);
                    Swal.fire({
                        title: 'Are you going to start working on this bus?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Start working on!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "../routes/technician/startBrkWorking.php",
                                method: "POST",
                                data: {
                                    assignedId: $assignedId,
                                },
                                success: function(data) {
                                        Swal.fire(
                                            '',
                                            'You have Started working on..!',
                                            'success'
                                        )
                                }
                            });
                        }
                    })
                    $(this).text('STARTED');
                    $(this).removeClass('btn-outline-primary').addClass('btn-success');
                });

            }
        });



    });
</script>