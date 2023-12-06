<?php
// include admin style script
include_once("../include/user_style.php");
include_once("../include/sup_nav.php");
include_once("supplier/addQModal.php");
?>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<body>
    <div id="rfqRoot">
        <div class="col-lg-4 alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Registration confirmation</h4>
            <p>Now you can login to the system!</p>
        </div>
        <br>
        <div class="card">
            <div style="position: relative;">
                <img src="../images/stock.jpg" class="card-img-top" alt="store" style="height: 100px;">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;background-color: rgba(0, 0, 0, 0.5); z-index: 1;">
                    <p style="position: absolute; top: 45%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 46px; font-weight: bold;">SLTB Ududumbara Depot </p>
                    <p style="position: absolute; top: 85%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 20px; font-weight: bold;">Connect with island wide suppliers </p>
                </div>
            </div>
        </div>
        <div class="card col-auto text-dark bg-light border-info">
            <div class="card-body">
                <br>
                <div id="get_datam" class="row text-center">

                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-9">
                        <!-- <button class="btn btn-primary no-print" id="btn_back" style="position:absolute; left:10px;bottom:10px;"> Back </button> -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        const qstr = window.location.search;
        const param = new URLSearchParams(qstr);
        const md = param.get('md');
        const mail = param.get('username');
        const vcode = param.get('code');

        console.log(md);
        if (md != 'true') {
            $('.alert').hide();
        }

        setTimeout(function() {
            $('.alert').alert('close');
        }, 3000);

        $.ajax({
            url: "../routes/supplier/verify.php",
            method: "POST",
            data: {
                email: mail,
                vcode: vcode
            },
            success: function(data) {
                if (data == 1) {
                    alert("User Verified Successfully!");
                } else if (data == 0) {
                    // alert("Sorry! Verification failed.");
                }

            }
        });


        //beginning of view data 

        $.ajax({
            url: "../routes/supplier/viewRfq.php",
            method: "POST",
            data: {},
            success: function(data) {
                $("#get_datam").html(data);
            }
        });

        // addQ
        $(document).on("click", ".addQ", function() {
            $rId = $(this).attr("id");
            $("#rfqNo").val($rId);

            $.ajax({
                url: "../routes/supplier/fetchDetails.php",
                method: "POST",
                data: {
                    rId: $rId,
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('#itName').text(data.descrip);
                    $("#itCat").text(data.catDes);
                    $("#qty").text(data.rQuantity);
                    $("#date").text(data.closingDate);
                }
            })
            $("#qModal").modal('show');
        });
        // close modal
        $("#closeModal").click(function() {
            $("#qModal").modal('hide');
        })
        // clear addnew btn modal
        $('#qModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })


        $("#btn_addQ").click(function(e) {
            e.preventDefault();
            var form = $('#addNewQForm')[0];
            var formData = new FormData(form);
            console.log(formData)

            $.ajax({
                url: '../routes/supplier/addQuotation.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Quotation added successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }else if(data == 2){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Please log in to your acoount first!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    } else{
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to add Qoutation!',
                            showConfirmButton: false,
                            timer: 2500
                        })
                    }
                },
                error: function() {}
            });
            $("#qModal").modal('hide');
        });


    });
</script>