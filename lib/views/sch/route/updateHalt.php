<!-- Modal -->
<div class="modal fade modal-md" id="upHaltModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="upHltModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="upCloseModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="updateHaltForm">
                    <input type="text" id="hltUpId" name="hltUpId" style="display:none ;">
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterHaltname" class="form-label">Halt Name</label>
                        <input type="text" class="form-control" id="hltUpName" name="hltUpName" placeholder="Enter Halt New Name">
                    </div>
                    <!-- <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteNo" class="form-label">Halt Next</label>
                        <input type="text" class="form-control" id="hltUpNext" name="hltUpNext" placeholder="Enter Halt New Name">
                    </div> -->
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteOrigin" class="form-label">KMs</label>
                        <input type="text" class="form-control" id="hltUpDis" name="hltUpDis" placeholder="Enter Halt Distance">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteDestination" class="form-label">Section No</label>
                        <input type="text" class="form-control" id="secUpNo" name="secUpNo" placeholder="Enter Section No" >
                    </div>
        
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_updateHalt" class="btn btn-outline-primary">Update Halt</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->