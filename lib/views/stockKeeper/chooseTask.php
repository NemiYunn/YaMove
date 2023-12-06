<div class="row" id="Task">

  <div class="row">
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Manage Categories</h5>
          <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
          <a href="#" class="btn btn-primary" id="cat" name="cat">click here </a>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Manage Items</h5>
          <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
          <a href="#" class="btn btn-primary" id="item">click here</a>
        </div>
      </div>
    </div>

  </div> <br><br>
  <div class="row mt-4">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">View Stock Remains</h5>
          <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
          <a href="#" class="btn btn-primary" id="stkRemain">click here</a>
        </div>
      </div>
    </div>
    <div class="col-sm-4"></div>
  </div>
</div>

<!-- <script src="../../../js/jquery.js"></script> -->
<script>
  $(document).ready(function() {

    $('#cat').click(function() {
      $("#SKroot").load('stockKeeper/manageCategories.php');
      $("#Task").hide();
    });

    $('#item').click(function() {
      $("#SKroot").load('stockKeeper/manageItems.php');
      $("#Task").hide();
    });

    $('#stkRemain').click(function() {
      $("#SKroot").load('stockKeeper/stockRemain.php');
      $("#Task").hide();
    });


    $('#loginMng').click(function() {
      $("#root").load('stockKeeper/manageTires.php');
      $("#Task").hide();
    });

  });
</script>