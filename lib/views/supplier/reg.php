<?php
include_once("../../include/user_style.php");
?>
<div class="mr-5 mt-2 mb-1" style="background-color: light-green; text-align:right;"> Already have an account? <a href="login.php">Login</a> &nbsp;&nbsp;</div>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
</head>

<body>
    <div style="background-color: #9A616D;">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center ">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-lg-2 d-flex align-items-center">
                                <div class="row">
                                    <img src="../../images/logo.png" width="160px" height="90px" alt="" class="center">
                                    <center>
                                        <h4 class="fw-normal mt-2 pb-3" style="letter-spacing: 1px;">Register</h4>
                                        <p class="fw-normal" style="margin-top: -14px;">SLTB Ududumbara</p>
                                        <p class="fw-normal" style="margin-top: -10px; font-size: 15px;">Connect with Island wide Suppliers</p>
                                    </center>
                                </div>
                            </div>
                            <div class="col-lg-9 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <!-- form -->
                                    <form class="row g-3 needs-validation" id="userRegForm">
                                        
                                        <div class="col-md-10">
                                            <label for="validationCustom01" class="form-label">Business Name</label>
                                            <input type="text" class="form-control" id="bName" placeholder="Your Business name" name="bName" required>
                                            <div class="invalid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                        <p class="mt-2"></p>
                                        <div class="input-group">
                                            <span class="input-group-text"> &nbsp; Address &nbsp;</span>
                                            <input type="text" class="form-control" id="add" placeholder="Your Business Address" name="add" required>
                                            <div class="invalid-feedback">
                                                Please provide a valid Address.
                                            </div>
                                        </div>
                                        <p class="mt-1"></p>
                                        <div class="col-md-4">
                                            <label for="validationCustom01" class="form-label">Your Mobile Number</label>
                                            <input type="text" class="form-control" id="mobileNum" placeholder="Mobile Number" name="mobileNum" required>
                                            <div class="invalid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <label for="validationCustom05" class="form-label">Business Username</label>
                                            <input type="email" class="form-control" id="userName" placeholder="user@gmail.com" name="userName" required>

                                            <div class="invalid-feedback">
                                                Please provide a valid email.
                                            </div>
                                            <div id="textExample1" class="form-text">
                                            Please make sure to give your Business' email. We'll never share your email with anyone else.
                                            </div>
                                        </div>
                                        <p class="mt-2"></p>
                                        <div class="row mt-15">
                                            <div class="col-md-6">
                                                <label for="validationCustom01" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="userPwd" name="userPwd" placeholder="Password" required>
                                                <div class="invalid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="validationCustom05" class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" id="userComPwd" name="userComPwd" placeholder="Confirm Password" required>
                                                <div class="invalid-feedback">
                                                    ....
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit" id="saveUserReg">Submit form</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="spinnerContainer" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <i class="fas fa-spinner fa-spin fa-2x"></i>
        </div>
    </div>


    <script>
        // Send form data
        $('#saveUserReg').click(function(e) {
            e.preventDefault();
            var form = $('#userRegForm')[0];
            var formData = new FormData(form);
            if (validateForm(formData)) {
                $('#spinnerContainer').show();
                // Proceed with form submission
                $.ajax({
                    url: '../../routes/supplier/userReg.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('#spinnerContainer').hide();
                        // alert(data);
                        if (data == 1) {
                            Swal.fire({
                                title: "",
                                text: "Email has been sent, Check and Verify your Email.",
                                icon: "success",
                                confirmButtonText: "OK"
                            });
                        } else {
                            Swal.fire({
                                title: "",
                                text: data,
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }

                    },
                    error: function() {
                        $('#spinnerContainer').hide();
                    }
                });
            }
        });

        // Validate form fields
        function validateForm(formData) {
            var regexBusinessName = /^[A-Za-z0-9\s\-.,'&()!@#$%^*]+$/;
            var regexAddress = /^[A-Za-z0-9\s\-.,'&()]+$/;
            var regexMobile = /^[0-9]{10}$/; // 10-digit mobile number
            var regexEmail = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,})+$/; 
            var regexPassword = /^(?=.*[A-Z]).{8,}$/;
            var bName = formData.get('bName');
            var add = formData.get('add');
            var mobileNum = formData.get('mobileNum');
            var userName = formData.get('userName');
            var userPwd = formData.get('userPwd');
            var userComPwd = formData.get('userComPwd');

            clearErrorMessages(); // Clear any existing error messages

            var isValid = true;

            if (!regexBusinessName.test(bName)) {
                displayErrorMessage('bName', 'Name should only contain letters e.g. Avana pvt ltd');
                isValid = false;
            }

            if (!regexAddress.test(add)) {
                displayErrorMessage('add', 'Please enter a valid Address.');
                isValid = false;
            }

            if (!regexMobile.test(mobileNum)) {
                displayErrorMessage('mobileNum', 'Please enter a valid mobile number.');
                isValid = false;
            }

            if (!regexEmail.test(userName)) {
                displayErrorMessage('userName', 'Please provide a valid email address.');
                isValid = false;
            }

            if (!regexPassword.test(userPwd)) {
                displayErrorMessage('userPwd', 'Password must be at least 8 characters long(with at least 1 upper case letter).');
                isValid = false;
            }

            if (userPwd !== userComPwd) {
                displayErrorMessage('userComPwd', 'Passwords do not match.');
                isValid = false;
            }

            return isValid;
        }

        // Display error message for a specific field
        function displayErrorMessage(fieldName, message) {
            $('#' + fieldName).addClass('is-invalid');
            $('#' + fieldName).next('.invalid-feedback').text(message);
        }

        // Clear all error messages
        function clearErrorMessages() {
            $('.form-control').removeClass('is-invalid');
            $('.form-select').removeClass('is-invalid');
            $('.invalid-feedback').text('');
        }
    </script>