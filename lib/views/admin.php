<?php
// include admin style script
include_once("../include/admin_style.php");
// include vertical navbar
include_once("../include/ver_navbar.php");
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


<div id="root"></div>


<script>
    $(document).ready(function() {
        $("#manageEmp").click(function() {
            $("#root").load('emp/chooseEmpTask.php');
        });

        $("#manageBus").click(function() {
            $("#root").load('bus/manageBuses.php');
        });

        $("#manageSchedule").click(function() {
            $("#root").load('sch/chooseScheduleTask.php');
        });

        $("#manageSecFare").click(function() {
            $("#root").load('secFare/manageSecFare.php');
        });

        $("#notify").click(function() {
            $("#root").load('notification/adminNotify/chooseNotify.php');
        });

        $("#custom").click(function() {
            $("#root").load('report/admin/chooseCustomReport.php');
        });
        
        $("#daily").click(function() {
            $("#root").load('report/admin/chooseDailyReport.php');
        });
        
        // $("#mthReservation").click(function() {
        //     $("#root").load('report/admin/monthlyReservation.php');
        // });

        // $("#try").click(function() {
        //     $("#root").load('report/admin/tryReport.php');
        // });

    });

    $.ajax({
        url: "../routes/notification/admin/adminNotification.php",
        method: "POST",
        success: function(res) {
            $("#countNotification").text(res);
        }
    });



</script>