<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Add Location
    </div>
    <div class="card-body">
        <div id="get_data" class="row">
            <div class="col-md-3"></div>
            <div class="form-group col-md-6">
                <label for="exampleFormControlTextarea1"><b> Select your current locaion..</b></label><br><br>
                <select class="form-control" id="hlt" name="hlt">

                </select>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-7"></div>
            <div class="form-group col-md-2" style="margin-top:15px">
                <button type="button" id="btn_location" class="btn btn-outline-primary">Add Locaton</button>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    // categories fetch
    $.ajax({
        url: "../routes/conductor/getHalts.php",
        method: "POST",
        data: {},
        success: function(data) {
            $("#hlt").html(data);
        }
    });

    $("#btn_location").click(function(e) {
        e.preventDefault();

        var hlt = $("#hlt").val();

        $.ajax({
            url: '../routes/conductor/addLocation.php',
            type: 'POST',
            data: {
                hlt: hlt,
            },
            success: function(data) {
                if (data == 1) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: "Location Updated successfully.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: "Failed to update location.",
                        showConfirmButton: false,
                    });
                }
            },
            error: function() {
                // Error handling code
            }
        });
    });
</script>