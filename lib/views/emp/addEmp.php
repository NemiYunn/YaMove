<!-- card -->
<style>
    .card {
        background-color: #F8F9FA;
        border-color: #17A2B8;
        width: 800px;
        margin: 0 auto;
    }

    .card-header {
        background-color: #17A2B8;
        color: #FFF;
        padding: 10px;
        font-weight: bold;
        text-align: center;
    }

    .card-body {
        padding: 50px;
    }

    .form-label {
        font-weight: bold;
    }

    .form-control {
        margin-bottom: 10px;
    }

    .img-responsive {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    .btn-primary {
        width: 20%;
    }
</style>

<div class="card text-dark bg-light border-info">
    <div class="card-header">
        EMPLOYEE Registration Section
    </div>
    <div class="card-body">
        <!-- Bootstrap form -->
        <form id="empRegForm">
            <div class="mb-3">
                <label for="formFile" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="empProfilePic" name="empProfilePic">
                <i class="fa fa-user-circle-o mr-1" aria-hidden="true"></i>
            </div>
            <div class="mb-3">
                <label for="EnterYourName" class="form-label">EMP Name</label>
                <input type="text" class="form-control" id="EnterYourName" name="EnterYourName" placeholder="Enter Your Name">
            </div>
            <div class="mb-3">
                <label for="EnterYourEmail" class="form-label">EMP Email Address</label>
                <input type="email" class="form-control" id="EnterYourEmail" name="EnterYourEmail" placeholder="Enter Your Email">
            </div>
            <div class="mb-3">
                <label for="EnterYourName" class="form-label">EMP NIC No</label>
                <input type="text" class="form-control" id="EnterYourNic" name="EnterYourNic" placeholder="Enter Your NIC Number">
            </div>
            <div class="mb-3">
                <label for="EnterYourPhone" class="form-label">EMP Phone</label>
                <input type="text" class="form-control" id="EnterYourPhone" name="EnterYourPhone" placeholder="Enter Your Phone">
            </div>
            <div class="mb-3">
                <label for="EnterYourLicense" class="form-label">Driver License No</label>
                <input type="text" class="form-control" id="EnterYourLicense" name="EnterYourLicense" placeholder="Enter Your License No">
            </div>
            <div class="mb-3">
                <label for="EnterYourGender" class="form-label">EMP Gender</label>
                <br>
                Male: <input type="radio" name="gender" id="EnterYourGender" value="1">
                &nbsp;&nbsp;
                Female: <input type="radio" name="gender" id="EnterYourGender" value="0">
            </div>
            <div>
                <input type="submit" value="Submit" class="btn btn-primary" id="saveEmpRegistration">
            </div>
        </form>
    </div>
</div>


<script>
    // image preview prcess
    $('#empProfilePic').change(function() {
        var read = new FileReader();
        read.onload = function(e) {
            $('#profilePicturePreview').attr("src", e.target.result);
            $('#profilePicturePreview').attr("style", "height:200px;width:200px;margin-top:8px");
        }
        read.readAsDataURL(this.files[0]);
    })

    // send form data
    $('#saveEmpRegistration').click(function(e) {
        e.preventDefault();
        var form = $('#empRegForm')[0];
        var formData = new FormData(form);

        $.ajax({
            url: '../routes/offlineRegistration/empReg.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == 1) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Employee added successfully!',
                        showConfirmButton: false,
                        timer: 2500
                    })
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Failed to add employee!',
                        showConfirmButton: false,
                        timer: 2500
                    })
                }
                $('#empRegForm')[0].reset();
            },
            error: function() {

            }
        });
    })


   
</script>