<style>
    thead {
        background-color: #333;
        color: #fff;
        font-weight: 500;
    }

    #letterheadContainer {
        background-color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 50px;
        position: relative;
    }

    #letterHead {
        /* overflow: hidden;  */
        background-image: url('../images/depotLH.png');
        background-size: cover;
        align-items: center;
        height: 190px;
        width: 586px;
        position: absolute;
        top: 0;
        left: 0;
        /* z-index: 2; */
        padding-right: -20px;
    }

    #reportContainer {
        position: relative;
        text-align: center;
        width: 75%;
        margin: auto;
        padding-top: 220px;
        padding-bottom: 70px;
        /* Adjust the top padding to create space below the letterHead */
    }

    .chart-legend {
        list-style-type: none;
        display: flex;
        justify-content: center;
        padding: 0;
    }

    .chart-legend-item {
        display: flex;
        align-items: center;
        margin-right: 20px;
    }

    .chart-legend-color {
        width: 20px;
        height: 20px;
        margin-right: 5px;
    }
</style>
<div class="row">
    <div class="col-md-2"></div>
    <div id="letterheadContainer" class="col-md-7">
        <div class="" id="letterHead"></div>
        <div id="reportContainer" class="text-center">
            <h3 style="align-content: center;">Quotations for the</h3>
            <h4 id="itm" style="align-content: center;"></h4><br>
            <h6 id="dt" style="align-content: center;"></h6><br>
            <canvas id="chart"></canvas>
            <ul class="chart-legend"></ul>
            <br>
            <div class="row"> Signature: ....................</div>
        </div>

    </div>
    <div class="col-md-1"></div>
    <div class="col-2">
        <a href="" class="btn btn-success btn-lg pull-left no-print mb-2" title="print" onclick="window.print();">Print Report</a>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {

        // var today = new Date();
        // var dd = today.getDate();
        // var mm = today.getMonth() + 1;
        // var yyyy = today.getFullYear();
        // if (dd < 10) {
        //     dd = '0' + dd;
        // }
        // if (mm < 10) {
        //     mm = '0' + mm;
        // }
        // $tday = yyyy + '-' + mm + '-' + dd;
        
        $("#dt").text($date);

        //get RFQ item no & name
        $.ajax({
            url: "../routes/stockKeeper/getRfqItemNo.php",
            method: "POST",
            data: {
                rId: $rId,
            },
            success: function(data) {
                $("#itm").text(data);
            }
        });


        // $('#std').text("From " + $stdateC + " To " + $endateC);

        $.ajax({
            url: '../routes/report/sk/quotations.php',
            method: 'POST',
            data: {
                rId: $rId,
                date: $date,
            },
            success: function(response) {
                console.log(response);

                // Extract the category and total_issues data from the response
                var suppliers = response.map(function(item) {
                    return item.supplier;
                });

                var unitPrices = response.map(function(item) {
                    return item.unitPrice;
                });

                // Generate random colors for each bar
                var colors = [];
                for (var i = 0; i < suppliers.length; i++) {
                    var color = getRandomColor();
                    colors.push(color);
                }

                // Create a bar chart using Chart.js
                var chartContainer = document.getElementById("chart").getContext("2d");
                var chart = new Chart(chartContainer, {
                    type: 'bar',
                    data: {
                        labels: suppliers,
                        datasets: [{
                            label: 'Unit Prices',
                            data: unitPrices,
                            backgroundColor: colors,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Suppliers'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Unit Price in Rs'
                                },
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: false,
                                text: 'Chart Title'
                            }
                        }
                    }
                });

                // Generate legend
                var legendContainer = document.querySelector(".chart-legend");
                categories.forEach(function(category, index) {
                    var legendItem = document.createElement("li");
                    legendItem.classList.add("chart-legend-item");

                    var legendColor = document.createElement("span");
                    legendColor.classList.add("chart-legend-color");
                    legendColor.style.backgroundColor = colors[index];

                    var legendLabel = document.createElement("span");
                    legendLabel.textContent = category;

                    legendItem.appendChild(legendColor);
                    legendItem.appendChild(legendLabel);
                    legendContainer.appendChild(legendItem);
                });
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });

    // Function to generate a random color
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>