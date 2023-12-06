<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header">
        View Employees
    </div>
    <div class="card-body">
        <a href="" class="btn btn-outline-success btn-md pull-right no-print" title="print" onclick="window.print();">Print</a>
        <form class="row g-2 mt-1 mb-1 no-print">
            <div class="col-4">
                <!-- <label for="search" class="vissually-hidden">Search</label> -->
                <input type="search" class="form-control  mt-1 mb-1 " id="searchValue" placeholder="Search">
            </div>
        </form>
        <div id="get_data" class="table-responsive-md">

        </div>
        <br><br>
        <div class="row">
            <div class="col-md-9">
                <button class="btn btn-primary no-print" id="btn_back" style="position:absolute; left:10px;bottom:10px;"> Back </button>
            </div>
        </div>
    </div>
</div>

<!-- update modal(whenever click on update button) -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- bootsttap modal body start -->
                <form id="userEditForm">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="editId" name="editId" placeholder="Enter Your Id">

                        <label for="formFile" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="editProfilePic" name="editProfilePic">
                        <img src="" alt="profilePicturePreview" id="profilePicturePreview" class="img-responsive rounded">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourName" class="form-label">EMP Name</label>
                        <input type="text" class="form-control" id="editName" name="editName" placeholder="Enter Your Name">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourEmail" class="form-label">EMP Email Address</label>
                        <input type="email" class="form-control" id="editEmail" name="editEmail" placeholder="Enter Your Email">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourPhone" class="form-label">EMP Phone</label>
                        <input type="text" class="form-control" id="editPhone" name="editPhone" placeholder="Enter Your Phone">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <label for="EnterYourGender" class="form-label">EMP Gender</label>
                        &nbsp;
                        Male : <input type="radio" name="gender" id="male" value="1">
                        &nbsp;&nbsp;
                        Female : <input type="radio" name="gender" id="female" value="0">
                    </div>
                    <div class="form-group" style="margin-top:10px">
                        <button type="button" id="btn_update" class="btn btn-outline-primary">Update</button>
                    </div>
                </form>
                <!-- bootstrap modal body end section -->
            </div>
        </div>
    </div>
</div>
<!-- bootstrap modal end -->




<script>
    $(document).ready(function() {

        //beginning of view emp data according to the selected page no
        function fetch_data(page) {
            $.ajax({
                url: "../routes/emp/viewEmpData.php",
                method: "POST",
                data: {
                    page: page
                },
                success: function(data) {
                    $("#get_data").html(data);
                }
            });
        }
        fetch_data();
        $(document).on("click", ".page-item", function() {
            var page = $(this).attr("id");
            fetch_data(page);
        })
        // end of view script


        // beginning of Search and show results
        function load_data(page, key = "") {
            $.ajax({
                url: "../routes/emp/searchEmpData.php",
                method: "POST",
                data: {
                    page: page,
                    key: key
                },
                success: function(data) {
                    $("#get_data").html(data);
                }
            });
        }
        // TO pass the key and first page (show first page results)
        $("#searchValue").on('input', function() {
            var key = $(this).val();
            load_data(1, key);
        });
        // To pass the selected page value and key(show result according to the page)
        $(document).on("click", ".page-item", function() {
            var page = $(this).attr("id");
            var key = $("#searchValue").val();
            load_data(page, key);
        });
        // end of search script


        // beginning of FETCH USER script
        $(document).on("click", ".edit_btn", function() {
            // alert("Hello");
            $empId = $(this).attr("id");
            // alert($empId);
            $.ajax({
                url: "../routes/emp/fetchUser.php",
                method: "POST",
                data: {
                    empId: $empId
                },
                dataType: "json",
                success: function(data) {
                    //  console.log(data);
                    $("#editId").val(data.emp_id);
                    $("#editName").val(data.emp_name);
                    $("#editEmail").val(data.emp_email);
                    $("#editPhone").val(data.emp_phone);
                    $gen = data.emp_gender;
                    // console.log($gen);
                    if ($gen == "1") {
                        $("#male").prop("checked", true);
                    } else {
                        $("#female").prop("checked", true);
                    }
                    var path = data.img_path;
                    // $("#imgpath").val(path);
                    // var pathNew = path.substring(11);
                    // console.log(pathNew);

                    // $("#editProfilePic").show(pathNew);

                    $('#profilePicturePreview').attr("style", "height:150px;width:150px;margin-top:8px");
                    $("#profilePicturePreview").attr('src', '../' + path);

                    $("#exampleModal").modal('show');
                }
            });
            $("#closeModal").click(function() {
                $("#exampleModal").modal('hide');
            })

            // UPDATE
            $(document).on("click", "#btn_update", function(e) {
                e.preventDefault();
                var form = $('#userEditForm')[0];
                var formData = new FormData(form);
                // console.log(formData);
                $.ajax({
                    url: "../routes/emp/updateEmpData.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data) {
                        alert(data);
                    }
                })
                $("#exampleModal").modal('hide');
            });

            // profile picture preview
            $('#editProfilePic').change(function() {
                var read = new FileReader();
                read.onload = function(e) {
                    $('#profilePicturePreview').attr("src", e.target.result);
                    $('#profilePicturePreview').attr("style", "height:150px;width:150px;margin-top:8px");
                }
                read.readAsDataURL(this.files[0]);
            })
        });


        // DELETE(ACTIVE/DEACTIVE)
        $(document).on("click", ".delete-btn", function() {
            $empId = $(this).attr("id");
            // alert($empId);
            if (confirm("Do you want to change login access of the user? ")) {
                $.ajax({
                    url: "../routes/emp/actDeactUser.php",
                    method: "POST",
                    data: {
                        empId: $empId
                    },
                    success: function(data) {
                        alert(data);
                    }
                })
            }
        });

        $(document).on("click", "#btn_back", function() {
            $("#root").load('emp/chooseEmpTask.php');
        })


    })
</script>