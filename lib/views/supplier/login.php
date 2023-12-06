
<?php
include_once("../../include/user_style.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
</head>

<body>

    <section class="vh-100" style="background-color: #9A616D;">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col col-xl-7">
                    <div class="card mt-2" style="border-radius: 1rem;">
                        <div class="row">

                            <div class="col-lg-3">
                            </div>
                            <div class="col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <img src="../../images/logo.png" width="160px" height="90px" alt="" class="center">
                                    </div>
                                    <!-- form -->
                                    <form action="<?php echo ($_SERVER['PHP_SELF']); ?>" id="userLogForm">
                                        <h4 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h5>

                                            <div class="form-outline mb-4">
                                                <!-- <label class="form-label" for="form2Example17">Email address</label> -->
                                                <input type="email" id="username" name="username" class="form-control form-control-lg" placeholder="Email address" />

                                            </div>

                                            <div class="form-outline mb-4">
                                                <!-- <label class="form-label" for="form2Example27">Password</label> -->
                                                <input type="password" id="userpwd" name="userpwd" class="form-control form-control-lg" placeholder="Password" />

                                            </div>

                                            <div class="pt-1 mb-4">
                                                <input type="submit" value="Login" class="btn btn-dark btn-lg btn-block" name="lg_btn" id="login" />
                                                <!-- <button class="btn btn-dark btn-lg btn-block" type="submit" id="login" name="lg_btn">Login</button> -->
                                            </div>

                                            <a class="small text-muted" href="#!">Forgot password?</a>
                                            <p class="mb-5 pb-lg-2 mt-2" style="color: #393f81;">Don't have an account? <a href="reg.php" style="color: #393f81;">Register here</a></p>
                                            <!-- <a href="#!" class="small text-muted">Terms of use.</a>
                  <a href="#!" class="small text-muted">Privacy policy</a> -->
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>

<script>
   $('#login').click(function(e){
        e.preventDefault();
        var form = $('#userLogForm')[0];
        var formData = new FormData(form);
        // console.log(formData);

        $.ajax({
            url:'../../routes/supplier/userLog.php',
            type:'POST',
            data:formData,
            processData:false,
            contentType:false,
            success: function(data){
                    if(data == 1){
                        window.location.href = "../RFQ.php";
                    }else{
                        alert(data);
                    }
            },
            error: function(){

            } 
       });
    })
</script>