<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Breakdowns***
    </div>
    <div class="card-body">
        <div class="row">
            <div id="get_datam" class=" text-center">

            </div>
        </div>
        <br>
        <hr>
        <br>
        <div class="row">
            <h6> Completed Tasks****</h6>
            <div id="get_data" class=" text-center">

            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $.ajax({
            url: "../routes/notification/foreman/viewBreakdowns.php",
            method: "POST",
            data: {},
            success: function(data) {

                $("#get_datam").html(data);
                $(".asgnBtn").click(function() {
                    var brkId = $(this).attr("id");
                    // alert(brkId);
                    $("#Froot").load('foreman/assignBrkTechnician.php?brkId=' + brkId);
                });
            }
        });

        $.ajax({
            url: "../routes/notification/foreman/viewCompletedBreakdowns.php",
            method: "POST",
            data: {},
            success: function(data) {

                $("#get_data").html(data);
                $(".doneBtn").click(function() {
                    $baId = $(this).attr("id");
    
                    Swal.fire({
                        title: 'Have you checked the completed task?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, It is almost Ok!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "../routes/foreman/confirmBrkTask.php",
                                method: "POST",
                                data: {
                                    baId: $baId,
                                },
                                success: function(data) {
                                        Swal.fire(
                                            '',
                                            'Task complesion Confirmed!',
                                            'success'
                                        )
                                }
                            });
                        }
                    })
                    $(this).text('CONFIRMED');
                    $(this).removeClass('btn-outline-info').addClass('btn-success');
                });
            }
        });


    });
</script>