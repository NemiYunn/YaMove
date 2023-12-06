<!-- Modal -->
<div class="modal fade modal-md" id="upRouteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="upModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="upCloseModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="updateRouteForm">
                    <input type="text" id="rtUpId" name="rtUpId" style="display:none ;">
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteNo" class="form-label">Route No</label>
                        <input type="text" class="form-control" id="rtUpNo" name="rtUpNo" placeholder="Enter Route No">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteOrigin" class="form-label">Origin</label>
                        <input type="text" class="form-control" id="rtUpStarts" name="rtUpStarts" placeholder="Enter Route Origin">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteDestination" class="form-label">Destination</label>
                        <input type="text" class="form-control" id="rtUpEnds" name="rtUpEnds" placeholder="Enter Route Destination">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteDesc" class="form-label">Distance in Km</label>
                        <input type="number" class="form-control c1" id="rtUpDes" name="rtUpDes" placeholder="Enter Distance in Km">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_updateRoute" class="btn btn-outline-primary">Update Route</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->