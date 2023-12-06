<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Assign Technician***
    </div>
    <div class="card-body">

        <div id="get_datam" class="row text-center">
            <div class="col-md-3"></div>

            <div class="col-md-6 form-group" style="margin-top:10px">
                <span class="mntId" id="<?php echo ($_GET['mntId']); ?>"></span>
                <label class="form-label"><b>Select Technician:</b></label>
                <select class="form-control" id="tech" name="tech">

                </select>
            </div>
            <div class="form-group" style="margin-top:10px">
                <button type="button" id="btn_assignMntTech" class="btn btn-outline-primary">Assign Technician</button>
            </div>
        </div>

    </div>

</div>

<script>
    // categories fetch
    $.ajax({
        url: "../routes/foreman/getTechies.php",
        method: "POST",
        data: {},
        success: function(data) {
            $("#tech").html(data);
        }
    });

    $("#btn_assignMntTech").click(function(e) {
        e.preventDefault();

        var tech = $("#tech").val();
        var mntId = $(".mntId").attr("id");
        console.log(mntId);

        $.ajax({
            url: '../routes/foreman/assignMntTechnician.php',
            type: 'POST',
            data: {
                tech: tech,
                mntId: mntId,
            },
            success: function(data) {
                if (data == 1) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: "Technician assigned successfully.",
                        showConfirmButton: false,
                        timer: 3500
                    });
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: "Failed to assign technician.",
                        showConfirmButton: false,
                    });
                }
            },
            error: function() {
                // Error handling code
            }
        });
        $(this).text('HAVE ASSIGNED');
        $(this).removeClass('btn-outline-primary').addClass('btn-success');
    });
</script>