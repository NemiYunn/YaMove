<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Stated Breakdowns AND Maintenance Tasks***
    </div>
    <div class="card-body">
        <div class="row">
            <h5>Breakdowns >></h5> <br>
            <div id="get_data" class=" text-center">

            </div>
        </div>
        <br><br>
        <div class="row">
            <h5>Maintenance >></h5> <br>
            <div id="get_datam" class=" text-center">

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $.ajax({
            url: "../routes/technician/viewStartedBreakdowns.php",
            method: "POST",
            data: {},
            success: function(data) {

                $("#get_data").html(data);

                $(".endBtn").click(function() {
                    $assignedId = $(this).attr("id");
                    // alert($assignedId);
                    Swal.fire({
                        title: 'Have you completed working on this bus?',
                        input: 'text', // Add input type for the text box
                        inputLabel: 'Enter completion message', // Prompt text for the text box
                        inputPlaceholder: 'Type, what you have fixed here', // Placeholder text for the text box
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Work is done!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Get the value entered in the text box
                            var completionMessage = result.value;
                            if (completionMessage.trim() !== '') {
                                $.ajax({
                                    url: "../routes/technician/endBrkWorking.php",
                                    method: "POST",
                                    data: {
                                        assignedId: $assignedId,
                                        completionMessage: completionMessage // Include the completion message in the data object
                                    },
                                    success: function(data) {
                                        Swal.fire(
                                            '',
                                            'You have Ended working on this Task!',
                                            'success'
                                        )
                                    }
                                });
                                $(this).text('COMPLETED');
                                $(this).removeClass('btn-outline-primary').addClass('btn-success');
                            } else {
                                alert("Please type what you have fixed.");
                            }
                        }
                    })

                });
            }
        });

        //mnt
        $.ajax({
            url: "../routes/technician/viewStartedMaintenance.php",
            method: "POST",
            data: {},
            success: function(data) {

                $("#get_datam").html(data);

                $(".endMBtn").click(function() {
                    $assignedId = $(this).attr("id");
                    // alert($assignedId);
                    Swal.fire({
                        title: 'Have you completed working on this bus?',
                        input: 'text', // Add input type for the text box
                        inputLabel: 'Enter completion message', // Prompt text for the text box
                        inputPlaceholder: 'Type, what you have fixed here', // Placeholder text for the text box
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Work is done!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Get the value entered in the text box
                            var completionMessage = result.value;
                            if (completionMessage.trim() !== '') {
                                $.ajax({
                                    url: "../routes/technician/endMntWorking.php",
                                    method: "POST",
                                    data: {
                                        assignedId: $assignedId,
                                        completionMessage: completionMessage // Include the completion message in the data object
                                    },
                                    success: function(data) {
                                        Swal.fire(
                                            '',
                                            'You have Ended working on this Task!',
                                            'success'
                                        )
                                    }
                                });
                                $(this).text('COMPLETED');
                                $(this).removeClass('btn-outline-primary').addClass('btn-success');
                            } else {
                                alert("Please type what you have fixed.");
                            }
                        }
                    })

                });
            }
        });




    });
</script>