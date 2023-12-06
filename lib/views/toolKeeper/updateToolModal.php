<!-- add tool Modal -->
<div class="modal fade modal-md" id="updateToolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Edit Tool Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="upCloseModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="upToolForm">
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Tool Id</label>
                        <input type="text" class="form-control" id="id" name="id" >
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="Uname" name="Uname" >
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" id="Udes" name="Udes" >
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="Uqty" name="Uqty" min=0 disabled>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_upTool" class="btn btn-outline-primary">Update Tool</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->