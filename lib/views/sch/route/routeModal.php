
<!-- add route Modal -->
<div class="modal fade modal-md" id="routeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Add New Route</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="addNewRouteForm">
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteNo" class="form-label">Route No</label>
                        <input type="text" class="form-control" id="rtNo" name="rtNo" placeholder="Enter Route No">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteOrigin" class="form-label">Origin</label>
                        <input type="text" class="form-control" id="rtStarts" name="rtStarts" placeholder="Enter Route Origin">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteDestination" class="form-label">Destination</label>
                        <input type="text" class="form-control" id="rtEnds" name="rtEnds" placeholder="Enter Route Destination">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteDesc" class="form-label">Distance in Km</label>
                        <input type="number" min=0 class="form-control c1" id="rtDes" name="rtDes" placeholder="Enter Distance in Km">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_addRoute" class="btn btn-outline-primary">Add Route</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->