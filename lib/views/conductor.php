<?php
// include admin style script
include_once("../include/admin_style.php");
// include vertical navbar
include_once("../include/conductor_nav.php");
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


<div id="Croot"></div>

<script>
    $(document).ready(function() {
        $("#reservation").click(function() {
            $("#Croot").load('conductor/reservation.php');
        });

        $("#Roster").click(function() {
            $("#Croot").load('conductor/viewRoster.php');
        });
        $("#Trip").click(function() {
            $("#Croot").load('conductor/viewTrips.php');
        });

        $("#Breakdown").click(function() {
            $("#Croot").load('conductor/addBreakdowns.php');
        });

        $("#location").click(function() {
            $("#Croot").load('conductor/addLocation.php');
        });


        // notifications
        $.ajax({
            url: "../routes/notification/conductor/countNotification.php",
            method: "POST",
            success: function(res) {
                $("#countNotification").text(res);
            }
        });

        $("#notify").click(function() {
            $("#Croot").load('notification/conductor/condNotification.php');
        });

        $.ajax({
                url: "../routes/conductor/getEmpId.php",
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