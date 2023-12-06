<div class="card no-print">
    <div class="card-header">
        Manage User Roles
    </div>
    <div class="card-body">
        <form class="row g-3">
            <div class="col-auto">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Choose Emp Role">
            </div>
            <div class="col-auto">
                <select name="empRole" id="empRole" class="form-select">
                    <option value="">--Choose Role--</option>
                    <option value="admin">Dep Section Head</option>
                    <option value="depot_engineer">Depot Engineer</option>
                    <option value="foreman">Foreman</option>
                    <option value="driver">Driver</option>
                    <option value="conductor">Conductor</option>
                    <option value="technician">Technician</option>
                    <option value="stock_keeper">Stock Keeper</option>
                    <option value="tool_keeper">Tool Keeper</option>
                </select>
            </div>
            <!-- <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Confirm</button>
            </div> -->
        </form>
    </div>
</div>

<div id="loginMngLoad"></div>

<script>
    $(document).ready(function() {
        $("#empRole").change(function() {
            let value = $(this).val();
            // alert(value);
            switch (value) {
                case "admin":
                    $("#loginMngLoad").load('emp/loginManagement/loginMng.php?role=' + value);
                    break;
                case "depot_engineer":
                    $("#loginMngLoad").load('emp/loginManagement/loginMng.php?role=' + value);
                    break;
                case "forman":
                    $("#loginMngLoad").load('emp/loginManagement/loginMng.php?role=' + value);
                    break;
                case "driver":
                    $("#loginMngLoad").load('emp/loginManagement/loginMng.php?role=' + value);
                    break;
                case "conductor":
                    $("#loginMngLoad").load('emp/loginManagement/loginMng.php?role=' + value);
                    break;
                case "technician":
                    $("#loginMngLoad").load('emp/loginManagement/loginMng.php?role=' + value);
                    break;
                case "stock_keeper":
                    $("#loginMngLoad").load('emp/loginManagement/loginMng.php?role=' + value);
                    break;
                default:

                    break;
            }
        })
    })
</script>