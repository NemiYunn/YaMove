<!-- Hello -->


<div class="card mt-2 ">
    <div class="card-header no-print">
        Login Control System
    </div>
    <div class="card-body">
        <form id="loginControl">
            <div class="mb-3 row no-print">
                <label for="staticEmail" class="col-sm-2 col-form-label">Enter Emp ID</label>
                <div class="col-auto">
                    <input type="text" class="form-control" id="empId" name="empId" placeholder="Search By Emp Id">
                </div>
            </div>
            <div class="col-auto no-print">
                <button class="btn btn-info mb-3 " id="searchEmpId" onclick="return false">Search</button>
            </div>
            <span id="msg" style="color:brown; font-size:1rem; font-weight:100; background-color:aquamarine;" class="no-print"></span>
            <div class="row">
                <div class="col-md-8 no-print">
                    <div class="mb-3 row" style="display:none;">
                        <label for="Id" class="col-sm-2 col-form-label">Emp role</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="emprole" name="empRole" value="<?php echo ($_GET['role']); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Emp Name:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="empName" id="empName" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Emp Email:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="empEmail" id="empEmail" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row" id="password">
                        <label for="pwd" class="col-sm-2 col-form-label">Emp Password:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="empPwd" id="empPwd" readonly>
                        </div>
                    </div>
                    <span id="msg_li" style="color:red; font-size:1rem; font-weight:100;;"></span>
                    <div class="mb-3 row" id="license">
                        <label for="pwd" class="col-sm-2 col-form-label">Driver License No:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="EmpLicense" id="EmpLicense" required>

                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="active" class="col-sm-2 col-form-label">Active/Deactive:</label>
                        <div class="col-sm-6">
                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" class="form-check-input" name="toggleActive" id="toggleActive" role="switch">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div id="qr"></div><br>
                    <input type="text" class="form-control" id="NIC" value="SLTB" style="display:none">
                    <button class="btn btn-primary" id="genQr" style="display:none">Generate QR</button>
                    <br><br>
                    <a href="" class="btn btn-outline-success btn-md pull-left no-print mb-2" title="print" onclick="window.print();">Print</a>
                </div>
            </div>

            <div class="mb-3 row no-print">
                <div class="col-sm-6">
                    <button class="btn btn-primary" id="accessSubmit" onclick="return false">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    var key = "a"; // key for encrypt NIC

    // auto generated password
    function generatePassword(passwordLength) {
        var numberChars = "0123456789";
        var upperChars = "ABCDEFGHIJKMNOPQRSTUVWXYZ"
        var lowerChars = "abcdefghijklmnopqrstuvwxyz"
        var allChars = numberChars + upperChars + lowerChars;
        var randPasswordArray = Array(passwordLength);
        randPasswordArray[0] = numberChars;
        randPasswordArray[1] = upperChars;
        randPasswordArray[2] = lowerChars;
        randPasswordArray = randPasswordArray.fill(allChars, 3);
        return shuffleArray(randPasswordArray.map(function(x) {
            return x[Math.floor(Math.random() * x.length)]
        })).join('');
    }

    function shuffleArray(array) {
        for (var i = array.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var temp = array[i];
            array[i] = array[j];
            array[j] = temp;
        }
        return array;
    }

    // whenever search an id show necessary feilds with data
    $("#searchEmpId").click(function() {

        $empId = $("#empId").val();
        $.ajax({
            url: "../routes/emp/fetchUser.php",
            method: "POST",
            data: {
                empId: $empId
            },
            dataType: "json",
            success: function(data) {

                if (data.login_status == 1) {
                    // registered user
                    $("#license").hide();
                    $("#password").hide();
                    $("#msg").html("This user is Active.");
                    $("#toggleActive").prop("checked", true);
                } else {
                    $("#password").show();
                    $("#msg").hide();
                    $("#toggleActive").prop("checked", false);
                }
                // console.log(data);
                // show data i input feilds
                $role = $("#empRole").val();
                if ($role == "driver") {
                    $("#license").show();
                    //alert('yes');
                } else {
                    $("#license").hide();
                    //alert('no');
                }

                $("#empName").val(data.emp_name);
                $("#empEmail").val(data.emp_email);
                $("#NIC").val(data.emp_nic);
                // generate pwd and show for inactive users
                $("#empPwd").val(generatePassword(8));
                $("#EmpLicense").val(data.emp_license);
                // alert(data.emp_nic);
                // var button = document.getElementById('genQr');
                document.getElementById('genQr').click();
                // button.makeCode();

            }
        });
    });

    // pass form data to saveAccess route file
    $("#accessSubmit").click(function(e) {
        //    alert("done");
        e.preventDefault();

        $lice = $("#EmpLicense").val();
        $role = $("#empRole").val();
        if ($lice == "" && $role == 'driver') {
            // alert("enter driver licence");
            $("#msg_li").html("Required Feild***")
        } else {
            var form = $('#loginControl')[0];
            var formData = new FormData(form);
            //console.log(formData);
            $.ajax({
                url: "../routes/emp/saveAccess.php",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data);
                    if (data == 1) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Employee activated successfully!',
                        showConfirmButton: false,
                        timer: 2500
                    })
                } else if (data == 0){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Employee Deactivated!',
                        showConfirmButton: false,
                        timer: 2500
                    })
                }
                    $.ajax({
                        url: "../routes/emp/send_email.php", // Path to your PHP script
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response);
                        }
                    });
                }
            });
            $('#loginControl')[0].reset();
        }
    })

    var qrcode = new QRCode(document.getElementById("qr"), {
        width: 200,
        height: 200
    });

    function makeCode() {

        var elText = document.getElementById("NIC");
        var nic = elText.value;
        if (!nic) {
            alert("Input a text");
            elText.focus();
            return;
        }
        var encrypted = CryptoJS.AES.encrypt(nic, key).toString();
        qrcode.makeCode(encrypted);
    }

    $('#genQr').on('click', function(e) {
        e.preventDefault();
        makeCode();
    });
</script>