<div id="empSchedule">
<div class="row">
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Schedule Management</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="mngSchedule" name="mngSchedule">click here </a>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Roster Management</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="mngRoster">click here</a>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Routes Management</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="mngRoute">click here</a>
      </div>
    </div>
  </div>
</div>
<br> <br>
<div class="row">
  <div class="col-sm-4"></div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Duty Management</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="mngDuty">click here</a>
      </div>
    </div>
  </div>
</div>
</div>

<!-- <script src="../../../js/jquery.js"></script> -->
<script>
  $(document).ready(function() {

    $('#mngSchedule').click(function() {
      $("#root").load('sch/Schedule/manageSchedules.php');
      $("#empSchedule").hide();
    });

    $('#mngRoster').click(function() {
      $("#root").load('sch/Roster/manageRosters.php');
      $("#empSchedule").hide();
    });

    $('#mngRoute').click(function() {
      $("#root").load('sch/route/manageRoutes.php');
      $("#empSchedule").hide();
    });

    $('#mngDuty').click(function() {
      $("#root").load('sch/duty/manageDuties.php');
      $("#empSchedule").hide();
    });


  });
</script>