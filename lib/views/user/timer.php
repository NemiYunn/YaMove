
<body>
    <div id="timer">
        <i class="fa fa-clock-o" id="timer-icon" aria-hidden="true" style=" margin-right: 5px;"></i>
        <span id="timer-value"></span>
    </div>

    <script>
        $(document).ready(function() {
            // Set the timer duration in minutes
            const duration = 10;
            
            // Calculate the end time
            const endTime = new Date();
            endTime.setMinutes(endTime.getMinutes() + duration);

            // Update the timer every second
            const timerInterval = setInterval(updateTimer, 1000);

            function updateTimer() {
                // Get the current time
                const currentTime = new Date();

                // Calculate the remaining time in seconds
                const remainingTime = Math.floor((endTime - currentTime) / 1000);

                // Check if the timer has ended
                if (remainingTime <= 0) {
                    clearInterval(timerInterval);
                    $("#timer-value").text("Timer Ended!");
                    $("#payment").load("user/paymentTimeout.php");
                } else {
                    // Format the remaining time into minutes and seconds
                    const minutes = Math.floor(remainingTime / 60);
                    const seconds = remainingTime % 60;

                    // Display the remaining time
                    $("#timer-value").text(`You have ${minutes}:${seconds.toString().padStart(2, '0')} remaining for this payment.`);
                }
            }
        });
    </script>