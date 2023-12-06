<div class="row" id="fmnNotiTask">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">View Breakdowns</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="brk" name="brk">click here</a>
        <span style="position: absolute; top: -11px; right: 6px; font-size: 16px; border-radius: 50%; padding: 4px 6px;" class="badge bg-danger badge-number" id="brkCount">3</span>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">View Maintenece</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="mntnce">click here</a>
        <span style="position: absolute; top: -11px; right: 6px; font-size: 16px; border-radius: 50%; padding: 4px 6px;" class="badge bg-danger badge-number" id="mntCount">3</span>
      </div>
    </div>
  </div>
</div>

<script>
  // card notifi counts
  //brk count
  $.ajax({
    url: "../routes/notification/foreman/breakdwnsCount.php",
    method: "POST",
    success: function(res) {
      $("#brkCount").text(res);
    }
  });

  //maintenance count
  $.ajax({
    url: "../routes/notification/foreman/maintenanceCount.php",
    method: "POST",
    success: function(res) {
      $("#mntCount").text(res);
    }
  });


  $(document).ready(function() {
    // load content of cards
    //breakdown view
    $('#brk').click(function() {
      $("#Froot").load('notification/fmn/viewBreakdowns.php');
      $("#fmnNotiTask").hide();
    });

    //maintenance view
    $('#mntnce').click(function() {
      $("#Froot").load('notification/fmn/viewMaintenances.php');
      $("#fmnNotiTask").hide();
    });

  });
</script>