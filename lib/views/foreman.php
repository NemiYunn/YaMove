<?php
// include admin style script
include_once("../include/admin_style.php");
// include vertical navbar
include_once("../include/foreman_nav.php");
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


<div id="Froot"></div>

<script>
    $(document).ready(function() {

        // notifications
        $.ajax({
            url: "../routes/notification/foreman/countNotification.php",
            method: "POST",
            success: function(res) {
                $("#countNotification").text(res);
            }
        });

        $("#notify").click(function() {
            $("#Froot").load('notification/fmn/chooseNotify.php');
        });


    });
</script>