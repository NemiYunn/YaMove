<!-- Modal -->
<div class="modal fade modal-md" id="tripModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="haltModalLabel">Add New Trip &nbsp;&nbsp; schedule No : <?php echo ($_GET['schNo']); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="addNewTripForm">
                <input type="text" id="schNo" name="schNo" value="<?php echo ($_GET['schNo']); ?>"  style="display:none ;" >
                   
                    <div class="form-group" style="margin-top:10px">
                        <label for="Dep" class="form-label">From:</label>
                        <input type="text" class="form-control" id="depFrom" name="depFrom" placeholder="Enter Departure From">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="Dep" class="form-label">Departure time:</label>
                        <input type="time" class="form-control" id="depAt" name="depAt" placeholder="Enter Departure Time">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="Arrival" class="form-label">To:</label>
                        <input type="text" class="form-control" id="arrTo" name="arrTo" placeholder="Enter Arrival In">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="Arrival" class="form-label">Arrival Time:</label>
                        <input type="time" class="form-control" id="arrAt" name="arrAt" placeholder="Enter Arrival Time">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_addTrp" class="btn btn-outline-primary">Add Trip</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->