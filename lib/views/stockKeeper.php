<?php
// include admin style script
include_once("../include/admin_style.php");
// include vertical navbar
include_once("../include/sk_nav.php");
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


<div id="SKroot"></div>

<script>
    $(document).ready(function() {

        $("#task").click(function() {
            $("#SKroot").load('stockKeeper/chooseTask.php');
        });

        $("#notify").click(function() {
            $("#SKroot").load('notification/sk/viewNotifications.php');
        });

        $("#custom").click(function() {
            $("#SKroot").load('report/sk/chooseCustomReport.php');
        });
        
        $("#daily").click(function() {
            $("#SKroot").load('report/sk/chooseDailyReport.php');
        });


        $.ajax({
        url: "../routes/notification/sk/skNotification.php",
        method: "POST",
        success: function(res) {
            $("#countNotification").text(res);
        }
    });


    });
</script>