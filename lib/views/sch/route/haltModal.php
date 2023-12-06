<!-- Modal -->
<div class="modal fade modal-md" id="haltModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="haltModalLabel">Add New Halt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="addNewHaltForm">
                    <input type="text" id="hltId" name="hltId" style="display:none ;">
                   
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteNo" class="form-label">Halt Name</label>
                        <input type="text" class="form-control" id="hltName" name="hltName" placeholder="Enter Halt Name">
                    </div>
                    <!-- <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteNo" class="form-label">Halt Next</label>
                        <input type="text" class="form-control" id="hltNext" name="hltNext" placeholder="Enter Next Halt name">
                    </div> -->
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteOrigin" class="form-label">KMs</label>
                        <input type="text" class="form-control" id="hltDis" name="hltDis" placeholder="Enter Distance in KM">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteDestination" class="form-label">Section No</label>
                        <input type="text" class="form-control" id="secNo" name="secNo" placeholder="Enter halt Sec no">
                    </div>
        
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_addHalt" class="btn btn-outline-primary">Add Halt</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->