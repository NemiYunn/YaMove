<div class="row" id="empTask">
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Add EMPLOYEES</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="addEmp" name="addEmp" >click here </a>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">View EMPLOYEES</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="viewEmp" >click here</a>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Login Management</h5>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <a href="#" class="btn btn-primary" id="loginMng">click here</a>
      </div>
    </div>
  </div>
</div>

<!-- <script src="../../../js/jquery.js"></script> -->
<script>
  $(document).ready(function(){
    
    $('#addEmp').click(function(){
      $("#root").load('emp/addEmp.php');
        $("#empTask").hide();    
    });

    $('#viewEmp').click(function(){
      $("#root").load('emp/viewEmp.php');
        $("#empTask").hide();    
    });

    $('#loginMng').click(function(){
      $("#root").load('emp/chooseRole.php');
        $("#empTask").hide();    
    });

  });
</script>