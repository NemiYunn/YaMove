<!-- update schedule Modal -->
<div class="modal fade modal-md" id="upSchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalUpLabel">Update Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="upCloseModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="updateScheduleForm">
                    <input type="text" id="upSchId" name="upSchId" style="display:none ;">
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteNo" class="form-label">Route No</label>
                        <input type="text" class="form-control" id="rtUpNo" name="rtUpNo" placeholder="Enter Route No" disabled>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteNo" class="form-label">Schedule No</label>
                        <input type="text" class="form-control" id="schUpNo" name="schUpNo" placeholder="Enter Schedule No" disabled>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteNo" class="form-label">Bus No </label>
                        <select class="form-control rt" name="busUpNo" id="busUpNoV" required>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteOrigin" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="stTimeUp" name="stTimeUp" placeholder="Enter Start Time">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteOrigin" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="endTimeUp" name="endTimeUp" placeholder="Enter End Time">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteDesc" class="form-label">Night Stay</label>
                        <input type="text" class="form-control" id="ntStayUp" name="ntStayUp" placeholder="Enter where Night Stay at">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_upSchedule" class="btn btn-outline-primary">Update Schedule</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>