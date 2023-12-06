<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Add Breakdown
    </div>
    <div class="card-body">
        <div id="get_data" class="row">
            <div class="col-md-3"></div>
            <div class="form-group col-md-6">
                <label for="exampleFormControlTextarea1"><b> Type your Issue here...</b></label><br><br>
                <textarea class="form-control" id="brkIssue" name="issue" rows="3"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7"></div>
            <div class="form-group col-md-2" style="margin-top:15px">
                <button type="button" id="btn_breakdown" class="btn btn-outline-primary">Add Breakdown</button>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {

        $("#btn_breakdown").click(function(e) {
            $textAreaValue = $('#brkIssue').val();
            // alert($textAreaValue);
            $.ajax({
                url: '../routes/breakdown/addBreakdown.php',
                type: 'POST',
                data: {
                    issue: $textAreaValue,
                },
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Breakdown added successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to add Breakdown!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                },
                error: function() {}
            });
        });

    });
</script>