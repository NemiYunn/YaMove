
<div class="col-md-2"></div>
<div id="cardDetails" class="col-md-7">
    <div class="card" id="pay">
        <div class="card-header ">
            Secure Payment <i class="fa fa-lock" aria-hidden="true"></i>
        </div>

        <div class="card-body">
            <div class=" row mt-2">
                <label class="form-label"><b>Card Number </b> <span style="color:red">*</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="cardNo">
                </div>
            </div>
            <img src="../images/visa.png" alt="visa" style="width:30px; height:30px">
            &nbsp;&nbsp;
            <img src="../images/mcard.png" alt="mcard" style="width:30px; height:30px">
            <br>
            <small id="cardNoV" style="color: red;">Please Enter your Card number</small>
            <div class="row mt-2">
                <div class="col-md-3">
                    <label class="form-label"><b>Expiry month </b> <span style="color:red">*</span></label>
                    <select class="form-select" aria-label="Default select example" id="exMonth">
                        <option selected>MM</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <small id="exMonthV" style="color: red;">Please select the Expiry Month</small>
                <div class="col-md-2">
                    <label class="form-label"><b>Expiry year </b> <span style="color:red">*</span></label>
                    <select class="form-select" aria-label="Default select example" id="exYear">
                        <option selected>YY</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                        <option value="32">32</option>
                        <option value="33">33</option>
                    </select>
                </div>
                <small id="exYearV" style="color: red;">Please select the Expiry Year</small>
            </div>
            <div class="row mt-2">
                <div class="col-md-5">
                    <label class="form-label"><b>Cardholder name </b> <span style="color:red">*</span></label>
                    <input type="email" class="form-control" id="cardHName">
                </div>
                <small id="cardHNameV" style="color: red;">Please Enter Card Holde's Name</small>
            </div>
            <div class="row mt-2">
                <label class="form-label"><b>Security code </b> <span style="color:red">*</span></label>
                <div class="col-md-1">
                    <input type="email" class="form-control" id="cardSec" maxlength="3">
                </div>
                <div class="col-md-4">
                    <i class="fa fa-credit-card-alt" aria-hidden="true"></i> 3 digits on back of your card
                </div>
            </div>
            <small id="cardSecV" style="color: red;">Please Enter 3 Digit Security Code</small>
        </div>
        <div class="card-footer ">
            <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-4">
                    <b>
                        <center> <label for="totPrice">Total - LKR : &nbsp;&nbsp; <span id="totPricePay"> </span> </label></center>
                    </b>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-outline-secondary reset" id="reset">Cancel</button>
                    <button type="button" class="btn btn-outline-success pay" id="pay">Pay Now</button>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="col-md-3">
    <div style="width:300px; height:80px; background-color:beige; padding:8px" id="timer">     
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "../routes/user/getFare.php",
            method: "POST",
            data: {
                boarding: $boarding,
                dropping: $dropping,
                NoofPassengers: $noOfSeats,
            },
            success: function(data) {
                $("#totPricePay").html(data);
            }
        });

        // check form filled or not and validity
        $cardNo = "";
        $exM = "";
        $exY = "";
        $cardHName = "";
        $cardSec = "";

        $("#cardNoV").hide();
        $("#exMonthV").hide();
        $("#exYearV").hide();
        $("#cardHNameV").hide();
        $("#cardSecV").hide();

        $("#exMonth").on("change", function() {
            $exM = $(this).val();
            // alert($from);
        });
        $("#exYear").on("change", function() {
            $exY = $(this).val();
        });
        $("#cardNo").on("input", function() {
            $cardNo = $(this).val();
        });
        $("#cardHName").on("input", function() {
            $cardHName = $(this).val();
        });
        $("#cardSec").on("input", function() {
            $cardSec = $(this).val();
        });

    })

    $("#timer").load("user/timer.php");
</script>