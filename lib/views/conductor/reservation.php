<div class="card col-auto text-dark bg-light border-info">
    <div class="card-header no-print">
        Manage Reservations
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-1">
                <a href="" class="btn btn-outline-success btn-md pull-left no-print mb-2" title="print" onclick="window.print();">Print</a>
            </div>
        </div>
        <br>
        <div class="row no-print mb-3">
            <div class="col-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchValue" placeholder="Search by Ref.No or SeatNo">
                    <!-- <button class="btn btn-primary" type="button" id="searchButton"><i class="fa fa-search"></i></button> -->
                </div>
            </div>
            <div class="col-7">

            </div>
            <div class="col-2">

            </div>
        </div>
        <div id="get_data" class="table-responsive-md text-center">

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        //beginning of view res data according to the selected page no
        function fetch_data(page) {
            $.ajax({
                url: "../routes/conductor/viewReservation.php",
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


        // beginning of Search and show results
        function load_data(page, key = "") {
            $.ajax({
                url: "../routes/conductor/searchReservation.php",
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
            var key = $("#searchValue").val();
            load_data(1, key);
        });
        // To pass the selected page value and key(show result according to the page)
        $(document).on("click", ".page-items", function() {
            var page = $(this).attr("id");
            var key = $("#searchValue").val();
            load_data(page, key);
        });

        // click confirm and set resStatus to 0
        $(document).on("click", ".conBtn", function() {
            var id = $(this).attr("id");
            Swal.fire({
                title: 'Do you want to confirm seat?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $(this).removeClass("btn-outline-primary").addClass("btn-success").text("CHECKED");
                    $.ajax({
                        url: "../routes/conductor/confirmReservation.php",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            console.log(data);
                            Swal.fire('Confirmed!', '', 'success');
                        }
                    });   
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })

        });



    });
</script>