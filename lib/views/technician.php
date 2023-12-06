<?php
// include admin style script
include_once("../include/admin_style.php");
// include vertical navbar
include_once("../include/tcn_nav.php");
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


<div id="TCNroot"></div>

<script>
    $(document).ready(function() {

        $("#notify").click(function() {
            $("#TCNroot").load('notification/tcn/chooseNotify.php');
        });

        $("#sItms").click(function() {
            $("#TCNroot").load('technician/searchItems.php');
        });
        
        $("#sTls").click(function() {
            $("#TCNroot").load('technician/searchTools.php');
        });

        $("#wrks").click(function() {
            $("#TCNroot").load('technician/viewStartedWorks.php');
        });


        //count all breakdowns + maintenance + lateRetuns (for their empId)
        $.ajax({
        url: "../routes/notification/tcn/tcnNotification.php",
        method: "POST",
        success: function(res) {
            $("#countNotification").text(res);
        }
    });


    });
</script>