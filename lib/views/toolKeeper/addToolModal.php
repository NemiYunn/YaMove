<!-- add tool Modal -->
<div class="modal fade modal-md" id="tlModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Add New Tool</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="addNewToolForm">
                <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" id="des" name="des" placeholder="">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="qty" name="qty" min=0 placeholder="Enter Quantity">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_addTool" class="btn bt                                                                                               n-outline-primary">Add Tool</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->