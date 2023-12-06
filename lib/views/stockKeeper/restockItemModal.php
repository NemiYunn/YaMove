<!-- add route Modal -->
<div class="modal fade modal-md" id="restockItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Restock Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeRskModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="restockItemForm">

                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Part No.</label>
                        <select class="form-control" id="parts" name="parts">

                        </select>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="qty"  min=0 name="qty" placeholder="Enter Quantity">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Unit Price (Rs.) </label>
                        <input type="number" class="form-control" id="price" min=0 name="price" placeholder="Rs. ">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_restockItem" class="btn btn-outline-primary">Restock Item</button>
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
        url: "../routes/stockKeeper/getParts.php",
        method: "POST",
        data: {},
        success: function(data) {
            $("#parts").html(data);
        }
    });
</script>