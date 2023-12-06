<div class="row" id="adminNotiTask">
  <br><br>
  <div class="col-sm-3">
   
  </div>
  <div class="col-sm-6">
  <div class="card">
      <div class="card-body">
        <h5 class="card-title">View Reservations</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="vRes" name="vRes">click here</a>
        <span style="position: absolute; top: -11px; right: 6px; font-size: 16px; border-radius: 50%; padding: 4px 6px;" class="badge bg-danger badge-number" id="resCount">3</span>
      </div>
    </div>
  </div>
  <div class="col-sm-3">
  </div>
</div>

<script>
  // card notifi counts
  $.ajax({
    url: "../routes/notification/admin/reservationCount.php",
    method: "POST",
    success: function(res) {
      $("#resCount").text(res);
    }
  });


  $(document).ready(function() {
    // load content of cards
    $('#vRes').click(function() {
      $("#root").load('notification/adminNotify/handleReservation.php');
      $("#adminNotiTask").hide();
    });

    $('#viewEmp').click(function() {
      $("#root").load('emp/viewEmp.php');
      $("#empTask").hide();
    });

    $('#loginMng').click(function() {
      $("#root").load('emp/chooseRole.php');
      $("#empTask").hide();
    });

  });
</script>