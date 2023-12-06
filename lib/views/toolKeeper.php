<?php
// include admin style script
include_once("../include/admin_style.php");
// include vertical navbar
include_once("../include/tk_nav.php");
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


<div id="TKroot"></div>

<script>
    $(document).ready(function() {

        $("#task").click(function() {
            $("#TKroot").load('toolKeeper/manageTools.php');
        });

        $("#notify").click(function() {
            $("#TKroot").load('notification/tk/viewNotifications.php');
        });

        $("#report").click(function() {
            $("#TKroot").load('report/tk/chooseReport.php');
        });


        $.ajax({
            url: "../routes/notification/tk/tkNotification.php",
            method: "POST",
            success: function(res) {
                $("#countNotification").text(res);
            }
        });



    });
</script>