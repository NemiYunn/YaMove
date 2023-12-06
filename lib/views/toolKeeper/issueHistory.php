<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Tool Issueing History
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-1">
                <a href="" class="btn btn-outline-success btn-md pull-left no-print mb-2" title="print" onclick="window.print();">Print</a>
            </div>
        </div>

        <div class="row no-print mb-3">
            <div class="col-3">
                <!-- <label for="search" class="vissually-hidden">Search</label> -->
                <input type="search" class="form-control " id="searchValue" placeholder="Search">
            </div>
            <div class="col-6"> </div>
            <div class="col-3">
            </div>
        </div>
        <div id="get_data" class=" text-center">

        </div>
        <br><br>
        <div class="row">
            <div class="col-md-9">
                <button class="btn btn-primary no-print" id="btn_back" style="position:absolute; left:10px;bottom:10px;"> Back </button>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        //beginning of view data according to the selected page no
        function fetch_data(page) {
            $.ajax({
                url: "../routes/toolKeeper/viewToolHistory.php",
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
        });


        // beginning of Search and show results
        function load_data(page, key = "") {
            $.ajax({
                url: "../routes/toolKeeper/searchToolHistory.php",
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
        $(document).on("click", ".page-items", function() {
            var page = $(this).attr("id");
            var key = $("#searchValue").val();
            load_data(page, key);
        });


        
        // return
        $(document).on("click", ".rtn_btn", function() {
            $Id = $(this).attr("id");
            // $("#deleteBus").modal('show');
            Swal.fire({
                title: 'Are you sure they return same quantity as isued?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Returned!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "../routes/toolKeeper/returnedTool.php",
                        method: "POST",
                        data: {
                            Id: $Id
                        },
                        success: function(data) {
                            if (data == 1) {
                                Swal.fire(
                                    '',
                                    'Status changed successfully!',
                                    'success'
                                )
                               
                            }
                        }
                    });
                }
                $(this).text('Returned');
                $(this).removeClass('btn-outline-danger').addClass('btn-success'); 
            })
        });

         // go back
         $(document).on("click", "#btn_back", function() {
            $("#TKroot").load('toolKeeper/manageTools.php');
        })



    });

</script>