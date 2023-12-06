<?php
// include admin style script
include_once("../include/admin_style.php");
// include vertical navbar
include_once("../include/driver_nav.php");
// include main content
include_once("../include/admin_interface.php");

?>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>


<div id="Droot"></div>

<script>
    $(document).ready(function() {

        $("#Roster").click(function() {
            $("#Droot").load('driver/viewRoster.php');
        });
        $("#Trip").click(function() {
            $("#Droot").load('driver/viewTrips.php');
        });

        $.ajax({
            url: "../routes/notification/driver/countNotification.php",
            method: "POST",
            success: function(res) {
                $("#countNotification").text(res);
            }
        });

        $("#notify").click(function() {
            $("#Droot").load('notification/driver/drvNotification.php');
        });


        
        $.ajax({
                url: "../routes/driver/getEmpId.php",
                method: "POST",
                data: {},
                dataType: "json",
                success: function(data) {
                    $('#employeeName').text(data.emp_name);
                    $('#employeeId').text(data.emp_id);
                }
        })


    });
</script>