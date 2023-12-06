<?php
// include admin style script
include_once("../include/user_style.php");
include_once("../include/user_nav.php");
// include_once("user/home.php");
?>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<body>
    <div id="uRoot">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" id="home">

            <div class="carousel-inner">
                <div class="col-lg-4 alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Registration confirmation</h4>
                    <p>Now you can login to the system!</p>
                </div>
                <div class="carousel-item active">
                    <img class="d-block w-100" src="../images/busN.jpg" style="width:800px ; height: 600px;;" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h1>Welcome to SLTB Ududumbara</h1>
                        <a href="#sCard" class="btn btn-outline-light" style=" margin-bottom: 6%;font-size:1.5em;font-weight: 450; padding-left:75px;padding-right:75px;padding-top:30px;padding-bottom:30px;border-radius: 50px;">Book Your Seat</a>
                        <!-- <p>...</p> -->
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="../images/busN1.jpg" style="width:800px ; height: 600px;;" alt="Second slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h1>Welcome to SLTB Ududumbara</h1>
                        <a href="#sCard" class="btn btn-outline-light" style="margin-bottom: 6%;font-size:1.5em;font-weight: 450; padding-left:75px;padding-right:75px;padding-top:30px;padding-bottom:30px;border-radius: 50px;">Book Your Seat</a>
                        <!-- <p>...</p> -->
                    </div>
                </div>
                <!-- <div class="carousel-item">
        <img class="d-block w-100" src="../images/7164125.png" style="width:800px ; height: 600px;;" alt="Third slide">
        <div class="carousel-caption d-none d-md-block">
            <h1>Welcome to SLTB Ududumbara</h1>
            <a href="#sCard" class="btn btn-outline-light" style="margin-bottom: 6%;font-size:1.5em;font-weight: 450; padding-left:75px;padding-right:75px;padding-top:30px;padding-bottom:30px;border-radius: 50px;">Book Your Seat</a> -->
                <!-- <p>...</p> -->
                <!-- </div>
    </div> -->
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="a" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="a" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="card mx-auto mt-5" style="width: 60rem;" id="sCard">
            <div class="card-header">
                <h4>Book Your Seat</h4>
            </div>
            <div class="card-body" id="cBody">
                <div class="row">
                    <div class=" mb-3 col-md-4">
                        <select class="form-control cc1" name="cc" id="From">
                        </select>
                        <small id="fromVal" style="color: red;">Please Select a Route</small>
                    </div>
                    <div class=" mb-3 col-md-4">
                        <select class="form-control cc1" name="cc" id="To" required>
                        </select>
                        <small id="toVal" style="color: red;">Please Select a Route</small>
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control cc" id="dateF" required>
                        <small id="dateVal" style="color: red;">Please Select a Date</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <!-- <input type="Number" min='1' max='5' class="form-control cc" id="noPas" placeholder="No of Passengers" required>
                        <small id="pasVal" style="color: red;">Please Enter No of Passengers</small> -->
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-outline-info mt-4 sh" id="search">Search</button>
                        <button type="button" class="btn btn-outline-secondary mt-4 reset" id="reset">Reset</button>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br>

        <section id="services" class="py-5">
            <div class="container">
                <h1 class="text-center mb-5">Our Services</h1>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card">
                            <!-- <img src="service1.jpg" class="card-img-top" alt="Service 1"> -->
                            <div class="card-body">
                                <h5 class="card-title">Service 1</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut elit sed nisl consequat tristique.</p>
                                <a href="#" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card">
                            <!-- <img src="service2.jpg" class="card-img-top" alt="Service 2"> -->
                            <div class="card-body">
                                <h5 class="card-title">Service 2</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut elit sed nisl consequat tristique.</p>
                                <a href="#" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card">
                            <!-- <img src="service3.jpg" class="card-img-top" alt="Service 3"> -->
                            <div class="card-body">
                                <h5 class="card-title">Service 3</h5>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut elit sed nisl consequat tristique.</p>
                                <a href="#" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <br>
        <div class="row">
            <div class="card mb-3">
                <img src="../images/stock.jpg" class="card-img-top" alt="store" style="height:350px ;">
                <div class="card-body">
                    <center>
                        <h4 class="card-title">Connect with Island wide Suppliers</h4>
                        <p class="card-text">"Daily requirements for the depot will be uploaded on this site, and as a supplier, you have the opportunity to submit your quotation and collaborate with us."</p>
                        <!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                        <a  href="RFQ.php" class="btn btn-primary">View RFQs</a>
                    </center>
                </div>
            </div>

        </div> <br><br><br>

        <section id="about" class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-5">About Us</h2>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Ududumbara Depot</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut elit sed nisl consequat tristique.</p>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <h4>Testimonials</h4>
                        <div id="carouselTestimonials" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <p class="testimonial-text">"Great service! Highly recommended."</p>
                                    <p class="testimonial-author">- John Mare</p>
                                </div>
                                <div class="carousel-item">
                                    <p class="testimonial-text">"Excellent team and quality work!"</p>
                                    <p class="testimonial-author">- Anna Claris</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <hr>
                    <div class="col-md-6" id="contact">
                        <h4>Contact Us</h4>
                        <form>
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Name</label>
                                <input type="text" class="form-control" id="nameInput" placeholder="Enter your name">
                            </div>
                            <div class="mb-3">
                                <label for="emailInput" class="form-label">Email</label>
                                <input type="email" class="form-control" id="emailInput" placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <label for="messageInput" class="form-label">Message</label>
                                <textarea class="form-control" id="messageInput" rows="4" placeholder="Enter your message"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-dark text-light text-center py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h5>Additional Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="RFQ.php">RFQ</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Service</a></li>
                            <li><a href="#">FAQs</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Follow Us</h5>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <p>&copy; 2023 SLTB, Ududumbara Depot. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>



    <script>
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        $tday = yyyy + '-' + mm + '-' + dd;
        $tday.toString();

        $("#dateF").attr("min", $tday);

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
                url: "../routes/user/verify.php",
                method: "POST",
                data: {
                    email: mail,
                    vcode: vcode
                },
                success: function(data) {
                    if (data == '1') {
                        alert("User Verified Successfully!");
                        // not working below part, i just want to send parameter wth login url and show "account activated" for the first time login
                        // $("#login").click(function(e) {
                        // 	e.preventDefault();
                        // 	header('location:../lib/views/user/login.php?time=1');
                        // });

                    } else if (data == '0') {
                        alert("Sorry! Verification failed.");
                    }

                }
            });


            $.ajax({
                url: "../routes/user/searchRouteFrom.php",
                method: "POST",
                success: function(data) {
                    $("#From").html(data);
                }
            });
            $.ajax({
                url: "../routes/user/searchRouteTo.php",
                method: "POST",
                success: function(data) {
                    $("#To").html(data);
                }
            });

            $(document).on("click", ".reset", function() {
                $('.cc').val('');
                $('select').each(function() {
                    $(this).val($(this).find("option[selected]").val());
                })
            });

            $from = "";
            $to = "";
            $date = "";
            // $noPas="";

            $("#fromVal").hide();
            $("#toVal").hide();
            $("#dateVal").hide();
            $("#pasVal").hide();

            $("#From").on("change", function() {
                $from = $(this).val();
                // alert($from);
            });
            $("#To").on("change", function() {
                $to = $(this).val();
            });
            $("#dateF").on("input", function() {
                $date = $(this).val();
            });
            // $("#noPas").on("input", function() {
            //     $noPas = $(this).val();
            // });

            $(document).on("click", ".sh", function() {
                if ($from != "" && $to != "" && $date != "") {
                    // alert(1);
                    $("#uRoot").load("user/user.php");
                } else if ($from == "" && $to != "" && $date != "") {
                    $("#fromVal").show();
                } else if ($from != "" && $to == "" && $date != "") {
                    $("#toVal").show();
                } else if ($from != "" && $to != "" && $date == "") {
                    $("#dateVal").show();
                } else {
                    $("#fromVal").show();
                    $("#toVal").show();
                    $("#dateVal").show();
                }

            });

            $(document).on("click", ".changeSearch", function() {
                $("#uRoot").load("user/searchCard.php");
            });

        })
    </script>