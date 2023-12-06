<!-- Modal -->
<div class="modal fade modal-md" id="secFModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
            <h5 class="modal-title" id="haltModalLabel">Add New Section</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="addNewSecForm">
                    <div class="form-group" style="margin-top:10px">
                        <label for="Dep" class="form-label">Section No:</label>
                        <input type="Number" class="form-control" id="secNo" name="secNo" placeholder="Enter Section No">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="Dep" class="form-label">Section Fare: (RS.)</label>
                        <input type="text" class="form-control" id="secFare" name="secFare" placeholder="Enter Section Fare Rs. ">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_addSecF" class="btn btn-outline-primary">Add Section</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->