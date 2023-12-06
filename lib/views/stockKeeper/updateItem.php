<!-- add route Modal -->
<div class="modal fade modal-md" id="updateItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Update Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="upCloseModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="upItmForm">
                     <input type="text" id="uppartNo" name="uppartNo" style="display:none ;">
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Category No</label>
                        <select class="form-control" id="upcats" name="upcats">

                        </select>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Part No.</label>
                        <input type="text" class="form-control" id="uppartNom" name="uppartNom" placeholder="Ex. NPN-01" disabled>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" id="updes" name="updes" placeholder="Item Name">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Unit Type</label>
                        <select class="form-control" id="uptype" name="uptype">
                            <option value="" selected> Select Unit Type:</option>
                            <option value="Kg">Kilo gram</option>
                            <option value="l">Literes</option>
                            <option value="m">Meters</option>
                            <option value="u">Units</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Unit of Issues</label>
                        <input type="number" min=0 class="form-control" id="upunit" name="upunit" placeholder="Enter Number">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Minimum Stock Level</label>
                        <input type="number" min=0 class="form-control" id="uplevel" name="uplevel" placeholder="Enter Number">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_upItem" class="btn btn-outline-primary">Update Item</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->

<script>
     $.ajax({
        url: "../routes/stockKeeper/getCategories.php",
        method: "POST",
        data: {},
        success: function(data) {
            $("#upcats").html(data);
        }
    });
</script>