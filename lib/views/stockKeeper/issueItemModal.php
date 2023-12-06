<!-- add route Modal -->
<div class="modal fade modal-md" id="issueItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Restock Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeIssueModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="issueItemForm">
                    <input type="text" id="parts" name="parts" style="display:none">
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Bus No:</label>
                        <select class="form-control" id="bus" name="bus">

                        </select>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Quantity</label>
                        <input type="number" min=0 class="form-control" id="qty" name="qty" placeholder="Enter Quantity">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_issueItem" class="btn btn-outline-primary">Issue Item</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->

<script>
    // categories fetch
    $.ajax({
        url: "../routes/stockKeeper/getBus.php",
        method: "POST",
        data: {},
        success: function(data) {
            $("#bus").html(data);
        }
    });

</script>