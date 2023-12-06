<!-- add route Modal -->
<div class="modal fade modal-md" id="rfqModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Request For Quotation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="rfqForm">
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Part No.</label>
                        <input type="text" class="form-control" id="partNo" name="partNo" disabled>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Required Quantity </label>
                        <input type="number" class="form-control" min=0 id="Rqty" name="Rqty" placeholder="Add Quantity">
                        <span id="type"> </span>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Closing date</label>
                        <input type="date" class="form-control" id="Ldate" name="Ldate">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_rfq" class="btn btn-outline-primary">Send RFQ</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->