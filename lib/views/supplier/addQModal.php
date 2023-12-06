<style>
    .form-group {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    /* Style for the labels */
    .form-group label.form-label {
        flex: 0 0 auto;
        margin-right: 10px;
        text-align: left;
    }

    /* Style for the wrapper div around the spans */
    .form-group .span-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<!-- Add route Modal -->
<div class="modal fade modal-md" id="qModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Add Quotation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="addNewQForm">
                    <div class="form-group" style="margin-top:10px">
                        <input type="text" class="form-control" id="rfqNo" name="rfqNo" style="display: none;">
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Item Name: </label> <br>
                            <label class="form-label">Category: </label> <br>
                            <label class="form-label">Quantity: </label> <br>
                            <label class="form-label">Closing Date: </label>
                        </div>
                        <div class="col-md-4">
                            <b> <label class="form-label" id="itName" name="itName">blah</label> </b> <br>
                            <b> <label class="form-label" id="itCat" name="itCat">blah</label> </b> <br>
                            <b> <label class="form-label" id="qty" name="qty">blah</label> </b> <br>
                            <b> <label class="form-label" id="date" name="date">blah</label> </b>
                        </div>
                    </div><b>
                        <div class="form-group" style="margin-top:10px">
                            <label class="form-label">Unit Price  (Rs.)</label>
                            <input type="text" class="form-control" id="uPrice" name="uPrice" placeholder="Enter price per unit">
                        </div>
                        <div class="form-group" style="margin-top:10px">
                            <button type="button" id="btn_addQ" class="btn btn-outline-primary">Add Quotation</button>
                        </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->

<script>
    $rfqNo = $("#rfqNo").val();

    
</script>