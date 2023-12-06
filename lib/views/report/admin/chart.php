<!DOCTYPE html>
<html>
<head>
    <title>Column Chart Example</title>
    <!-- Include Highcharts library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>
    <!-- Container element to render the chart -->
    <div id="columnChartContainer" style="height: 400px;"></div>

    <script>
        // JavaScript code to render the column chart
        $(function() {
            var data = [25, 60, 23, 55];

            $('#columnChartContainer').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Column Chart'
                },
                xAxis: {
                    categories: ['Category 1', 'Category 2', 'Category 3', 'Category 4']
                },
                yAxis: {
                    title: {
                        text: 'Value'
                    }
                },
                series: [{
                    name: 'Column Chart',
                    data: data
                }]
            });
        });
    </script>
</body>
</html>