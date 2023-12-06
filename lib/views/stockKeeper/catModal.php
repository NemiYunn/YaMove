
<!-- add route Modal -->
<div class="modal fade modal-md" id="catModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="addNewCatForm">
                    <div class="form-group" style="margin-top:10px">
                        <label  class="form-label">Category No</label>
                        <input type="text" class="form-control" id="catNo" name="catNo" placeholder="Enter Category">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label  class="form-label">Category Description</label>
                        <input type="text" class="form-control" id="catDes" name="catDes" placeholder="Enter Description">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_addCat" class="btn btn-outline-primary">Add Category</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->