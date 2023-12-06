<div class="row" id="tcnNotiTask">
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">View Breakdowns</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="brk" name="brk">click here</a>
        <span style="position: absolute; top: -11px; right: 6px; font-size: 16px; border-radius: 50%; padding: 8px 10px;" class="badge bg-danger badge-number" id="brkCount">3</span>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">View Maintenance</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="mntnce">click here</a>
        <span style="position: absolute; top: -11px; right: 6px; font-size: 16px; border-radius: 50%; padding: 8px 10px;" class="badge bg-danger badge-number" id="mntCount">3</span>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">View Late Returns</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="ltrns">click here</a>
        <span style="position: absolute; top: -11px; right: 6px; font-size: 16px; border-radius: 50%; padding: 8px 10px;" class="badge bg-danger badge-number" id="lrCount">3</span>
      </div>
    </div>
  </div>
</div>

<script>
  // card notifi counts
  //late retuns count
  $.ajax({
    url: "../routes/notification/tcn/lateReturnsCount.php",
    method: "POST",
    success: function(res) {
      $("#lrCount").text(res);
    }
  });

  //breakdwns count
  $.ajax({
    url: "../routes/notification/tcn/breakdownCount.php",
    method: "POST",
    success: function(res) {
      $("#brkCount").text(res);
    }
  });
  //maintenance count
  $.ajax({
    url: "../routes/notification/tcn/maintenanceCount.php",
    method: "POST",
    success: function(res) {
      $("#mntCount").text(res);
    }
  });


  $(document).ready(function() {
    // load content of cards
    //lateReturns view
    $('#ltrns').click(function() {
      $("#TCNroot").load('notification/tcn/viewLateReturns.php');
      $("#tcnNotiTask").hide();
    });

    //breakdown view
    $('#brk').click(function() {
      $("#TCNroot").load('notification/tcn/viewAssignedBreakdowns.php');
      $("#empTask").hide();
    });

    //maintenance view
    $('#mntnce').click(function() {
      $("#TCNroot").load('notification/tcn/viewAssignedMaintenances.php');
      $("#empTask").hide();
    });

  });
</script>