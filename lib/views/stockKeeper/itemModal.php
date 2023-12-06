<!-- add route Modal -->
<div class="modal fade modal-md" id="itmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootstrap modal body start -->
                <form id="addNewItmForm">
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Category No</label>
                        <select class="form-control" id="cats" name="cats">

                        </select>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Part No.</label>
                        <input type="text" class="form-control" id="partNo" name="partNo" placeholder="Ex. NPN-01">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Item image</label>
                        <input type="file" class="form-control" id="itmPic" name="itmPic">
                        <img src="" alt="itemPreview" id="itmPicPreview" class="img-responsive rounded">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" id="des" name="des" placeholder="Item Name">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Unit Type</label>
                        <select class="form-control" id="type" name="type">
                            <option value="" selected> Select Unit Type:</option>
                            <option value="Kg">Kilo gram</option>
                            <option value="l">Literes</option>
                            <option value="m">Meters</option>
                            <option value="u">Units</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Unit of Issues</label>
                        <input type="number" class="form-control" id="unit" name="unit" min=0 placeholder="Enter Number">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label class="form-label">Minimum Stock Level</label>
                        <input type="number" class="form-control" id="level" name="level" min=0 placeholder="Enter Number">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_addItem" class="btn btn-outline-primary">Add Item</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->

<script>
    // categories fetch


    $.ajax({
        url: "../routes/stockKeeper/getCategories.php",
        method: "POST",
        data: {},
        success: function(data) {
            $("#cats").html(data);
        }
    });


    // item picture preview
    $('#itmPic').change(function() {
    var read = new FileReader();
    read.onload = function(e) {
        $('#itmPicPreview').attr("src", e.target.result);
        $('#itmPicPreview').attr("style", "height:150px;width:150px;margin-top:8px");
    }
    read.readAsDataURL(this.files[0]);
    })
    
</script>