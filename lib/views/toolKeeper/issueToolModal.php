<!-- Modal -->
<div class="modal fade" id="issueTlModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tool Issuing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeIssueModal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="issueToolForm">
          <input type="text" id="tlId" name="tlId" style="display:none">
          <div class="form-group" style="margin-top:10px">
            <label class="form-label">Emp No</label>
            <select class="form-control" id="emp" name="emp">

            </select>
          </div>
          <div class="form-group" style="margin-top:10px">
            <label class="form-label">Quantity</label>
            <input type="number" min=0 class="form-control" id="qty" name="qty" placeholder="Enter Quantity">
          </div>
          <div class="form-group" style="margin-top:10px">
            <button type="button" id="btn_issueTool" class="btn btn-outline-primary">Issue Tool</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // categories fetch
  $.ajax({
    url: "../routes/toolKeeper/getEmp.php",
    method: "POST",
    data: {},
    success: function(data) {
      $("#emp").html(data);
    }
  });
</script>