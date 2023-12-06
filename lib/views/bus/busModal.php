<!-- Add New Bus and View modal(whenever click on add new bus button) -->
<!-- Modal -->
<div class="modal fade modal-md" id="busModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Add New Bus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="addNewBusForm">
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterBusNo" class="form-label">Bus No</label>
                        <input type="text" class="form-control c1" id="busNo" name="busNo" placeholder="Enter Bus No">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourEmail" class="form-label">Bus Type</label>
                        <input class="form-control c1" list="busTypes" name="busType" id="busType" placeholder="Enter Bus Type">
                        <datalist id="busTypes">
                            <option value="Tata">
                            <option value="Japanese">
                            <option value="Blabla">
                        </datalist>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourPhone" class="form-label">Bus Grade</label>
                        <select class="form-select c1" aria-label="Default select example" name="busGrade" id="busGrade">
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
                        <label  class="form-label">Category</label>
                        <select class="form-select c1" aria-label="Default select example" name="busCatag" id="busCatag">
                            <option selected disabled>Choose Bus Category</option>
                            <option value="Normal">Normal</option>
                            <option value="Intersity">Intersity</option>
                            <option value="Semi Luxury">Semi Luxuary</option>
                            <option value="Luxury">Luxuary</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourPhone" class="form-label">No of Seats</label>
                        <input type="number" class="form-control c1" id="busSeats" name="busSeats" placeholder="Enter No of Seats">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourPhone" class="form-label">KiloMeters (run this far)</label>
                        <input type="number" class="form-control c1" id="busKms" name="busKms" placeholder="Enter Bus Kms">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourPhone" class="form-label">Bus State</label>
                        <select class="form-select c1" aria-label="Default select example" name="busState" id="busState">
                            <option selected disabled>Choose Bus State</option>
                            <option value="onOperate">on Operate</option>
                            <option value="onMaintenance">on Maintenance</option>
                        </select>
                    </div>


                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_addBus" class="btn btn-outline-primary btn_add">Add Bus</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->