<!-- Modal -->
<div class="modal fade modal-md" id="secFUpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
            <h5 class="modal-title" id="haltModalLabel">Add New Section</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeUpModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="updateSecFareForm">
                    <div class="form-group" style="margin-top:10px">
                        <label for="Dep" class="form-label">Old Minimum Section Fare: (RS.)</label>
                        <input type="text" class="form-control" id="secOldFare" name="secOldFare" placeholder="Rs. ">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="Dep" class="form-label">New Minimum Section Fare: (RS.)</label>
                        <input type="text" class="form-control" id="secNewFare" name="secNewFare" placeholder="Rs. ">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_upSecF" class="btn btn-outline-primary">Update Fare</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->