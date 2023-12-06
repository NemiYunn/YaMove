<!-- add schedule Modal -->
<div class="modal fade modal-md" id="schModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Add New Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="addNewScheduleForm">
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteNo" class="form-label">Route No</label>
                        <select class="form-control rt" name="rtNo" id="rtNoV" required>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteNo" class="form-label">Schedule No</label>
                        <input type="text" class="form-control" id="schNo" name="schNo" placeholder="Enter Schedule No">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteNo" class="form-label">Bus No</label>
                        <select class="form-control rt" name="busNo" id="busNoV" required>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteOrigin" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="picker" name="stTime" placeholder="Enter Start Time">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteOrigin" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="picker2" name="endTime" placeholder="Enter End Time">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterRouteDesc" class="form-label">Night Stay</label>
                        <input type="text" class="form-control" id="ntStay" name="ntStay" placeholder="Enter where Night Stay at">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_addSchedule" class="btn btn-outline-primary">Add Schedule</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->

<!-- <script>
    $(document).ready(function() {

        

    })
</script> -->