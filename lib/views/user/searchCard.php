<div class="card mx-auto mt-5" style="width: 60rem;" id="sCard">
    <div class="card-header">
        <h4>Book Your Seat</h4>
    </div>
    <div class="card-body" id="cBody">
        <div class="row">
            <div class=" mb-3 col-md-4">
                <select class="form-control cc1" name="cc" id="From" required>
                </select>
            </div>
            <div class=" mb-3 col-md-4">
                <select class="form-control cc1" name="cc" id="To" required>
                </select>
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control cc" id="dateF" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <button type="button" class="btn btn-outline-info mt-4 sh" id="search">Search</button>
                <button type="button" class="btn btn-outline-secondary mt-4 reset" id="reset">Reset</button>
            </div>
        </div>
    </div>
</div>

<script>
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

    $from = "";
    $to = "";
    $date = "";
    // $noPas = "";

    $("#fromVal").hide();
    $("#toVal").hide();
    $("#dateVal").hide();
    // $("#pasVal").hide();

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
        if ($from != "" && $to != "" && $date != "" ) {
            // alert(1);
            $("#uRoot").load("user/user.php");
        } else if ($from == "" && $to != "" && $date != "" ) {
            $("#fromVal").show();
        } else if ($from != "" && $to == "" && $date != "" ) {
            $("#toVal").show();
        } else if ($from != "" && $to != "" && $date == "" ) {
            $("#dateVal").show();
        } else {
            $("#fromVal").show();
            $("#toVal").show();
            $("#dateVal").show();
        }
    });

   

</script>