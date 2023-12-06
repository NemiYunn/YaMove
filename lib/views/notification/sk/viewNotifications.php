<?php
include_once("rfqModal.php");
?>
<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Items Below Stock level***
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
            url: "../routes/notification/sk/viewNotifications.php",
            method: "POST",
            data: {},
            success: function(data) {
                $("#get_datam").html(data);
            }
        });

        // click confirm and set resStatus to 1
        $(document).on("click", ".rfqBtn", function() {
            var partNo = $(this).attr("id");
            $("#partNo").val(partNo);
            $("#rfqModal").modal('show');
        });

        $("#btn_rfq").click(function(e) {
            // catch the values of the modal
            e.preventDefault();
            var form = $('#rfqForm')[0];
            var formData = new FormData(form);
            var prtNo = $("#partNo").val();
            formData.append('partNo', prtNo);
            console.log(formData);

            $.ajax({
                url: '../routes/stockKeeper/rfq.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Request sent successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        });
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to send request!',
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                },
                error: function() {}
            });
            $("#rfqModal").modal('hide');
        });

        // close modal
        $("#closeModal").click(function() {
            $("#rfqModal").modal('hide');
        })
        // clear addnew btn modal
        $('#rfqModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })



    });
</script>