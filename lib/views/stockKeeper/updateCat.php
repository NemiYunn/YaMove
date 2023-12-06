<!-- Add New Bus modal(whenever click on add new bus button) -->
<!-- Modal -->
<div class="modal fade modal-md" id="updateCatModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="upCloseModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="updateCatForm">
                    <input type="text" id="updCatNo" name="updCatNo" style="display:none ;">
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterBusNo" class="form-label">Category No.</label>
                        <input type="text" class="form-control" id="upCatNo" name="upCatNo" disabled>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterBusNo" class="form-label">Description </label>
                        <input type="text" class="form-control" id="upCatDes" name="upCatDes">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_updateCat" class="btn btn-outline-primary btn_update">Update</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->