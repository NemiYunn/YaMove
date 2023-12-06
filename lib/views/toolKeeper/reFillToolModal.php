<!-- Modal -->
<div class="modal fade" id="fillTlModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tool Issuing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeFillModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="fillToolForm">
                    <input type="text" id="rtlId" name="rtlId" style="display:none">
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Unit price Rs.</label>
                        <input type="number" min=0 class="form-control" id="up" name="up" placeholder="Enter Unit Price (Rs.)">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Quantity</label>
                        <input type="number" min=0 class="form-control" id="Fqty" name="Fqty" placeholder="Enter Quantity">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_fillTool" class="btn btn-outline-primary">Re-Fill Tool</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>