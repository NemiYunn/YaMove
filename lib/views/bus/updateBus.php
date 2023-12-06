<!-- Add New Bus modal(whenever click on add new bus button) -->
<!-- Modal -->
<div class="modal fade modal-md" id="updateBusModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Update Bus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="upCloseModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="updateBusForm">
                    <input type="text" id="upBusId" name="upBusId" style="display:none ;">
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterBusNo" class="form-label">Bus No</label>
                        <input type="text" class="form-control" id="upBusNo" name="upBusNo" placeholder="Enter Bus No" disabled>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourEmail" class="form-label">Bus Type</label>
                        <input class="form-control" list="busTypes" name="upBusType" id="upBusType" placeholder="Enter Bus Type">
                        <datalist id="busTypes">
                            <option value="Tata">
                            <option value="Japanese">
                            <option value="Blabla">
                        </datalist>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourPhone" class="form-label">Bus Grade</label>
                        <select class="form-select" aria-label="Default select example" name="upBusGrade" id="upBusGrade">
                            <option selected disabled>Select Bus Grade</option>
                            <option value="A">A</option>
                            <option value="B+">B+</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourPhone" class="form-label">Bus Category</label>
                        <select class="form-select " aria-label="Default select example" name="upBusCategory" id="upBusCategory">
                            <option selected disabled>Choose Bus Category</option>
                            <option value="Normal">Normal</option>
                            <option value="Intersity">Intersity</option>
                            <option value="Semi Luxury">Semi Luxuary</option>
                            <option value="Luxury">Luxuary</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourPhone" class="form-label">No of Seats</label>
                        <input type="number" class="form-control " id="upBusSeats" name="upBusSeats" placeholder="Enter No of Seats">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourPhone" class="form-label">KiloMeters (run this far)</label>
                        <input type="number" class="form-control " id="upBusKms" name="upBusKms" placeholder="Enter Bus Kms">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourPhone" class="form-label">Bus State</label>
                        <select class="form-select " aria-label="Default select example" name="upBusState" id="upBusState">
                            <option selected disabled>Choose Bus State</option>
                            <option value="onOperate">on Operate</option>
                            <option value="onMaintenance">on Maintenance</option>
                        </select>
                    </div>
                    

                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_updateBus" class="btn btn-outline-primary btn_update">Update</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->